<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/20/2016
 * Time: 1:41 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                 =   array('status' => 1);
$params                 =   get_params();

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$event_id               =   intval( $params['eid'] );

// Get User Tracks
$eventsQuery            =   $db->prepare("DELETE FROM events WHERE id = :eid AND uid = :uid");
$eventsQuery->execute(array(
    ":eid"              =>  $event_id,
    ":uid"              =>  $_SESSION['uid']
));

// Update Output
$output['status']       =   2;
dj($output);