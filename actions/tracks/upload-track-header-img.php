<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 10/27/2015
 * Time: 1:32 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );
include( '../../inc/ZebraImage/Zebra_Image.php' );

$output                         =   array();
$output['status']               =   1;
$output['message']              =   "You can not update this track.";

if( !isReady($_POST,array("tid")) ){
    dj($output);
}

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$user                           =   get_user();

if(!$user){
    dj($output);
}

$tid                            =   intval($_POST['tid']);
$checkTrackQuery                =   $db->prepare("SELECT * FROM tracks WHERE id = :id AND uid = :uid");
$checkTrackQuery->execute(array(
    ":id"                       =>  $tid,
    ":uid"                      =>  $_SESSION['uid']
));
if($checkTrackQuery->rowCount() !== 1){
    dj($output);
}

if(!isset($_FILES['file'])) {
    $output['message']          =   "You must upload a image.";
    dj($output);
}

$upl_img                        =   $_FILES['file'];
$img_ext                        =   get_extension($upl_img['name']);

if($upl_img['error'] != 0){
    $output['message']          =   "We were unable to upload your track image. Try again later.";
    dj($output);
}
if($upl_img['size'] > 2000000){
    $output['message']          =   "The track image size is too big.";
    dj($output);
}
if( !in_array($img_ext, array("jpg","jpeg","png","gif")) ){
    $output['message']          =   "You are only allowed to upload JPG and PNG images.";
    dj($output);
}

$img_name                       =   get_random_string(16) . "." . $img_ext;
$track_img                      =   $user['upl_dir'] . "/" . $img_name;

// create a new instance of the class
$image                          =   new Zebra_Image();
$image->source_path             =   $upl_img['tmp_name'];
$image->target_path             =   '../../uploads/' . $track_img;
$image->jpeg_quality            =   100;
$image->preserve_aspect_ratio   =   true;
$image->enlarge_smaller_images  =   true;
$image->resize(1800, 800, ZEBRA_IMAGE_CROP_CENTER);

$updateTrackQuery               =   $db->prepare("UPDATE tracks SET track_header_img = :img
                                                  WHERE id = :tid AND uid = :uid");
$updateTrackQuery->execute(array(
    ":img"                      =>  $track_img,
    ":tid"                      =>  $tid,
    ":uid"                      =>  $_SESSION['uid']
));

$response['status']             =   2;
$response['message']            =   "Track header image successfully uploaded!";
$response['img']                =   $track_img;
dj($response);