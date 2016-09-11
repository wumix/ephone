<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/9/2016
 * Time: 5:45 PM
 */
$followingQuery             =   $db->prepare("SELECT * FROM followers WHERE followee = :f");
$followingQuery->execute(array(
    ":f"                =>  $_SESSION['username']
));

$followerUsers          =   " WHERE visibility='1' ";
$loop_count             =   $followingQuery->rowCount();

for($i = 0; $i < $loop_count; $i++){
    if($i === 0){
        $followingRow       =   $followingQuery->fetch();
        $followerUsers      .=  " AND username='". $followingRow['following'] . "'";
    }
    $followingRow       =   $followingQuery->fetch();
    $followerUsers      .=  " OR username='". $followingRow['following'] . "'";
}

$search_query           =   "
    SELECT *, (
      SELECT COUNT(*) FROM track_likes
      WHERE uid = :uid AND tid = t.id
    ) as `isOrange` FROM tracks t
    " .  $followerUsers . "
    ORDER BY `id` DESC
    LIMIT " . $offset . ", " . $settings['search_count'] . "
    ";

$getTracksQuery         =   $db->prepare($search_query);
$getTracksQuery->execute(array(
    ":uid"              =>  $_SESSION['uid'],
));