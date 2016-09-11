<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/19/2015
 * Time: 4:43 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params,array('username')) || !isset($_SESSION['loggedin']) || $_SESSION['username'] == $params['username']){
    dj($output);
}

$username               =   secure($params['username']);
$checkFollowQuery       =   $db->prepare("SELECT * FROM followers WHERE followee = :f1 AND following = :f2");
$checkFollowQuery->execute(array(
    ":f1"               =>  $_SESSION['username'],
    ":f2"               =>  $username
));

if($checkFollowQuery->rowCount() > 0){
    $toggleFollowQuery  =   $db->prepare("DELETE FROM followers WHERE followee = :f1 AND following = :f2");
    $output['status']   =   2;
}else{
    $toggleFollowQuery  =   $db->prepare("INSERT INTO followers(followee,following) VALUEs( :f1, :f2 )");

    $recipientUserQuery =   $db->prepare("SELECT `id` FROM users WHERE username = :u");
    $recipientUserQuery->execute(array( ":u" => $username ));
    $recipientUserRow   =   $recipientUserQuery->fetch();

    $addAlertQuery      =   $db->prepare("INSERT INTO alerts(recipient_uid,sender_uid,a_type,tid,time_created) VALUES( :ruid, :suid, :t, :tid, :tc)");
    $addAlertQuery->execute(array(
        ":ruid"         =>  $recipientUserRow['id'],
        ":suid"         =>  $_SESSION['uid'],
        ":t"            =>  1,
        ":tid"          =>  0,
        ":tc"           =>  @date("M d h:ia")
    ));
    $output['status']   =   3;
}

$toggleFollowQuery->execute(array(
    ":f1"               =>  $_SESSION['username'],
    ":f2"               =>  $username
));
dj($output);