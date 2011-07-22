<?php
$page = $modx->newObject('modResource');

$page->fromArray(array(
    'pagetitle' => 'News Archive'
    ,'alias' => 'news-archive'
    ,'published' => 1
    ,'pub_date' => mktime()
));

return $page;
?>
