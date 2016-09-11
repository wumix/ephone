<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/10/2016
 * Time: 6:15 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                         =   get_params();
$output                         =   array(
    'tracks'                    =>  array()
);

$count                          =   intval($params['count']);
$genre_id                       =   intval($params['gid']);
$getTracksQuery                 =   $db->prepare("SELECT * FROM tracks WHERE gid = :gid AND visibility='1' ORDER BY `id` DESC LIMIT 0, " . $count);
$getTracksQuery->execute(array(
    ":gid"                      =>  $genre_id
));

$output['tracks']               =   $getTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);