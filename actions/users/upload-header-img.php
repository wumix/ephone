<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/7/2015
 * Time: 10:33 PM
 */
require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output             =   array( 'status' => 1, 'message' => 'You can not update this profile.' );
$max_size           =   ( $settings['profile_header_size'] * 1024 ) * 1000;

if( !isReady($_FILES,array("file")) || !isset($_SESSION['loggedin'])){
    dj($output);
}

$user               =   get_user();
$upl_img            =   $_FILES['file'];
$img_ext            =   get_extension($upl_img['name']);

if($upl_img['error'] != 0){
    $output['message']  =   "We were unable to upload your image. Try again later.";
    dj($output);
}

if($upl_img['size'] > $max_size){
    $output['message']  =   "The image size is too big.";
    dj($output);
}

if( !in_array($img_ext, array("jpg","jpeg","png")) ){
    $output['message']  =   "You are only allowed to upload JPG and PNG images.";
    dj($output);
}

$img_name       =   get_random_string(16) . "." . $img_ext;
$header_img     =   $user['upl_dir'] . "/" . $img_name;

if( !move_uploaded_file($upl_img['tmp_name'], "../../uploads/" . $header_img ) ){
    $response['message']    =   "Image could not be uploaded.";
    dj($response);
}

$updateUserQuery   =   $db->prepare("UPDATE users SET header_img = :img WHERE id = :uid");
$updateUserQuery->execute(array(
    ":img"      =>  $header_img,
    ":uid"      =>  $_SESSION['uid']
));

$response['status']     =   2;
$response['message']    =   "Header image successfully uploaded!";
$response['img']        =   $header_img;
dj($response);