<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tony
 * Date: 3/23/12
 * Time: 1:44 PM
 * To change this template use File | Settings | File Templates.
 */

// THE MAIN MENU ITEM
$main = $modx->newObject('modMenu');
$main -> fromArray(array(
    'text' => 'DbEdit'
    ,'icon' => 'images/icons/database.png'
), '', true, true);

// THE DBEDIT CONTROLLER
$action= $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 10000
    ,'namespace' => 'dbedit'
    ,'controller' => 'index'
),'',true,true);

// EDIT RECORDS MENU ITEM
$records= $modx->newObject('modMenu');
$records->fromArray(array(
    'text' => 'dbedit.edit_records'
    ,'description' => 'dbedit.edit_records_desc'
    ,'params' => '&action=records'
    ,'parent' => 'DbEdit'
    ,'action' => 'index'
),'',true,true);
$records->addOne($action);

// MANAGE SCHEMA MENU ITEM
$schema= $modx->newObject('modMenu');
$schema->fromArray(array(
    'text' => 'dbedit.schema_manage'
    ,'parent' => 'DbEdit'
    ,'description' => 'dbedit.schema_desc'
    ,'params' => '&action=schema'
),'',true,true);
$schema->addOne($action);

// RELATIONSHIPS MENU ITEM
$relationships= $modx->newObject('modMenu');
$relationships->fromArray(array(
    'text' => 'dbedit.manage_relationships'
    ,'parent' => 'DbEdit'
    ,'description' => 'dbedit.manage_relationships_desc'
    ,'params' => '&action=relationships'
),'',true,true);
$relationships->addOne($action);

$menus = array(
    'main' => $main
    ,'records' => $records
    ,'schema' => $schema
    ,'relationships' => $relationships
);

return $menus;