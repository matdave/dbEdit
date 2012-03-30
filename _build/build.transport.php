<?php
$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);

/* define package names */
define('PKG_NAME', 'DbEdit');
define('PKG_NAME_LOWER', 'dbedit');
define('PKG_VERSION', '1.05');
define('PKG_RELEASE', 'rc1');

/* define build paths */
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root
    ,'build' => $root . '_build/'
    ,'data' => $root . '_build/data/'
    ,'resolvers' => $root . '_build/resolvers/'
    ,'source_core' => $root . 'core/components/'.PKG_NAME_LOWER
    ,'source_assets' => $root . 'assets/components/'.PKG_NAME_LOWER
);

unset($root);

//require_once $sources['build'] . 'includes/functions.php';
require_once $sources['build'].'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');
echo '<pre>'; // used for nice formatting of log messages
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$modx->loadClass('modAccess');
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/'.PKG_NAME_LOWER.'/');

//****************************************************************
//  ADD CUSTOM PERMISSIONS
//***************************************************************
//$permissions = include_once $sources['data'].'transport.permissions.php';
//$attributes= array(
//    xPDOTransport::UNIQUE_KEY => 'name',
//    xPDOTransport::PRESERVE_KEYS => false,
//    xPDOTransport::UPDATE_OBJECT => true,
//);
//if (!is_array($permissions)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding Permissions failed.'); }
//foreach ($permissions as $permission) {
//    $vehicle = $builder->createVehicle($permission,$attributes);
//    $builder->putVehicle($vehicle);
//}
//$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($permissions).' permissions.'); flush();
//unset($permissions,$permission,$attributes);

//**********************************************************************
// CREATE SETTINGS
//********************************************************************
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UNIQUE_KEY => 'key',
    xPDOTransport::UPDATE_OBJECT => false,
);
$settings = include $sources['data'].'transport.settings.php';
if (!is_array($settings)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding Settings failed.'); }
foreach ($settings as $setting) {
    $vehicle = $builder->createVehicle($setting,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($settings).' settings.'); flush();
unset($settings,$setting,$attributes);

//******************************************************
// CREATE DbEdit CATEGORY
//******************************************************
$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category',PKG_NAME);
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in category.'); flush();

//******************************************************
// CREATE CATEGORY VEHICLE
//******************************************************
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true
);
$vehicle = $builder->createVehicle($category,$attr);

//FILE RESOLVERS
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));

$vehicle->resolve('file', array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';"
));

$modx->log(modX::LOG_LEVEL_INFO,'Packaged in file resolvers.'); flush();
$builder->putVehicle($vehicle);

//********************************************************
// CREATE MENU
//**********************************************************
$menus = include $sources['data'].'menus/menus.php';

$modx->log(modX::LOG_LEVEL_INFO,'Packaging in menu...');
$vehicle= $builder->createVehicle($menus['main'],array (
    xPDOTransport::PRESERVE_KEYS => true
,xPDOTransport::UPDATE_OBJECT => true
,xPDOTransport::UNIQUE_KEY => 'text'
));
$builder->putVehicle($vehicle);


$modx->log(modX::LOG_LEVEL_INFO,'Packaging in menu...');
$vehicle= $builder->createVehicle($menus['records'],array (
    xPDOTransport::PRESERVE_KEYS => true
,xPDOTransport::UPDATE_OBJECT => true
,xPDOTransport::UNIQUE_KEY => 'text'
,xPDOTransport::RELATED_OBJECTS => true
,xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
            'Action' => array (
             xPDOTransport::PRESERVE_KEYS => false
            ,xPDOTransport::UPDATE_OBJECT => true
            ,xPDOTransport::UNIQUE_KEY => array ('namespace','controller')
            ),
        ),
    ),
));
$builder->putVehicle($vehicle);

$modx->log(modX::LOG_LEVEL_INFO,'Packaging in menu...');
$vehicle= $builder->createVehicle($menus['schema'],array (
    xPDOTransport::PRESERVE_KEYS => true
,xPDOTransport::UPDATE_OBJECT => true
,xPDOTransport::UNIQUE_KEY => 'text'
,xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
            'Action' => array (
            xPDOTransport::PRESERVE_KEYS => false
            ,xPDOTransport::UPDATE_OBJECT => true
            ,xPDOTransport::UNIQUE_KEY => array ('namespace','controller')
            ),
        ),
    ),
));
$builder->putVehicle($vehicle);

$modx->log(modX::LOG_LEVEL_INFO,'Packaging in menu...');
$vehicle= $builder->createVehicle($menus['relationships'],array (
    xPDOTransport::PRESERVE_KEYS => true
,xPDOTransport::UPDATE_OBJECT => true
,xPDOTransport::UNIQUE_KEY => 'text'
,xPDOTransport::RELATED_OBJECTS => true
,xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
            'Action' => array (
            xPDOTransport::PRESERVE_KEYS => false
            ,xPDOTransport::UPDATE_OBJECT => true
            ,xPDOTransport::UNIQUE_KEY => array ('namespace','controller')
            ),
        ),
    ),
));
$builder->putVehicle($vehicle);



//PHP RESOLVERS
$modx->log(modX::LOG_LEVEL_INFO, 'Packaging PHP resolvers...');
$vehicle->resolve('php', array(
    'source' => $sources['resolvers'].'setup.options.php'
));
$vehicle->resolve('php', array(
    'source' => $sources['resolvers'].'relationships.table.php'
));
$builder->putVehicle($vehicle);

// zip up the package
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->setPackageAttributes(array(
    'setup-options' => array(
        'source' => $sources['build'].'setup.options.php'
    )
));
$builder->pack();

$tend = explode(' ', microtime());
$tend = $tend[1] + $tend[0];
$totalTime = sprintf("%2.4f s", ($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO, "\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit();
?>
