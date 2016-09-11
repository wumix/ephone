<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/3/2015
 * Time: 5:22 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params, array('code')) || isset($_SESSION['loggedin']) ){
    dj($output);
}

$code                   =   secure($params['code']);
$new_pass               =   get_random_string( mt_rand( 12, 18 ) );
$new_pass_hash          =   secure($new_pass,true);

$checkCodeQuery         =   $db->prepare("SELECT `username` FROM reset_keys WHERE key_code = :code
                                          AND isReset='1' AND time_expires > :t");
$checkCodeQuery->execute(array(
    ":code"             =>  $code,
    ":t"                =>  time()
));

if($checkCodeQuery->rowCount() !== 1){
    dj($output);
}

$checkCodeRow           =   $checkCodeQuery->fetch();

$updateUserQuery        =   $db->prepare("UPDATE users SET pass = :pass WHERE username = :username");
$updateUserQuery->execute(array(
    ":pass"             =>  $new_pass_hash,
    ":username"         =>  $checkCodeRow['username']
));

$getUserQuery           =   $db->prepare("SELECT `email` FROM users WHERE username = :username");
$getUserQuery->execute(array(
    ":username"         =>  $checkCodeRow['username']
));
$getUserRow             =   $getUserQuery->fetch();

$email_template         =   @file_get_contents("../../inc/reset-password-email.php");
$email_template         =   str_replace("SITE_NAME", $settings['site_domain'], $email_template);
$email_template         =   str_replace("NEW_PASSWORD", $new_pass, $email_template);
$headers                =   'MIME-Version: 1.0' . "\r\n";
$headers                .=  'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers                .=  'From: ' . $settings['site_name'] . ' <no-reply@' . $settings['site_domain'] . '>' . "\r\n";

if(!mail($getUserRow['email'], "Your New Password", $email_template, $headers)){
    dj($output);
}

$updateCodeQuery        =   $db->prepare("UPDATE reset_keys SET isReset='2' WHERE
                                      key_code = :code AND isReset='1' AND time_expires > :t");
$updateCodeQuery->execute(array(
    ":code"             =>  $code,
    ":t"                =>  time()
));

$output['status']       =   2;
dj($output);