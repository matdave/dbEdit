<?php
$page = $modx->newObject('modResource');
$page->fromArray(array(
    'pagetitle' => 'Search Results'
    ,'alias' => 'search-results'
    ,'published' => 1
    ,'richtext' => 0
    ,'content' => '[[!SimpleSearch]]'
    ,'hidemenu' => 0
    ,'pub_date' => mktime()
));

return $page
?>