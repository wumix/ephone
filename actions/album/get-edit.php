<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/17/2016
 * Time: 5:51 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                             =   array( 'status' => 1 );
$params                             =   get_params();

if( !isset($_SESSION['loggedin']) ){
    dj($output);
}

$getAlbumQuery                      =   $db->prepare("SELECT * FROM albums WHERE id = :aid AND uid = :uid");
$getAlbumQuery->execute(array(
    ":aid"                          =>  $params['id'],
    ":uid"                          =>  $_SESSION['uid']
));

if($getAlbumQuery->rowCount() == 0){
    dj($output);
}

// User Tacks
$userTracksQuery                    =   $db->prepare("SELECT * FROM tracks WHERE uid = :uid");
$userTracksQuery->execute(array(
    ":uid"                          =>  $_SESSION['uid']
));
$userTracksRow                      =   $userTracksQuery->fetchAll(PDO::FETCH_ASSOC);

// Album Tracks
$albumTracksQuery                   =   $db->prepare("
    SELECT *
    FROM album_tracks
    INNER JOIN tracks
    ON album_tracks.tid=tracks.id
    WHERE aid = :aid
");
$albumTracksQuery->execute(array(
    ":aid"                          =>  $params['id']
));

$getAlbumRow                        =   $getAlbumQuery->fetch(PDO::FETCH_ASSOC);
$output['status']                   =   2;
$output['album']                    =   $getAlbumRow;
$output['tracks']                   =   $userTracksRow;
$output['album_tracks']             =   $albumTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);