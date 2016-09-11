<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/16/2015
 * Time: 6:03 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['status']       =   1;

if(!isReady($params,array('id'))){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$tid                    =   $params['id'];

$getTrackPlaylistsQuery =   $db->prepare("
SELECT *, (
  SELECT COUNT(*) FROM playlist_tracks
  WHERE uid = :uid AND pid = p.id AND tid = :tid
) as `hasTrack` FROM playlists p WHERE uid = :uid
");
$getTrackPlaylistsQuery->execute(array(
    ":uid"              =>  $_SESSION['uid'],
    ":tid"              =>  $tid
));

$output['status']       =   2;
$output['playlists']    =   $getTrackPlaylistsQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);