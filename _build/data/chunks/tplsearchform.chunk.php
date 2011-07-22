<?php

$chunk = $modx->newObject('modChunk');
$chunk->fromArray(array(
    'name' => 'tplSearchForm'
    ,'description' => 'The template for the default search form.'
    ,'snippet' => include(dirname(__FILE__).'/content/tplsearchform.content.php')
));

return $chunk;

?>
