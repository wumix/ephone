<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/19/2015
 * Time: 1:42 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   1;

if(!isReady($params,array('pid'))){
    dj($output);
}

$pid                    =   intval($params['pid']);
$uid                    =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;

$getPlaylistQuery       =   $db->prepare("SELECT * FROM playlists WHERE id = :pid");
$getPlaylistQuery->execute(array(
    ":pid"              =>  $pid
));

if($getPlaylistQuery->rowCount() === 0){
    dj($output);
}

$playlistRow            =   $getPlaylistQuery->fetch(PDO::FETCH_ASSOC);
$getPlaylistTracksQuery =   $db->prepare("
SELECT tracks.*
FROM playlist_tracks
INNER JOIN tracks
ON playlist_tracks.tid=tracks.id
WHERE pid = :pid
");
$getPlaylistTracksQuery->execute(array(
    ":pid"              =>  $pid
));

$playlistLikeQuery      =   $db->prepare("SELECT COUNT(*) as `isOrange` FROM playlist_likes WHERE uid = :uid AND pid = :pid");
$playlistLikeQuery->execute(array(
    ":uid"              =>  $uid,
    ":pid"              =>  $pid
));
$playlistLikeRow        =   $playlistLikeQuery->fetch();

// Artist
$artistQuery            =   $db->prepare("SELECT `username`,`display_name` FROM users WHERE id = :uid");
$artistQuery->execute(array(
    ":uid"              =>  $playlistRow['uid']
));

$output['playlist']     =   $playlistRow;
$output['artist']       =   $artistQuery->fetch(PDO::FETCH_ASSOC);
$output['isOrange']     =   $playlistLikeRow['isOrange'];
$output['tracks']       =   $getPlaylistTracksQuery->fetchAll(PDO::FETCH_ASSOC);
$output['status']       =   2;
dj($output);