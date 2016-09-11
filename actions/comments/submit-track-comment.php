<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/15/2015
 * Time: 2:00 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$response               =   array();
$response['status']     =   1;

if(!isReady($params, array('comment', 'tid'))){
    dj($response);
}

if(!isset($_SESSION['loggedin'])){
    dj($response);
}

$comment                =   substr(secure($params['comment']), 0, 500);
$tid                    =   intval($params['tid']);

if( strlen($comment) < 5 ){
    dj($response);
}

$insertCommentQuery     =   $db->prepare("INSERT INTO comments(tid,uid,time_created,comment)
                                          VALUES( :tid, :uid, :tc, :comment )");
$insertCommentQuery->execute(array(
    ":tid"              =>  $tid,
    ":uid"              =>  $_SESSION['uid'],
    ":tc"               =>  time(),
    ":comment"          =>  $comment
));

$getUserQuery           =   $db->prepare("SELECT `profile_img`,`display_name` FROM users WHERE id = :uid");
$getUserQuery->execute(array(
    ":uid"              =>  $_SESSION['uid']
));
$getUserRow             =   $getUserQuery->fetch();

$updateTrackQuery       =   $db->prepare("UPDATE tracks SET comment_count = comment_count + 1 WHERE id = :tid");
$updateTrackQuery->execute(array(
    ":tid"              =>  $tid
));

$trackQuery             =   $db->prepare("SELECT `uid` FROM tracks WHERE id = :tid");
$trackQuery->execute(array( ":tid" => $tid ));
$trackRow               =   $trackQuery->fetch();

$addAlertQuery          =   $db->prepare("INSERT INTO alerts(recipient_uid,sender_uid,a_type,tid,time_created)
                                          VALUES( :ruid, :suid, :t, :tid, :tc)");
$addAlertQuery->execute(array(
    ":ruid"             =>  $trackRow['uid'],
    ":suid"             =>  $_SESSION['uid'],
    ":t"                =>  3,
    ":tid"              =>  $tid,
    ":tc"               =>  @date("M d h:a")
));

$response['status']     =   2;
$response['comment']    =   array(
    "comment"           =>  $comment,
    "time_created"      =>  time(),
    "profile_img"       =>  $getUserRow['profile_img'],
    "display_name"      =>  $getUserRow['display_name']
);
dj($response);