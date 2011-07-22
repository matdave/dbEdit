<?php
$page = $modx->newObject('modWeblink');
$page->fromArray(array(
    'pagetitle' => 'News'
    ,'parent' => 0
    ,'content' => '[[~[[++gears.newsId]]]]'
    ,'alias' => 'news'
    ,'published' => 1
    ,'isfolder' => true
    ,'pub_date' => mktime()
));
 return $page;
?>