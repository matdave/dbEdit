<?php
    $snippet= $modx->newObject('modSnippet');
    $snippet->fromArray(array(
        'name' => 'Description'
        ,'description' => 'Generates a dynamic description for SEO.'
        ,'snippet' => getSnippetContent(dirname(__FILE__).'/content/description.content.php')
    ));
   
    return $snippet;
?>