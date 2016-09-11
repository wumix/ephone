<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/22/2015
 * Time: 5:17 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params, array('username')) || !isset($_SESSION['loggedin']) ){
    dj($output);
}

$username               =   secure($params['username']);
$getMessagesQuery       =   $db->prepare("SELECT * FROM messages
                                          WHERE (from_user = :u1 AND to_user = :u2)
                                          OR ( from_user = :u2 AND to_user = :u1 )
                                          LIMIT 50");
$getMessagesQuery->execute(array(
    ":u1"               =>  $_SESSION['username'],
    ":u2"               =>  $username
));
$getMessagesRow         =   $getMessagesQuery->fetchAll(PDO::FETCH_ASSOC);

$updateMessagesQuery    =   $db->prepare("UPDATE messages SET isRead='2' WHERE from_user = :u1 AND to_user = :u2");
$updateMessagesQuery->execute(array(
    ":u1"               =>  $username,
    ":u2"               =>  $_SESSION['username']
));

$output['messages']     =   $getMessagesRow;
$output['status']       =   2;
dj($output);