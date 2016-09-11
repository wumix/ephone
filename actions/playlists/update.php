<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/16/2015
 * Time: 4:15 PM
 */
require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   1;

if(!isReady($params, array('playlist_name', 'playlist_type'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$name                   =   secure($params['playlist_name']);
$type                   =   intval($params['playlist_type']);

$updatePlaylistQuery    =   $db->prepare("UPDATE playlists SET playlist_name = :pn,
                                                               playlist_type = :pt
                                          WHERE id = :pid AND uid = :uid");
$updatePlaylistQuery->execute(array(
    "pn"                =>  $name,
    ":pt"               =>  $type,
    ":pid"              =>  $params['id'],
    ":uid"              =>  $_SESSION['uid']
));

$output['status']       =   2;
dj($output);