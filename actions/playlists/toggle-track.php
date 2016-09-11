<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/16/2015
 * Time: 7:11 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   1;

if(!isReady($params,array('pid','tid'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$pid                    =   intval($params['pid']);
$tid                    =   intval($params['tid']);

$checkTrackQuery        =   $db->prepare("SELECT * FROM playlist_tracks WHERE pid = :pid
                                          AND tid = :tid AND uid = :uid");
$checkTrackQuery->execute(array(
    ":pid"              =>  $pid,
    ":tid"              =>  $tid,
    ":uid"              =>  $_SESSION['uid']
));

if($checkTrackQuery->rowCount() > 0){
    $toggleTrackQuery   =   $db->prepare("DELETE FROM playlist_tracks WHERE pid = :pid
                                          AND tid = :tid AND uid = :uid");
    $output['status']   =   2;
}else{
    $toggleTrackQuery   =   $db->prepare("INSERT INTO playlist_tracks(pid,tid,uid) VALUEs( :pid, :tid, :uid )");
    $output['status']   =   3;
}

$toggleTrackQuery->execute(array(
    ":pid"              =>  $pid,
    ":tid"              =>  $tid,
    ":uid"              =>  $_SESSION['uid']
));

dj($output);