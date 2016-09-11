<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/17/2016
 * Time: 1:56 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array('status' => 1);
$params                 =   get_params();

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$track_id               =   intval( $params['tid'] );

// Get User Tracks
$tracksQuery            =   $db->prepare("DELETE FROM tracks WHERE id = :tid AND uid = :uid");
$tracksQuery->execute(array(
    ":tid"              =>  $track_id,
    ":uid"              =>  $_SESSION['uid']
));

// Update Output
$output['status']       =   2;
dj($output);