<?php
    $snippet= $modx->newObject('modSnippet');
    $snippet->fromArray(array(
        'name' => 'Title'
        ,'description' => 'Generates a dynamic page title for SEO.'
        ,'snippet' => getSnippetContent(dirname(__FILE__).'/content/title.content.php')
    ));
   
    return $snippet;
?>