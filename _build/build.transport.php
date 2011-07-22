<?php
$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);

/* define package names */
define('PKG_NAME', 'DbEdit');
define('PKG_NAME_LOWER', 'dbedit');
define('PKG_VERSION', '1.0');
define('PKG_RELEASE', 'rc1');

/* define build paths */
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root
    ,'build' => $root . '_build/'
    ,'data' => $root . '_build/data/'
    ,'resolvers' => $root . '_build/resolvers/'
    ,'source_core' => $root . 'core/components/'.PKG_NAME_LOWER
    ,'gears_theme' => $root . 'public_html/gears/templates/'.PKG_NAME_LOWER
    ,'gears_controller' => $root . 'public_html/gears/controllers/'.PKG_NAME_LOWER
    ,'gears_assets' => $root . 'public_html/gears/assets/'.PKG_NAME_LOWER
    ,'site_files' => $root . 'public_html/site_files' 
);

unset($root);

require_once $sources['build'] . 'includes/functions.php';
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
$permissions = include_once $sources['data'].'transport.permissions.php';
$attributes= array(
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
);
if (!is_array($permissions)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding Permissions failed.'); }
foreach ($permissions as $permission) {
    $vehicle = $builder->createVehicle($permission,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($permissions).' permissions.'); flush();
unset($permissions,$permission,$attributes);

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

//****************************************************************
// ADD CUSTOM ACCESS POLICIES
//***************************************************************
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UNIQUE_KEY => array('name'),
    xPDOTransport::UPDATE_OBJECT => true,
);
$policies = include $sources['data'].'transport.policies.php';
if (!is_array($policies)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding policies failed.'); }
foreach ($policies as $policy) {
    $vehicle = $builder->createVehicle($policy,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($policies).' Access Policies.'); flush();
unset($policies,$policy,$attributes);

//******************************************************************
// ADD THE MANAGER USER AND GROUP
//*****************************************************************
$memberships = include $sources['data'].'transport.usersgroups.php';
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UNIQUE_KEY => array('id'),
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'User' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array ('username'),
        ),
        'UserGroup' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array ('name'),
        )
    ),
);
if (is_array($memberships)) {
    foreach ($memberships as $membership) {
        $vehicle = $builder->createVehicle($membership,$attributes);
        $builder->putVehicle($vehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($memberships).' Group Memberships'); flush();
} else {
    $modx->log(modX::LOG_LEVEL_ERROR,'Could not package in Group Memberships');
}
unset ($memberships, $membership ,$attributes);

//**********************************************************************
// CREATE TEMPLATES
//********************************************************************
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UNIQUE_KEY => array('templatename'),
    xPDOTransport::UPDATE_OBJECT => true,
);
$templates = include $sources['data'].'transport.templates.php';
if (!is_array($templates)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding templates failed.'); }
foreach ($templates as $template) {
    $vehicle = $builder->createVehicle($template,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($templates).' Templates.'); flush();
unset($templates,$template,$attributes);

//**********************************************************************
// CREATE PAGES
//********************************************************************
$attributes = array (
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UNIQUE_KEY => array('pagetitle'),
    xPDOTransport::UPDATE_OBJECT => true,
);
$pages = include $sources['data'].'transport.pages.php';
if (!is_array($pages)) { $modx->log(modX::LOG_LEVEL_FATAL,'Adding pages failed.'); }
foreach ($pages as $page) {
    $vehicle = $builder->createVehicle($page,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($pages).' pages.'); flush();
unset($pages,$page,$attributes);

//******************************************************
// CREATE GEARS CATEGORY
//******************************************************
$category= $modx->newObject('modCategory');
$category->set('id',1);
$category->set('category',PKG_NAME);
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in category.'); flush();

//**********************************************************************
// CREATE CHUNKS
//********************************************************************
$chunks = include $sources['data'].'transport.chunks.php';
if (is_array($chunks)) 
{ 
    $category->addMany($chunks, 'Chunks');
}
else
{$modx->log(modX::LOG_LEVEL_FATAL,'Adding chunks failed.');}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($chunks).' chunks.'); 
flush();
unset($chunks);

//******************************************************
// LOAD SNIPPETS
//******************************************************
$snippets = include $sources['data'].'transport.snippets.php';
if (is_array($snippets)) 
{
    $category->addMany($snippets,'Snippets');
} 
else 
{ $modx->log(modX::LOG_LEVEL_FATAL,'Adding snippets failed.'); }
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($snippets).' snippets.'); flush();
unset($snippets);

//******************************************************
// CREATE CATEGORY VEHICLE
//******************************************************
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Chunks' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    )
);
$vehicle = $builder->createVehicle($category,$attr);


//FILE RESOLVERS
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));

$vehicle->resolve('file', array(
    'source' => $sources['gears_theme'],
    'target' => "return MODX_MANAGER_PATH . 'templates/';"
));

$vehicle->resolve('file', array(
    'source' => $sources['gears_controller'],
    'target' => "return MODX_MANAGER_PATH . 'controllers/';"
));

$vehicle->resolve('file', array(
    'source' => $sources['gears_assets'],
    'target' => "return MODX_MANAGER_PATH . 'assets/';"
));
/*
$vehicle->resolve('file', array(
    'source' => $sources['site_files'],
    'target' => "return MODX_BASE_PATH;"
));
*/

//PHP RESOLVERS
$dir = dirname(__FILE__).'/resolvers/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        { 
            $vehicle->resolve('php', array(
                'source' => $dir.$file
            ));
        }

    }
}

$modx->log(modX::LOG_LEVEL_INFO,'Packaged in resolvers.'); flush();
$builder->putVehicle($vehicle);

// zip up the package
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$tend = explode(' ', microtime());
$tend = $tend[1] + $tend[0];
$totalTime = sprintf("%2.4f s", ($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO, "\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
exit();
?>
