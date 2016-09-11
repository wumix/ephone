<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/14/2015
 * Time: 1:10 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params             =   get_params();

if(!isReady($params, array('id'))){
    die();
}

// Check if already played
$checkPlayQuery     =   $db->prepare("SELECT * FROM play_counts WHERE ip = :ip AND tid = :tid AND time_played > :tp");
$checkPlayQuery->execute(array(
    ":ip"       =>  $_SERVER['REMOTE_ADDR'],
    ":tid"      =>  $params['id'],
    ":tp"       =>  ( time() - 86400 )
));

if($checkPlayQuery->rowCount() > 0){
    die();
}

$insertPlayQuery    =   $db->prepare("INSERT INTO play_counts(ip,tid,time_played) VALUES( :ip, :tid, :tp )");
$insertPlayQuery->execute(array(
    ":ip"       =>  $_SERVER['REMOTE_ADDR'],
    ":tid"      =>  $params['id'],
    ":tp"       =>  time()
));

$updateTrackQuery   =   $db->prepare("UPDATE tracks SET play_count = play_count + 1 WHERE id = :tid");
$updateTrackQuery->execute(array(
    ":tid"  =>  $params['id']
));
die();