<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/20/2016
 * Time: 5:31 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output                         =   array();
$output['status']               =   1;
$output['message']              =   "You can not update this event.";
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

$eid                            =   intval($params['id']);
$checkEventQuery                =   $db->prepare("SELECT * FROM events WHERE id = :id AND uid = :uid");
$checkEventQuery->execute(array(
    ":id"                       =>  $eid,
    ":uid"                      =>  $_SESSION['uid']
));

if($checkEventQuery->rowCount() != 1){
    dj($output);
}

$title                          =   secure($params['title']);                        // Ready
$desc                           =   secure($params['event_desc']);                         // Ready
$date                           =   secure($params['event_date_readable']);
$time_date                      =   strtotime($date);
$country                        =   secure($params['country']);
$city                           =   secure($params['city']);
$address                        =   secure($params['address']);
$purchase_link                  =   secure($params['purchase_link']);
$event_url                      =   create_slug($title);

if( !empty($purchase_link) && !filter_var($purchase_link, FILTER_VALIDATE_URL) ){ // Check Purchase Link
    $output['message']          =   "You can not update this event. The purchase link is an invalid URL.";
    dj($output);
}

$updateEventQuery               =   $db->prepare("UPDATE events SET title = :title, event_desc = :e_desc,
                                                                    event_date_readable = :edr, event_date = :ed,
                                                                    country = :country, city = :city, address = :address,
                                                                    purchase_link = :purchase_link,  slug_url = :url
                                      WHERE id = :eid AND uid = :uid");
$updateEventQuery->execute(array(
    ":title"                    =>  $title,
    ":e_desc"                   =>  $desc,
    ":edr"                      =>  $date,
    ":ed"                       =>  $time_date,
    ":country"                  =>  $country,
    ":city"                     =>  $city,
    ":address"                  =>  $address,
    ":purchase_link"            =>  $purchase_link,
    ":url"                      =>  $event_url,
    ":eid"                      =>  $eid,
    ":uid"                      =>  $_SESSION['uid']
));

$output['status']               =   2;
$output['message']              =   "This event has been updated successfully!";
dj($output);