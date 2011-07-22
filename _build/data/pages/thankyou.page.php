<?php
$page = $modx->newObject('modResource');
$page->fromArray(array(
    'pagetitle' => 'Thanks for contacting us!'
    ,'alias' => 'thanks-for-contacting-us'
    ,'published' => 1
    ,'hidemenu' => 1
    ,'pub_date' => mktime()
));

return $page
?>