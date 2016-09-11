<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/20/2015
 * Time: 7:58 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   json_decode(file_get_contents('php://input'), true);
$output                 =   array(
    'playlists' => array()
);

if(!isset($params['term'], $params['sort'])){
    dj($output);
}

$term                   =   secure($params['term']);
$sort                   =   intval($params['sort']);
$uid                    =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
$offset                 =   intval($params['offset']);
$search_query           =   "
SELECT *,(
  SELECT COUNT(*) FROM playlist_tracks WHERE pid = p.id
) as `track_count`, (
  SELECT COUNT(*) FROM playlist_likes
  WHERE uid = :uid AND pid = p.id
) as `isOrange`,(
  SELECT `username` FROM users WHERE id = p.uid
) as `username` FROM playlists p
";

$search_query           .=  (empty($term)) ? "" : " WHERE playlist_name LIKE :term ";
$search_query           .=  $sort == 1 ? " ORDER BY `id` DESC " : " ORDER BY `like_count` DESC";
$search_query           .=  " LIMIT " . $offset . ", " . $settings['search_count'];
$getPlaylistsQuery      =   $db->prepare($search_query);

if(empty($term)){
    $getPlaylistsQuery->execute(array(
        ":uid"              =>  $uid
    ));
}else{
    $getPlaylistsQuery->execute(array(
        ":term"             =>  '%' . $term . '%',
        ":uid"              =>  $uid
    ));
}

$output['playlists']    =   $getPlaylistsQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);