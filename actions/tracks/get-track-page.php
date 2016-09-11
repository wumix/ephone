<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 10/27/2015
 * Time: 4:52 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                     =   array( 'status' => 1 );
$params                     =   get_params();
$uid                        =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;

// Track
$getTrackQuery              =   $db->prepare("SELECT *, (
  SELECT COUNT(*) FROM track_likes
  WHERE uid = :uid AND tid = t.id
) as `isOrange` FROM tracks t WHERE id = :tid"
);
$getTrackQuery->execute(array(
    ":tid"                  =>  $params['tid'],
    ":uid"                  =>  $uid
));

if($getTrackQuery->rowCount() == 0){
    dj($output);
}

$getTrackRow                =   $getTrackQuery->fetch(PDO::FETCH_ASSOC);

if($getTrackRow['visibility'] == 2 && $getTrackRow['uid'] != $uid){
    dj($output);
}

// Comments
$commentsQuery              =   $db->prepare("
SELECT comments.id,comments.time_created,comments.comment,users.display_name,users.profile_img
FROM comments
INNER JOIN users
ON comments.uid = users.id
WHERE tid = :tid
ORDER BY comments.id DESC
LIMIT " . $settings['search_count'] ."
");
$commentsQuery->execute(array(
    ":tid"                  =>  $params['tid']
));
$commentsRow                =   $commentsQuery->fetchAll(PDO::FETCH_ASSOC);

// Artist
$artistQuery                =   $db->prepare("SELECT `id`,`username`,`profile_img`,`display_name`,`website`,`facebook`,`twitter`,`gplus`,`youtube`,`vk`,`soundcloud` FROM users WHERE id = :uid");
$artistQuery->execute(array( "uid" => $getTrackRow['uid'] ));

// Related
$relatedTracksQuery         =   $db->prepare("SELECT `track_img`,`artist`,`title`,`track_url`,`id` FROM tracks WHERE gid = :gid AND id != :tid ORDER BY rand() LIMIT 6");
$relatedTracksQuery->execute(array(
    ":gid"                  =>  $getTrackRow['gid'],
    ":tid"                  =>  $params['tid']
));

$getTrackRow['license_extra']       =   json_decode( $getTrackRow['license_extra'] );
$getTrackRow['tags']        =   json_decode( $getTrackRow['tags'] );
$getTrackRow['track_desc']  =   makeLinks(nl2br( $getTrackRow['track_desc'], false ));
$output['artist']           =   $artistQuery->fetch(PDO::FETCH_ASSOC);
$output['status']           =   2;
$output['track']            =   $getTrackRow;
$output['comments']         =   $commentsRow;
$output['related_tracks']   =   $relatedTracksQuery->fetchAll(PDO::FETCH_ASSOC);
dj($output);