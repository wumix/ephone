<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/20/2015
 * Time: 12:25 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   json_decode(file_get_contents('php://input'), true);
$output                 =   array(
    'tracks' => array()
);

if(!isset($params['term'], $params['genre'], $params['sort'])){
    dj($output);
}

$term                   =   secure($params['term']);
$genre                  =   intval($params['genre']);
$sort                   =   intval($params['sort']);
$uid                    =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
$offset                 =   intval($params['offset']);

$search_query           =   "
SELECT *, (
  SELECT COUNT(*) FROM track_likes
  WHERE uid = :uid AND tid = t.id
) as `isOrange` FROM tracks t
";

if($genre == 0){
    $search_query           .=  (empty($term)) ? "" : "WHERE visibility='1' AND (title LIKE :title OR track_desc LIKE :title OR tags LIKE :title OR username LIKE :title)";
    $search_query           .=  $sort == 1 ? " ORDER BY `id` DESC " : " ORDER BY `like_count` DESC";
    $search_query           .=  " LIMIT " . $offset . ", " . $settings['search_count'];
    $getTracksQuery         =   $db->prepare($search_query);

    if(empty($term)){
        $getTracksQuery->execute(array(
            ":uid"              =>  $uid
        ));
    }else{
        $getTracksQuery->execute(array(
            ":title"            =>  '%' . $term . '%',
            ":uid"              =>  $uid
        ));
    }

}else{
    $search_query           .=  (empty($term)) ? "" : "WHERE visibility='1' AND (title LIKE :title OR track_desc LIKE :title OR tags LIKE :title OR username LIKE :title) AND ";
    $search_query           .=  (empty($term)) ? " WHERE visibility='1' AND gid = :gid " : " gid = :gid ";
    $search_query           .=  $sort == 1 ? " ORDER BY `id` DESC " : " ORDER BY `like_count` DESC";
    $search_query           .=  " LIMIT " . $offset . ", " . $settings['search_count'];
    $getTracksQuery         =   $db->prepare($search_query);

    if(empty($term)){
        $getTracksQuery->execute(array(
            ":gid"              =>  $genre,
            ":uid"              =>  $uid
        ));
    }else{
        $getTracksQuery->execute(array(
            ":title"            =>  '%' . $term . '%',
            ":gid"              =>  $genre,
            ":uid"              =>  $uid
        ));
    }

}

$output['tracks']       =   $getTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);