<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/22/2016
 * Time: 3:47 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                     =   array( 'status' => 1 );
$params                     =   get_params();
$uid                        =   isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;

// Event
$getEventQuery              =   $db->prepare("SELECT *, (
  SELECT COUNT(*) FROM event_likes
  WHERE uid = :uid AND eid = e.id
) as `isOrange` FROM events e WHERE id = :eid"
);
$getEventQuery->execute(array(
    ":eid"                  =>  $params['eid'],
    ":uid"                  =>  $uid
));

if($getEventQuery->rowCount() == 0){
    dj($output);
}

$getEventRow                =   $getEventQuery->fetch(PDO::FETCH_ASSOC);

// Artist
$artistQuery                =   $db->prepare("SELECT `id`,`username`,`profile_img`,`display_name`,`website`,`facebook`,`twitter`,`gplus`,`youtube`,`vk`,`soundcloud` FROM users WHERE id = :uid");
$artistQuery->execute(array( "uid" => $getEventRow['uid'] ));

$getEventRow['event_desc']  =   makeLinks(nl2br( $getEventRow['event_desc'], false ));
$output['artist']           =   $artistQuery->fetch(PDO::FETCH_ASSOC);
$output['status']           =   2;
$output['event']            =   $getEventRow;
dj($output);