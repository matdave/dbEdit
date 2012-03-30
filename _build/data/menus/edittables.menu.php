<?php
$action= $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 10000,
    'namespace' => 'dbedit',
    'controller' => 'index',
),'',true,true);

$menu= $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'dbedit.edit_tables',
    'description' => 'dbedit.edit_tables_desc',
    'params' => '&action=records',
),'',true,true);
$menu->addOne($action);

return $menu;
?>
