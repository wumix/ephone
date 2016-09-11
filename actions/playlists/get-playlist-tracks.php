<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/18/2015
 * Time: 8:01 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array(
    'tracks'            =>  array()
);

if(!isReady($params, array('id'))){
    dj($output);
}

$playlistTracksQuery    =   $db->prepare("
SELECT tracks.*
FROM playlist_tracks
INNER JOIN tracks
ON playlist_tracks.tid = tracks.id
WHERE pid = :pid
");
$playlistTracksQuery->execute(array(
    ":pid"              =>  $params['id']
));
$output['tracks']       =   $playlistTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);