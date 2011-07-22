<?php
$page = $modx->newObject('modResource');
$page->fromArray(array(
    'pagetitle' => 'Sitemap'
    ,'alias' => 'sitemap'
    ,'published' => 1
    ,'hidemenu' => 1
    ,'pub_date' => mktime()
    ,'content' => '[[!Wayfinder? &startId=`0` &ignoreHidden=`TRUE`]]'
));

return $page
?>