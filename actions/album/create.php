<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/17/2016
 * Time: 4:19 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                         =   array( 'status' => 1 );
$params                         =   get_params();

if( !isset($_SESSION['loggedin']) && !isReady( $params, array( 'name', 'type' ) ) || $demo ){
    dj($output);
}

$user                           =   get_user();
$album_name                     =   secure( $params['name'] );
$album_type                     =   intval( $params['type'] );
$album_header_img               =   'headers/t' . mt_rand( 1, 10 ) . '.jpg';
$album_url                      =   create_slug($album_name);

$trackCheck                     =   $db->prepare("SELECT COUNT(*) as `track_count` FROM tracks WHERE uid = :uid");
$trackCheck->execute(array(
    ":uid"                      =>  $_SESSION['uid']
));
$trackCheck                     =   $trackCheck->fetch(PDO::FETCH_ASSOC);

if( $trackCheck['track_count'] < 1 ){
    dj($output);
}

$insertAlbumQuery               =   $db->prepare("INSERT INTO albums(title,uid,type,album_header_image,album_url,downloadable)
                                                  VALUES( :title, :uid, :t, :ahi, :aurl, :dl )");

$insertAlbumQuery->execute(array(
    ":title"                    =>  $album_name,
    ":uid"                      =>  $_SESSION['uid'],
    ":t"                        =>  $album_type,
    ":ahi"                      =>  $album_header_img,
    ":aurl"                     =>  $album_url,
    ":dl"                       =>  $settings['default_download_opt']
));

$output['status']               =   2;
$output['album']                =   array(
    "id"                        =>  $db->lastInsertId(),
    "title"                     =>  $album_name,
    "type"                      =>  $album_type
);
dj($output);