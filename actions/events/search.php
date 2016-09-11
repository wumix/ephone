<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/21/2016
 * Time: 3:55 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array(
    'events'            =>  array()
);

if(!isset($params['term'], $params['sort'])){
    dj($output);
}

$term                   =   secure($params['term']);
$sort                   =   intval($params['sort']);
$uid                    =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
$offset                 =   intval($params['offset']);
$search_query           =   "
SELECT *, (
  SELECT COUNT(*) FROM event_likes
  WHERE uid = :uid AND eid = e.id
) as `isOrange` FROM events e
";

$search_query           .=  (empty($term)) ? "" : "WHERE title LIKE :title OR event_desc LIKE :title OR country LIKE :title OR city LIKE :title OR address LIKE :title";
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

$output['events']           =   $getAlbumsQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);