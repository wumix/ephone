<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/20/2016
 * Time: 11:54 AM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array('status' => 1);

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

// Get User Tracks
$eventsQuery            =   $db->prepare("SELECT * FROM events WHERE uid = :uid");
$eventsQuery->execute(array(
    ":uid"              =>  $_SESSION['uid']
));

// Update Output
$output['events']       =   $eventsQuery->fetchAll(PDO::FETCH_ASSOC);
$output['status']       =   2;
dj($output);