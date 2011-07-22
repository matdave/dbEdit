<?php
    $snippet= $modx->newObject('modSnippet');
    $snippet->fromArray(array(
        'name' => 'GetTemplate'
        ,'description' => 'Gets the template code from a file.'
        ,'snippet' => getSnippetContent(dirname(__FILE__).'/content/gettemplate.content.php')
    ));
   
    return $snippet;
?>