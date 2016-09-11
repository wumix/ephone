<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/5/2015
 * Time: 5:04 PM
 */

require( '../../inc/db.php' );
include( '../../inc/func.inc.php' );

$output             =   array();
$params             =    get_params();
$offset             =   intval($params['offset']);

$commentsQuery      =   $db->prepare("
SELECT comments.id,comments.time_created,comments.comment,users.display_name,users.profile_img
FROM comments
INNER JOIN users
ON comments.uid = users.id
WHERE tid = :tid
ORDER BY comments.id DESC
LIMIT " .$offset . ", " . $settings['search_count'] ."
");
$commentsQuery->execute(array(
    ":tid"  =>  $params['tid']
));
$commentsRow        =   $commentsQuery->fetchAll(PDO::FETCH_ASSOC);

$output['comments'] =   $commentsRow;
dj($output);