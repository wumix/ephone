<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 10/25/2015
 * Time: 7:19 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                         =   array();
$output['status']               =   1;
$output['message']              =   "You can not update this track.";
$params                         =   get_params();

if( !isReady($params,array("id")) ){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$user                           =   get_user();
if(!$user){
    dj($output);
}

$tid                            =   intval($params['id']);
$checkTrackQuery                =   $db->prepare("SELECT * FROM tracks WHERE id = :id AND uid = :uid");
$checkTrackQuery->execute(array(
    ":id"                       =>  $tid,
    ":uid"                      =>  $_SESSION['uid']
));

if($checkTrackQuery->rowCount() != 1){
    dj($output);
}

$checkTrackRow                  =   $checkTrackQuery->fetch();
$title                          =   secure($params['title']);                        // Ready
$desc                           =   secure($params['track_desc']);                         // Ready
$tags                           =   json_encode(explode(",", secure($params['tags'])));                         // Ready
$purchase_link                  =   secure($params['purchase_link']);
$label                          =   secure($params['record_label']);
$release_date                   =   isset($params['release_date']) ? secure($params['release_date']) : null;
$license                        =   secure($params['license']);
$license_extras                 =   secure(json_encode($params['license_extra']));               // Ready
$visibility                     =   intval($params['visibility']) == 1 ? 1 : 2;      // Ready
$downloadable                   =   intval($params['downloadable']) == 1 ? 1 : 2;    // Ready
$mode                           =   strlen($title) > 0 ? 1 : 2;                     // Ready
$genre                          =   intval($params['gid']);
$track_url                      =   create_slug($title);

if( !empty($purchase_link) && !filter_var($purchase_link, FILTER_VALIDATE_URL) ){ // Check Purchase Link
    $output['message']          =   "You can not update this track. The purchase link is an invalid URL.";
    dj($output);
}

$updateTrackQuery               =   $db->prepare("UPDATE tracks SET title = :title, track_desc = :t_desc,
                                                        tags = :tags, license_extra = :license_extra,
                                                        purchase_link = :purchase_link, record_label = :label,
                                                        release_date = :release_date, license = :license,
                                                        visibility = :visibility, downloadable = :downloadable,
                                                        gid = :gid, track_url = :url
                                      WHERE id = :tid AND uid = :uid");
$updateTrackQuery->execute(array(
    ":title"                    =>  $title,
    ":t_desc"                   =>  $desc,
    ":tags"                     =>  $tags,
    ":purchase_link"            =>  $purchase_link,
    ":label"                    =>  $label,
    ":release_date"             =>  $release_date,
    ":license"                  =>  $license,
    ":visibility"               =>  $visibility,
    ":downloadable"             =>  $downloadable,
    ":license_extra"            =>  $license_extras,
    ":tid"                      =>  $tid,
    ":gid"                      =>  $genre,
    ":url"                      =>  $track_url,
    ":uid"                      =>  $_SESSION['uid']
));

$output['status']               =   2;
$output['message']              =   "This track has been updated successfully!";
dj($output);