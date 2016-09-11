<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/5/2015
 * Time: 6:21 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                         =   get_params();
$output                         =   array(
    'tracks'                    =>  array()
);

$offset                         =   intval($params['offset']);
$uid                            =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
$search_query                   =   "SELECT *, (
                                          SELECT COUNT(*) FROM track_likes
                                          WHERE uid = :uid AND tid = t.id
                                     ) as `isOrange` FROM tracks t
                                     WHERE visibility='1'
                                     ORDER BY `like_count` DESC
                                     LIMIT " . $offset . ", " . $settings['search_count'];
$getTracksQuery                 =   $db->prepare($search_query);
$getTracksQuery->execute(array(
    ":uid"                      =>  $uid
));

$output['tracks']               =   $getTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);