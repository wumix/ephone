<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/16/2015
 * Time: 4:53 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   1;

if(!isReady($params, array('name'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$name                   =   secure($params['name']);

$insertPlaylistQuery    =   $db->prepare("INSERT INTO playlists(uid,playlist_name) VALUES( :uid, :pn )");
$insertPlaylistQuery->execute(array(
    ":uid"              =>  $_SESSION['uid'],
    ":pn"               =>  $name
));

$output['status']       =   2;
$output['playlist']     =   array(
    "id"                =>  $db->lastInsertId(),
    "uid"               =>  $_SESSION['uid'],
    "playlist_name"     =>  $name,
    "playlist_type"     =>  1
);
dj($output);