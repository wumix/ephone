<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/18/2015
 * Time: 7:26 PM
 */

require( '../inc/db.php' );
include( '../inc/func.inc.php' );

$params                 =   json_decode(file_get_contents('php://input'), true);
$output                 =   array();
$output['status']       =   1;

if(!isReady($params, array('id'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$pid                    =   intval($params['id']);
$checkLikeQuery         =   $db->prepare("SELECT * FROM playlist_likes WHERE uid = :uid AND pid = :pid");
$checkLikeQuery->execute(array(
    ":uid"              =>  $_SESSION['uid'],
    ":pid"              =>  $pid
));

if($checkLikeQuery->rowCount() > 0){
    $playlistLikeQuery      =   $db->prepare("DELETE FROM playlist_likes WHERE uid = :uid AND pid = :pid");
    $updatePlaylistQuery    =   $db->prepare("UPDATE playlists SET like_count = like_count - 1 WHERE id = :pid");
    $output['status']       =   2;
}else{
    $playlistLikeQuery      =   $db->prepare("INSERT INTO playlist_likes(uid,pid) VALUES( :uid, :pid )");
    $updatePlaylistQuery    =   $db->prepare("UPDATE playlists SET like_count = like_count + 1 WHERE id = :pid");
    $output['status']       =   3;
}

$playlistLikeQuery->execute(array(
    ":uid"              =>  $_SESSION['uid'],
    ":pid"              =>  $pid
));

$updatePlaylistQuery->execute(array(
    ":pid"              =>  $pid
));

dj($output);