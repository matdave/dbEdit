<?php

$page = $modx->newObject('modResource');
$page->fromArray(array(
    'pagetitle' => 'Latest News'
    ,'alias' => 'latest-news'
    ,'published' => 1
    ,'pub_date' => mktime()
));


return $page
?>