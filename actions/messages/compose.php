<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/21/2015
 * Time: 10:50 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params, array('message','user')) || !isset($_SESSION['loggedin']) ){
    dj($output);
}

$message                =   substr(secure($params['message']),0,500);
$user                   =   secure($params['user']);

$checkUserQuery         =   $db->prepare("SELECT `username` FROM users
                                          WHERE username = :username AND username != :sender");
$checkUserQuery->execute(array(
    ":username"         =>  $user,
    ":sender"           =>  $_SESSION['username']
));

if($checkUserQuery->rowCount() !== 1){
    dj($output);
}

$insertMessageQuery     =   $db->prepare("INSERT INTO messages(message,from_user,to_user,time_created)
                                          VALUES( :m, :fu, :tu, :tc )");
$insertMessageQuery->execute(array(
    ":m"                =>  $message,
    ":fu"               =>  $_SESSION['username'],
    ":tu"               =>  $user,
    ":tc"               =>  time()
));

$output['status']       =   2;
dj($output);