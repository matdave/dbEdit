<?php
$page = $modx->newObject('modResource');
$page->fromArray(array(
    'pagetitle' => 'Contact Us'
    ,'alias' => 'contact-us'
    ,'published' => 1
    ,'hidemenu' => 0
    ,'pub_date' => mktime()
));

return $page
?>