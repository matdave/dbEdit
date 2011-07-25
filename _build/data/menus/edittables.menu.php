<?php
$action= $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 10000,
    'namespace' => 'dbedit',
    'parent' => 0,
    'controller' => 'controllers/edit_records',
    'haslayout' => true,
    'lang_topics' => '',
    'assets' => '',
),'',true,true);

$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'Edit Tables',
    'parent' => 'Database Editor',
    'description' => 'Edit the data in your custom tables. ',
    'icon' => '',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
),'',true,true);
$menu->addOne($action);


return $menu;
?>