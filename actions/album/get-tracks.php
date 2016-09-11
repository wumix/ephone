<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/22/2016
 * Time: 6:41 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array();
$output['tracks']       =   array();

if(!isReady($params, array('id'))){
    dj($output);
}

$playlistTracksQuery    =   $db->prepare("
SELECT tracks.*
FROM album_tracks
INNER JOIN tracks
ON album_tracks.tid = tracks.id
WHERE aid = :aid
");
$playlistTracksQuery->execute(array(
    ":aid"              =>  $params['id']
));
$output['tracks']       =   $playlistTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);