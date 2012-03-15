<?php
$action= $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 10001,
    'namespace' => 'dbedit',
    'parent' => 0,
    'controller' => 'controllers/manage_schema',
    'haslayout' => true,
    'lang_topics' => 'dbedit:default',
    'assets' => '',
),'',true,true);

$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'dbedit.schema_manage',
    'parent' => 'Database Editor',
    'description' => 'dbedit.schema_desc',
    'icon' => '',
    'menuindex' => 0,
    'params' => '',
    'handler' => '',
),'',true,true);
$menu->addOne($action);


return $menu;
?>
