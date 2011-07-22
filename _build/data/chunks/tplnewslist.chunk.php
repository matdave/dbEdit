<?php

$chunk = $modx->newObject('modChunk');
$chunk->fromArray(array(
    'name' => 'tplNewsList'
    ,'description' => 'Template for displaying news stories.'
    ,'snippet' => include(dirname(__FILE__).'/content/tplnewslist.content.php')
));

return $chunk;

?>
