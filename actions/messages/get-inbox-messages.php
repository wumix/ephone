<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 3/23/2015
 * Time: 6:58 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                 =   get_params();
$output                 =   array( 'status' => 1 );

if(!isset($_SESSION['loggedin'])){
    dj($output);
}

$getInboxMessagesQuery  =   $db->prepare("
SELECT `from_user` FROM messages
WHERE to_user = :u
GROUP BY `from_user`
ORDER BY `id` DESC LIMIT 25
");
$getInboxMessagesQuery->execute(array(
    ":u"                =>  $_SESSION['username']
));

$output['users']        =   $getInboxMessagesQuery->fetchAll(PDO::FETCH_ASSOC);
$output['status']       =   2;
dj($output);