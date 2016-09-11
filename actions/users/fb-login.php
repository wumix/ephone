<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 6/11/2015
 * Time: 4:26 PM
 */

require( '../../inc/db.php' );
require( '../../inc/func.inc.php' );

$params         =   json_decode(file_get_contents('php://input'), true);
$output                 =   array('status' => 1);

if( !isReady($params, array('name','email','id')) ){
    dj($output);
}

$username               =   str_replace(" ", "_", secure($params['name']));
$email                  =   secure($params['email']);
$pass                   =   secure($params['id'], true);
$token                  =   get_random_string(mt_rand(32,86));
$expires                =   time() + (86400 * 365);
$ip                     =   secure($_SERVER['REMOTE_ADDR']);

$existsQuery            =   $db->prepare("SELECT `id`,`username`,`isAdmin` FROM users
                                          WHERE username = :u AND pass = :p AND email = :e");
$existsQuery->execute(array(
    ":u"                =>  $username,
    ":p"                =>  $pass,
    ":e"                =>  $email
));

if($existsQuery->rowCount() !== 1){
    $user_dir               =   get_random_string(1, true) . "/" . mt_rand(1,10) . "/" . $username;
    if(!mkdir("../../uploads/" . $user_dir, 0777, true)){
        dj($output);
    }
    $token              =   get_random_string( mt_rand(32,128) );
    $header_img     =   "headers/" . mt_rand(1,9) . ".jpg";

    $insertUserQuery    =   $db->prepare("INSERT INTO users(username,pass,email,ip,upl_dir,display_name,header_img,user_code,email_confirmed) VALUES( :u, :p, :e, :i, :upl, :dn, :hi, :uc, :ec )");
    $insertUserQuery->execute(array(
        ":u"    =>  $username,
        ":p"    =>  $pass,
        ":e"    =>  $email,
        ":i"    =>  $ip,
        ":upl"  =>  $user_dir,
        ":dn"   =>  $username,
        ":hi"   =>  $header_img,
        ":uc"   =>  md5($username),
        ":ec"   =>  2
    ));

    $_SESSION['uid']        =   $db->lastInsertId();

    $token              =   get_random_string( mt_rand(32,128) );
    $expires            =   time() + 15552000;
    $addTokenQuery      =   $db->prepare("UPDATE users SET login_token = :token, token_exp = :exp WHERE id = :id");
    $addTokenQuery->execute(array(
        ":token"    =>  $token,
        ":exp"      =>  $expires,
        ":id"       =>  $_SESSION['uid']
    ));

    $_SESSION['username']   =   $username;
}else{
    $existsRow              =   $existsQuery->fetch(PDO::FETCH_ASSOC);

    if($existsRow['isAdmin'] == 2){
        $_SESSION['isAdmin']    =   true;
    }

    $_SESSION['username']   =   $existsRow['username'];
    $_SESSION['uid']        =   $existsRow['id'];

    $token              =   get_random_string( mt_rand(32,128) );
    $expires            =   time() + 15552000;
    $addTokenQuery      =   $db->prepare("UPDATE users SET login_token = :token, token_exp = :exp WHERE id = :id");
    $addTokenQuery->execute(array(
        ":token"    =>  $token,
        ":exp"      =>  $expires,
        ":id"       =>  $existsRow['id']
    ));
}

$_SESSION['loggedin']   =   true;
setcookie( "rt", $token, $expires, "/" );
$output['status']       =   2;

dj($output);