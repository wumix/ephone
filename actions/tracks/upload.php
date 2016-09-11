<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/1/2015
 * Time: 10:19 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$response                       =   array( 'status' => 1, 'message' => 'You must be logged in.' );

if( !isset($_SESSION['loggedin']) ){
    dj($response);
}

if(!isset($_FILES['track'])){
    $response['message']        =   "Please upload a file.";
    dj($response);
}

$user                           =   get_user();

if($settings['validate_email'] == 1 && $user['email_confirmed'] == 1){
    $response['message']        =   "Confirm your email first before uploading.";
    dj($response);
}

$track                          =   $_FILES['track'];
$max_size                       =   $user['isPro'] == 1 ? $settings['regular_track_size'] : $settings['pro_track_size'];
$max_size                       *=  (1024 * 1024);
$max_storage                    =   $user['isPro'] == 1 ? $settings['regular_storage_size'] : $settings['pro_storage_size'];
$max_storage                    *=  (1024 * 1024);
$file_ext                       =   get_extension($track['name']);

if($track['error'] != 0 || $file_ext != "mp3" || $track['size'] < 1024 ){
    $response['message']        =   "Invalid File Upload! ";
    dj($response);
}

if($track['size'] > $max_size){
    $response['message']        =   "File track too big! Try purchasing our pro membership to upload bigger file sizes.";
    dj($response);
}

$trackStorageQuery              =   $db->prepare("SELECT SUM(track_size) as `storageSize` FROM tracks WHERE uid = :uid");
$trackStorageQuery->execute(array(
    ":uid"                      =>  $_SESSION['uid']
));
$trackStorageRow                =   $trackStorageQuery->fetch();
$userStorage                    =   $trackStorageRow['storageSize'] + $track['size'];

if($userStorage > $max_storage){
    $response['message']        =   "You can not upload anymore tracks. You have exceeded your storage amount. Try upgrading to pro to have a bigger storage size.";
    dj($response);
}

$track_name                     =   get_random_string(mt_rand(6,10)) . ".mp3";
$track_header_img               =   'headers/t' . mt_rand( 1, 10 ) . '.jpg';
$upl_dir                        =   $user['upl_dir'] . "/" . $track_name;

if( !move_uploaded_file($track['tmp_name'], "../../uploads/" . $upl_dir ) ){
    $response['message']        =   "File could not be uploaded. Try again later.";
    dj($response);
}

$insertTrackQuery               =   $db->prepare("INSERT INTO tracks(title,uid,username,upl_dir,track_name,original_name,artist,track_header_img,downloadable)
                                                  VALUES( :title, :uid, :username, :upl, :track, :original, :artist, :thi, :dl )");
$insertTrackQuery->execute(array(
    ":title"                    =>  secure($track['name']),
    ":uid"                      =>  $_SESSION['uid'],
    ":username"                 =>  $_SESSION['username'],
    ":upl"                      =>  $upl_dir,
    ":track"                    =>  $track_name,
    ":original"                 =>  secure($track['name']),
    ":artist"                   =>  $user['display_name'],
    ":thi"                      =>  $track_header_img,
    "dl"                        =>  $settings['default_download_opt']
));
$response['status']             =   2;
$response['message']            =   "Track Uploaded Successfully!";
$response['track']              =   array(
    "id"                        =>  $db->lastInsertId(),
    "title"                     =>  secure($track['name']),
    "original_name"             =>  secure($track['name'])
);
dj($response);