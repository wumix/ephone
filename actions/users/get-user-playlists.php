<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/18/2015
 * Time: 6:31 PM
 */
require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isReady($params,array('username'))){
    dj($output);
}

$username               =   secure($params['username']);
$profileQuery           =   $db->prepare("SELECT `id` FROM users WHERE username = :username");
$profileQuery->execute(array( ":username" => $username ));
$profileRow             =   $profileQuery->fetch();

$playlistQuery          =   $db->prepare("
SELECT *,(
  SELECT COUNT(*) FROM playlist_tracks WHERE pid = p.id
) as `track_count`, (
  SELECT COUNT(*) FROM playlist_likes
  WHERE uid = :uid AND pid = p.id
) as `isOrange`  FROM playlists p WHERE uid = :uid LIMIT 32
");
$playlistQuery->execute(array(
    ":uid"              =>  $profileRow['id']
));

$output['status']       =   2;
$output['playlists']    =   $playlistQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);
