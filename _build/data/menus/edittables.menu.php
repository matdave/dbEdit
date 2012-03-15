<?php
$action= $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 10000,
    'namespace' => 'dbedit',
    'parent' => 0,
    'controller' => 'controllers/edit_records',
    'haslayout' => true,
    'lang_topics' => 'dbedit:default',
    'assets' => '',
),'',true,true);

$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'dbedit.edit_tables',
    'parent' => 'Database Editor',
    'description' => 'dbedit.edit_tables_desc',
    'icon' => '',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
),'',true,true);
$menu->addOne($action);


return $menu;
?>
