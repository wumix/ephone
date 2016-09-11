<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/20/2016
 * Time: 4:15 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                             =   array( 'status' => 1 );
$params                             =   get_params();

$getEventQuery                      =   $db->prepare("SELECT * FROM events WHERE id = :eid AND uid = :uid");
$getEventQuery->execute(array(
    ":eid"                          =>  $params['id'],
    ":uid"                          =>  $_SESSION['uid']
));

if($getEventQuery->rowCount() == 0){
    dj($output);
}

$getEventRow                        =   $getEventQuery->fetch(PDO::FETCH_ASSOC);
$output['status']                   =   2;
$output['event']                    =   $getEventRow;
dj($output);