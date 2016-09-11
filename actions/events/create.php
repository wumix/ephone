<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/20/2016
 * Time: 1:21 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                         =   array( 'status' => 1 );
$params                         =   get_params();

if( !isset($_SESSION['loggedin']) && !isReady( $params, array( 'name' ) ) || $demo ){
    dj($output);
}

$user                           =   get_user();
$event_name                     =   secure( $params['name'] );
$event_url                      =   create_slug($event_name);
$current_time                   =   time();
$current_readable_time          =   @date( "F j, Y" , $current_time );

$insertEventQuery               =   $db->prepare("INSERT INTO events(title,event_date,event_date_readable,uid,slug_url)
                                                  VALUES( :title, :ed, :edr, :uid, :url )");

$insertEventQuery->execute(array(
    ":title"                    =>  $event_name,
    ":ed"                       =>  $current_time,
    ":edr"                      =>  $current_readable_time,
    ":uid"                      =>  $_SESSION['uid'],
    ":url"                      =>  $event_url
));

$output['status']               =   2;
$output['event']                =   array(
    "id"                        =>  $db->lastInsertId(),
    "title"                     =>  $event_name,
    "purchase"                  =>  ''
);
dj($output);