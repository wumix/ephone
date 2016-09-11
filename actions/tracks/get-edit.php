<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 10/25/2015
 * Time: 4:23 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                             =   array( 'status' => 1 );
$params                             =   get_params();

$getTrackQuery                      =   $db->prepare("SELECT * FROM tracks WHERE id = :tid AND uid = :uid");
$getTrackQuery->execute(array(
    ":tid"                          =>  $params['id'],
    ":uid"                          =>  $_SESSION['uid']
));

if($getTrackQuery->rowCount() == 0){
    dj($output);
}

$getTrackRow                        =   $getTrackQuery->fetch(PDO::FETCH_ASSOC);
$getTrackRow['tags']                =   json_decode( $getTrackRow['tags'] );
$getTrackRow['license_extra']       =   json_decode( $getTrackRow['license_extra'] );
$output['status']                   =   2;
$output['track']                    =   $getTrackRow;
dj($output);