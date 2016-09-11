<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/14/2015
 * Time: 7:02 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                     =   get_params();
$output                     =   array();
$output['status']           =   1;

if(!isReady($params, array('id'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$tid                        =   intval($params['id']);
$checkLikeQuery             =   $db->prepare("SELECT * FROM track_likes WHERE uid = :uid AND tid = :tid");
$checkLikeQuery->execute(array(
    ":uid"                  =>  $_SESSION['uid'],
    ":tid"                  =>  $tid
));

if($checkLikeQuery->rowCount() > 0){
    $trackLikeQuery         =   $db->prepare("DELETE FROM track_likes WHERE uid = :uid AND tid = :tid");
    $updateTrackQuery       =   $db->prepare("UPDATE tracks SET like_count = like_count - 1 WHERE id = :tid");
    $output['status']       =   2;
}else{
    $trackLikeQuery         =   $db->prepare("INSERT INTO track_likes(uid,tid) VALUES( :uid, :tid )");
    $updateTrackQuery       =   $db->prepare("UPDATE tracks SET like_count = like_count + 1 WHERE id = :tid");

    $trackQuery             =   $db->prepare("SELECT `uid` FROM tracks WHERE id = :tid");
    $trackQuery->execute(array( ":tid" => $tid ));
    $trackRow               =   $trackQuery->fetch();

    $addAlertQuery          =   $db->prepare("INSERT INTO alerts(recipient_uid,sender_uid,a_type,tid,time_created)
                                              VALUES( :ruid, :suid, :t, :tid, :tc)");
    $addAlertQuery->execute(array(
        ":ruid"             =>  $trackRow['uid'],
        ":suid"             =>  $_SESSION['uid'],
        ":t"                =>  2,
        ":tid"              =>  $tid,
        ":tc"               =>  @date("M d h:ia")
    ));

    $output['status']       =   3;
}

$trackLikeQuery->execute(array(
    ":uid"                  =>  $_SESSION['uid'],
    ":tid"                  =>  $tid
));

$updateTrackQuery->execute(array(
    ":tid"                  =>  $tid
));

dj($output);