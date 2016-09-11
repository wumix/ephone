<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/7/2015
 * Time: 3:55 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                     =   array( 'status' => 1 );

if(!isReady($_SESSION, array('loggedin', 'username', 'uid'))){
    dj($output);
}

$getUserQuery               =   $db->prepare("SELECT * FROM users WHERE id = :id");
$getUserQuery->execute(array(
    ":id"                   =>  $_SESSION['uid']
));
$getUserRow                 =   $getUserQuery->fetch(PDO::FETCH_ASSOC);

unset($getUserRow["pass"]);
unset($getUserRow["login_token"]);
unset($getUserRow["token_exp"]);
unset($getUserRow["ip"]);

$output['status']           =   2;
$output['user']             =   $getUserRow;
dj($output);