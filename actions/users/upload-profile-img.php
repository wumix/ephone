<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/7/2015
 * Time: 10:26 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output             =   array( 'status' => 1, 'message' => 'You can not update this profile.' );
$max_size           =   ( $settings['profile_img_size'] * 1024 ) * 1000;

if( !isReady($_FILES,array("file")) || !isset($_SESSION['loggedin'])){
    dj($output);
}

$user               =   get_user();
$upl_img            =   $_FILES['file'];
$img_ext            =   get_extension($upl_img['name']);

if($upl_img['error'] != 0){
    $output['message']  =   "We were unable to upload your profile image. Try again later.";
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

$img_name           =   get_random_string(16) . "." . $img_ext;
$profie_img         =   $user['upl_dir'] . "/" . $img_name;

if( !move_uploaded_file($upl_img['tmp_name'], "../../uploads/" . $profie_img ) ){
    $response['message']    =   "Profile image could not be uploaded.";
    dj($response);
}

$updateUserQuery    =   $db->prepare("UPDATE users SET profile_img = :img WHERE id = :uid");
$updateUserQuery->execute(array(
    ":img"          =>  $profie_img,
    ":uid"          =>  $_SESSION['uid']
));

$response['status']     =   2;
$response['message']    =   "Profile image successfully uploaded!";
$response['img']        =   $profie_img;
dj($response);