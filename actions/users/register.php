<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 2/25/2015
 * Time: 9:08 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params         =   get_params();
$response       =   array();

if($settings['user_registration'] == 2){
    $response['status']     =   2;
    $response['message']    =   "Registration is disabled.";
    dj($response);
}

if(!isReady( $params, array( 'username', 'pass1', 'pass2', 'email', 'agree' ) )){
    $response['status']     =   2;
    $response['message']    =   "You must fill in all the fields and agree to our terms of service.";
    dj($response);
}

$username       =   secure($params['username']);
$pass1          =   secure($params['pass1'], true);
$pass2          =   secure($params['pass2'], true);
$email          =   secure($params['email']);
$ip             =   secure($_SERVER['REMOTE_ADDR']);
$header_img     =   "headers/" . mt_rand(1,9) . ".jpg";

if(strlen($username) < 1 || strlen($username) > 255 || !ctype_alnum($username)){
    $response['status']     =   2;
    $response['message']    =   "Invalid username! Usernames must be between 1 - 255 characters long and can only contain alphanumeric characters only!";
    dj($response);
}

if($pass1 !== $pass2){
    $response['status']     =   2;
    $response['message']    =   "Passwords don't match.";
    dj($response);
}

if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    $response['status']     =   2;
    $response['message']    =   "Invalid E-mail!";
    dj($response);
}

$usernameCheckQuery     =   $db->prepare("SELECT `id` FROM users WHERE username = :u");
$usernameCheckQuery->execute(array( ":u" => $username ));
if($usernameCheckQuery->rowCount() > 0){
    $response['status']     =   2;
    $response['message']    =   "Username taken. Please pick another.";
    dj($response);
}

$emailCheckQuery     =   $db->prepare("SELECT `id` FROM users WHERE email = :e");
$emailCheckQuery->execute(array( ":e" => $email ));
if($emailCheckQuery->rowCount() > 0){
    $response['status']     =   2;
    $response['message']    =   "E-mail taken. Please user another.";
    dj($response);
}

// Captcha Check
if($settings['captcha_enabled'] == 1 && !isReady($params, array('captcha'))){
    $response['status']     =   2;
    $response['message']    =   "Invalid Captcha.";
    dj($response);
}

// Create Directory
$user_dir           =   get_random_string(1, true) . "/" . mt_rand(1,10) . "/" . $username;
if ( !mkdir("../../uploads/" . $user_dir, 0777, true) ) {
    $response['status']     =   2;
    $response['message']    =   "Unable to create account. Please try again later.";
    dj($response);
}

$insertUserQuery    =   $db->prepare("INSERT INTO users(username,pass,email,ip,upl_dir,display_name,header_img,user_code) VALUES( :u, :p, :e, :i, :upl, :dn, :hi, :uc )");
$insertUserQuery->execute(array(
    ":u"    =>  $username,
    ":p"    =>  $pass1,
    ":e"    =>  $email,
    ":i"    =>  $ip,
    ":upl"  =>  $user_dir,
    ":dn"   =>  $username,
    ":hi"   =>  $header_img,
    ":uc"   =>  md5($username)
));

if($settings['validate_email'] == 1){
    $email_template     =   @file_get_contents("../../inc/email.php");
    $email_template     =   str_replace("SITE_NAME", $settings['site_domain'], $email_template);
    $email_template     =   str_replace("SPECIAL_CODE", md5($username), $email_template);

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: ' . $settings['site_name'] . ' <no-reply@' . $settings['site_domain'] . '>' . "\r\n";

    mail($email, "Welcome! Please confirm your e-mail", $email_template, $headers);
}else{
    $_SESSION['loggedin']   =   true;
    $_SESSION['username']   =   $username;
    $_SESSION['uid']        =   $db->lastInsertId();
}
$response['message']        =   "Your account has been created! You're being taken to the home page.";
$response['status']         =   1;
$response['username']       =   $username;
dj($response);