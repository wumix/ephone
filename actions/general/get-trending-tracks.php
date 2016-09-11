<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/10/2016
 * Time: 6:44 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                         =   get_params();
$output                         =   array(
    'tracks'                    =>  array()
);

$count                          =   intval($params['count']);
$search_query                   =   "SELECT * FROM tracks WHERE visibility='1' ORDER BY `weekly_like_count` DESC LIMIT 0, " . $count;
$getTracksQuery                 =   $db->prepare($search_query);
$getTracksQuery->execute();
$output['tracks']               =   $getTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);