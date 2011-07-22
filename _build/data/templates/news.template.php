<?php
$template = $modx->newObject('modTemplate');
$template->fromArray(array(
    'templatename' => 'News Page Template'
    ,'description' => 'Delivered template for news pages.'
    ,'content' => '[[GetTemplate? &tplName=`newspage.template.php`]]'
));

return $template;
?>
