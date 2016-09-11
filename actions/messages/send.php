<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/24/2015
 * Time: 12:07 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params, array('message', 'username')) || !isset($_SESSION['loggedin']) ){
    dj($output);
}

$message                =   secure($params['message']);
$username               =   secure($params['username']);

$checkUserQuery         =   $db->prepare("SELECT `username` FROM users WHERE username = :username");
$checkUserQuery->execute(array(
    ":username"         =>  $username
));
if($checkUserQuery->rowCount() !== 1){
    dj($output);
}

$insertMessageQuery     =   $db->prepare("INSERT INTO messages(message,from_user,to_user,time_created)
                                          VALUES( :m, :fu, :tu, :tc )");
$insertMessageQuery->execute(array(
    ":m"                =>  $message,
    ":fu"               =>  $_SESSION['username'],
    ":tu"               =>  $username,
    ":tc"               =>  time()
));

$output['status']       =   2;
dj($output);