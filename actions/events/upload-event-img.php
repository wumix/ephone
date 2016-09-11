<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/20/2016
 * Time: 6:13 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );
include( '../../inc/ZebraImage/Zebra_Image.php' );

$output                         =   array();
$output['status']               =   1;
$output['message']              =   "You can not update this event.";

if( !isReady($_POST,array("eid")) ){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$user                           =   get_user();

if(!$user){
    dj($output);
}

$eid                            =   intval($_POST['eid']);
$checkEventQuery                =   $db->prepare("SELECT * FROM events WHERE id = :id AND uid = :uid");
$checkEventQuery->execute(array(
    ":id"                       =>  $eid,
    ":uid"                      =>  $_SESSION['uid']
));
if($checkEventQuery->rowCount() !== 1){
    dj($output);
}

if(!isset($_FILES['file'])) {
    $output['message']          =   "You must upload a image.";
    dj($output);
}

$upl_img                        =   $_FILES['file'];
$img_ext                        =   get_extension($upl_img['name']);

if($upl_img['error'] != 0){
    $output['message']          =   "We were unable to upload your event image. Try again later.";
    dj($output);
}
if($upl_img['size'] > 2000000){
    $output['message']          =   "The event image size is too big.";
    dj($output);
}
if( !in_array($img_ext, array("jpg","jpeg","png","gif")) ){
    $output['message']          =   "You are only allowed to upload JPG and PNG images.";
    dj($output);
}

$img_name                       =   get_random_string(16) . "." . $img_ext;
$event_img                      =   $user['upl_dir'] . "/" . $img_name;

// create a new instance of the class
$image                          =   new Zebra_Image();
$image->source_path             =   $upl_img['tmp_name'];
$image->target_path             =   '../../uploads/' . $event_img;
$image->jpeg_quality            =   100;
$image->preserve_aspect_ratio   =   true;
$image->enlarge_smaller_images  =   true;
$image->resize(300, 300, ZEBRA_IMAGE_CROP_CENTER);

$updateTrackQuery               =   $db->prepare("UPDATE events SET event_img = :img
                                                  WHERE id = :eid AND uid = :uid");
$updateTrackQuery->execute(array(
    ":img"                      =>  $event_img,
    ":eid"                      =>  $eid,
    ":uid"                      =>  $_SESSION['uid']
));

$response['status']             =   2;
$response['message']            =   "Event image successfully uploaded!";
$response['img']                =   $event_img;
dj($response);