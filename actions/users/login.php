<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 2/26/2015
 * Time: 5:43 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params         =   get_params();
$response       =   array();

if(!isReady( $params, array( 'username', 'pass' ) )){
    $response['status']     =   2;
    $response['message']    =   "You must fill in all the fields.";
    dj($response);
}

$username       =   secure($params['username']);
$pass           =   secure($params['pass'], true);

$userCheckQuery =   $db->prepare("SELECT * FROM users WHERE username = :username AND pass = :pass");
$userCheckQuery->execute(array(
    ":username" =>  $username,
    ":pass"     =>  $pass
));
if($userCheckQuery->rowCount() == 0){
    $response['status']     =   2;
    $response['message']    =   "Invalid username/password combination";
    dj($response);
}

$userCheckRow           =   $userCheckQuery->fetch();

$_SESSION['loggedin']   =   true;
$_SESSION['username']   =   $userCheckRow['username'];
$_SESSION['uid']        =   $userCheckRow['id'];

if($params['remember'] == "true"){
    $token              =   get_random_string( mt_rand(32,128) );
    $expires            =   time() + 15552000;
    $addTokenQuery      =   $db->prepare("UPDATE users SET login_token = :token, token_exp = :exp WHERE id = :id");
    $addTokenQuery->execute(array(
        ":token"    =>  $token,
        ":exp"      =>  $expires,
        ":id"       =>  $userCheckRow['id']
    ));
    setcookie( "PHO_TOKEN", $token, $expires, "/" );
}

if($userCheckRow['isAdmin'] == 2){
    $_SESSION['isAdmin']    =   true;
}

$response['status']         =   1;
$response['message']        =   "You are now logged in. You will be taken to the home page.";
$response['username']       =   $username;
dj($response);