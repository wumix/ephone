<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 10/25/2015
 * Time: 1:40 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array('status' => 1);

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

// Get User Tracks
$tracksQuery            =   $db->prepare("SELECT `id`,`title`,`original_name` FROM tracks WHERE uid = :uid");
$tracksQuery->execute(array(
    ":uid"              =>  $_SESSION['uid']
));

// Get User Albums
$albumsQuery            =   $db->prepare("SELECT * FROM albums WHERE uid = :uid");
$albumsQuery->execute(array(
    ":uid"              =>  $_SESSION['uid']
));

// Get Maximum Upload Size
$user                   =   get_user();
$max_upl_size           =   $user['isPro'] == 2 ? $settings['pro_track_size'] : $settings['regular_track_size'];

// Update Output
$output['tracks']       =   $tracksQuery->fetchAll(PDO::FETCH_ASSOC);
$output['albums']       =   $albumsQuery->fetchAll(PDO::FETCH_ASSOC);
$output['max_upl_size'] =   $max_upl_size;
$output['status']       =   2;
dj($output);