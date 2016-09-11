<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/7/2015
 * Time: 8:08 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   2;
$output['message']      =   "User doesn't exist.";

if(!isReady($params, array('username')) || isset($_SESSION['loggedin'])){
    dj($output);
}

$username               =   secure($params['username']);
$code                   =   get_random_string( 16 );
$usernameCheckQuery     =   $db->prepare("SELECT `email` FROM users WHERE username = :username");
$usernameCheckQuery->execute(array(
    ":username"         =>  $username
));

if($usernameCheckQuery->rowCount() === 0){
    dj($output);
}

$usernameCheckRow       =   $usernameCheckQuery->fetch();

$insertKeyQuery         =   $db->prepare("INSERT INTO reset_keys(username,key_code,time_expires)
                                          VALUES( :un, :kc, :te )");
$insertKeyQuery->execute(array(
    ":un"               =>  $username,
    ":kc"               =>  $code,
    ":te"               =>  ( time() + 86400 )
));

$email_template         =   @file_get_contents("../../inc/reset-email.php");
$email_template         =   str_replace("SITE_NAME", $settings['site_domain'], $email_template);
$email_template         =   str_replace("SPECIAL_CODE", $code, $email_template);
$headers                =   'MIME-Version: 1.0' . "\r\n";
$headers                .=  'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers                .=  'From: ' . $settings['site_name'] . ' <no-reply@' . $settings['site_domain'] . '>' . "\r\n";

mail($usernameCheckRow['email'], "Reset Your Password", $email_template, $headers);

$output['status']       =   1;
$output['message']      =   "An email has been sent with a reset key. Please click it to reset your password.";
dj($output);