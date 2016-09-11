<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/21/2016
 * Time: 12:32 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array(
    'albums'            =>  array()
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
  SELECT COUNT(*) FROM album_likes
  WHERE uid = :uid AND aid = a.id
) as `isOrange`, (
  SELECT `display_name` FROM users WHERE id = a.uid
) as `display_name`, (
  SELECT `username` FROM users WHERE id = a.uid
) as `username` FROM albums a
";

if($genre == 0){
    $search_query           .=  (empty($term)) ? "" : "WHERE title LIKE :title OR album_desc LIKE :title";
    $search_query           .=  $sort == 1 ? " ORDER BY `id` DESC " : " ORDER BY `like_count` DESC";
    $search_query           .=  " LIMIT " . $offset . ", " . $settings['search_count'];
    $getAlbumsQuery         =   $db->prepare($search_query);

    if(empty($term)){
        $getAlbumsQuery->execute(array(
            ":uid"              =>  $uid
        ));
    }else{
        $getAlbumsQuery->execute(array(
            ":title"            =>  '%' . $term . '%',
            ":uid"              =>  $uid
        ));
    }

}else{
    $search_query           .=  (empty($term)) ? "" : "WHERE (title LIKE :title OR album_desc LIKE :title) AND ";
    $search_query           .=  (empty($term)) ? " WHERE genre = :gid " : " genre = :gid ";
    $search_query           .=  $sort == 1 ? " ORDER BY `id` DESC " : " ORDER BY `like_count` DESC";
    $search_query           .=  " LIMIT " . $offset . ", " . $settings['search_count'];
    $getAlbumsQuery         =   $db->prepare($search_query);

    if(empty($term)){
        $getAlbumsQuery->execute(array(
            ":gid"              =>  $genre,
            ":uid"              =>  $uid
        ));
    }else{
        $getAlbumsQuery->execute(array(
            ":title"            =>  '%' . $term . '%',
            ":gid"              =>  $genre,
            ":uid"              =>  $uid
        ));
    }

}

$output['albums']           =   $getAlbumsQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);