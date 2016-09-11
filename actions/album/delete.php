<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/17/2016
 * Time: 5:44 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array('status' => 1);
$params                 =   get_params();

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$album_id               =   intval( $params['aid'] );
$user                   =   get_user();

// Get User Tracks
$deleteAlbumQuery       =   $db->prepare("DELETE FROM albums WHERE id = :aid AND uid = :uid");
$deleteAlbumQuery->execute(array(
    ":aid"              =>  $album_id,
    ":uid"              =>  $_SESSION['uid']
));

// Update Output
$output['status']       =   2;
dj($output);