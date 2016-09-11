<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/19/2016
 * Time: 7:12 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                         =   array();
$output['status']               =   1;
$output['message']              =   "You can not update this album.";
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

$aid                            =   intval($params['id']);
$checkAlbumQuery                =   $db->prepare("SELECT * FROM albums WHERE id = :id AND uid = :uid");
$checkAlbumQuery->execute(array(
    ":id"                       =>  $aid,
    ":uid"                      =>  $_SESSION['uid']
));

if($checkAlbumQuery->rowCount() != 1){
    dj($output);
}

$title                          =   secure($params['title']);                        // Ready
$desc                           =   secure($params['album_desc']);                         // Ready
$genre                          =   intval($params['genre']);
$purchase_link                  =   secure($params['purchase_link']);
$label                          =   secure($params['record_label']);
$release_date                   =   isset($params['release_date']) ? secure($params['release_date']) : null;
$downloadable                   =   intval($params['downloadable']) == 1 ? 1 : 2;    // Ready
$album_url                      =   create_slug($title);

if( !empty($purchase_link) && !filter_var($purchase_link, FILTER_VALIDATE_URL) ){ // Check Purchase Link
    $output['message']          =   "You can not update this album. The purchase link is an invalid URL.";
    dj($output);
}

$updateAlbumQuery               =   $db->prepare("UPDATE albums SET title = :title, album_desc = :a_desc,
                                                                    genre = :gid, purchase_link = :purchase_link,
                                                                    record_label = :label, release_date = :release_date,
                                                                    downloadable = :downloadable, album_url = :url
                                      WHERE id = :aid AND uid = :uid");
$updateAlbumQuery->execute(array(
    ":title"                    =>  $title,
    ":a_desc"                   =>  $desc,
    ":gid"                      =>  $genre,
    ":purchase_link"            =>  $purchase_link,
    ":label"                    =>  $label,
    ":release_date"             =>  $release_date,
    ":downloadable"             =>  $downloadable,
    ":url"                      =>  $album_url,
    ":aid"                      =>  $aid,
    ":uid"                      =>  $_SESSION['uid']
));

$output['status']               =   2;
$output['message']              =   "This album has been updated successfully!";
dj($output);