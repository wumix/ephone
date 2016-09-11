<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/24/2015
 * Time: 3:57 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['messageCount'] =   0;

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$unreadCountQuery       =   $db->prepare("SELECT COUNT(*) as `messageCount` FROM messages
                                          WHERE isread='1' AND to_user = :username");
$unreadCountQuery->execute(array(
    ":username"         =>  $_SESSION['username']
));
$unreadCountRow         =   $unreadCountQuery->fetch();
$output['messageCount'] =   $unreadCountRow['messageCount'];
dj($output);