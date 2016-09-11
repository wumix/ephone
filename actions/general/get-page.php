<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 1/25/2016
 * Time: 1:09 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$params                         =   get_params();
$output                         =   array( 'status' => 1 );

if(!isReady($params, array( 'slug' ) ) ){
    dj($output);
}

$slug                           =   secure($params['slug']);
$pageQuery                      =   $db->prepare("SELECT * FROM pages WHERE page_slug = :ps");
$pageQuery->execute(array(
    ":ps"                       =>  $slug
));

$output['page']                 =   $pageQuery->fetch(PDO::FETCH_ASSOC);
$output['status']               =   2;
dj($output);