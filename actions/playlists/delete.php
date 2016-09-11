<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/6/2015
 * Time: 12:17 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   1;

if(!isReady($params, array('id'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$id                     =   intval($params['id']);
$updatePlaylistQuery    =   $db->prepare("DELETE FROM playlists WHERE id = :pid AND uid = :uid");
$updatePlaylistQuery->execute(array(
    ":pid"              =>  $id,
    ":uid"              =>  $_SESSION['uid']
));

$output['status']       =   2;
dj($output);