<?php
$page = $modx->newObject('modResource');

$page->fromArray(array(
    'pagetitle' => 'The page you are looking for does not exist'
    ,'alias' => 'not-found'
	 ,'content' => include(dirname(__FILE__).'/content/error.content.php')
    ,'published' => 1
    ,'pub_date' => mktime()
));

return $page;
?>