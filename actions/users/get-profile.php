<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 2/26/2015
 * Time: 9:43 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params             =   get_params();
$output             =   array( 'status' => 1);
$followee           =   (isset($_SESSION['username'])) ? $_SESSION['username'] : "";
$uid                =   (isset($_SESSION['uid'])) ? $_SESSION['uid'] : 0;

$getUserQuery       =   $db->prepare("
SELECT `id`,`email`,`username`,`profile_img`,`header_img`,`display_name`,`intro_text`,`location`,`website`,
       `facebook`,`twitter`,`gplus`,`youtube`,`vk`,`soundcloud`,`about`,`isPro`, (
       SELECT COUNT(*) FROM followers
       WHERE followee = :f1 AND following = u.username
) as `isOrange` FROM users u WHERE username = :u
");
$getUserQuery->execute(array(
    "f1"    =>  $followee,
    ":u"    =>  $params['username']
));

if($getUserQuery->rowCount() == 0){
    dj($output);
}

$getUserRow         =   $getUserQuery->fetch(PDO::FETCH_ASSOC);

$getUserTracks      =   $db->prepare(
    "SELECT *, (
      SELECT COUNT(*) FROM track_likes
      WHERE uid = :uid AND tid = t.id
    ) as `isOrange` FROM tracks t WHERE username = :username ORDER BY `id` DESC"
);
$getUserTracks->execute(array(
    ":uid"       =>     $uid,
    ":username"  =>     $params['username']
));
$getUserTracks      =   $getUserTracks->fetchAll(PDO::FETCH_ASSOC);

$output['user']     =   $getUserRow;
$output['tracks']   =   $getUserTracks;
$output['status']   =   2;
dj($output);