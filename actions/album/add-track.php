<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/19/2016
 * Time: 6:12 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                             =   array( 'album_tracks' => array() );
$params                             =   get_params();

if( !isset($_SESSION['loggedin']) || !isReady($params, array('aid', 'tid')) ){
    dj($output);
}

$user                               =   get_user();
$getAlbumQuery                      =   $db->prepare("SELECT * FROM albums WHERE id = :aid AND uid = :uid");
$getAlbumQuery->execute(array(
    ":aid"                          =>  $params['aid'],
    ":uid"                          =>  $_SESSION['uid']
));

if($getAlbumQuery->rowCount() == 0){
    dj($output);
}

$getAlbumRow                        =   $getAlbumQuery->fetch(PDO::FETCH_ASSOC);

// Check if track is already added
$checkTrackAlbumQuery               =   $db->prepare("SELECT * FROM album_tracks WHERE aid = :aid AND tid = :tid AND uid = :uid");
$checkTrackAlbumQuery->execute(array(
    ":aid"                          =>  $params['aid'],
    ":tid"                          =>  $params['tid'],
    ":uid"                          =>  $_SESSION['uid']
));

if($checkTrackAlbumQuery->rowCount() == 0){
    $insertTrackAlbumQuery          =   $db->prepare("INSERT INTO album_tracks(aid,tid,uid) VALUES( :aid, :tid, :uid )");
    $insertTrackAlbumQuery->execute(array(
        ":aid"                          =>  $params['aid'],
        ":tid"                          =>  $params['tid'],
        ":uid"                          =>  $_SESSION['uid']
    ));
}

// Album Tracks
$albumTracksQuery                   =   $db->prepare("
    SELECT *
    FROM album_tracks
    INNER JOIN tracks
    ON album_tracks.tid=tracks.id
    WHERE aid = :aid
");
$albumTracksQuery->execute(array(
    ":aid"                          =>  $params['aid']
));

$album_tracks                       =   $albumTracksQuery->fetchAll(PDO::FETCH_ASSOC);
$zip_tracks                         =   array();
$album_dir                          =   $user['upl_dir'] . '/' . $getAlbumRow['title'] . '.zip';

foreach($album_tracks as $ak => $av){
    array_push( $zip_tracks, '../../uploads/' . $av['upl_dir']);
}

create_zip( $zip_tracks, '../../uploads/' . $album_dir , true );

$output['album_tracks']             =   $album_tracks;
dj($output);