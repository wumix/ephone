<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/22/2016
 * Time: 12:19 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                     =   array( 'status' => 1 );
$params                     =   get_params();
$uid                        =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;

// Album
$getAlbumQuery              =   $db->prepare("SELECT *, (
  SELECT COUNT(*) FROM album_likes
  WHERE uid = :uid AND aid = a.id
) as `isOrange` FROM albums a WHERE id = :aid"
);
$getAlbumQuery->execute(array(
    ":aid"                  =>  $params['aid'],
    ":uid"                  =>  $uid
));

if($getAlbumQuery->rowCount() == 0){
    dj($output);
}

$getAlbumRow                =   $getAlbumQuery->fetch(PDO::FETCH_ASSOC);

// Tracks
$albumTracksQuery           =   $db->prepare("
    SELECT *, (
      SELECT COUNT(*) FROM track_likes
      WHERE uid = :uid AND tid = t.id
    ) as `isOrange`
    FROM album_tracks
    INNER JOIN tracks t
    ON album_tracks.tid=t.id
    WHERE aid = :aid
");
$albumTracksQuery->execute(array(
    ":aid"                  =>  $params['aid'],
    ":uid"                  =>  $uid
));

// Artist
$artistQuery                =   $db->prepare("SELECT `id`,`username`,`profile_img`,`display_name`,`website`,`facebook`,`twitter`,`gplus`,`youtube`,`vk`,`soundcloud` FROM users WHERE id = :uid");
$artistQuery->execute(array( "uid" => $getAlbumRow['uid'] ));

$getAlbumRow['album_desc']  =   makeLinks(nl2br( $getAlbumRow['album_desc'], false ));
$output['artist']           =   $artistQuery->fetch(PDO::FETCH_ASSOC);
$output['status']           =   2;
$output['album']            =   $getAlbumRow;
$output['tracks']           =   $albumTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);