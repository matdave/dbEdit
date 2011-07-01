<?php

$class = $modx->getOption('tableClass', $scriptProperties, '');
$table = $modx->getOption('userTable', $scriptProperties, '');

include($modx->getOption('core_path').'config/config.inc.php');

$xpdo = new xPDO($database_dsn, $database_user, $database_password, array(xPDO::OPT_TABLE_PREFIX => $modx->getOption('dbedit.prefix')));

$modelPath = $modx->getOption('core_path') . 'components/dbedit/model/';

$xpdo->addPackage('dbedit', $modelPath);

if (empty($scriptProperties['id'])) return $modx->error->failure($class.' not specified.');
$object = $xpdo->getObject($class,$scriptProperties['id']);
if (empty($object)) return $modx->error->failure($class.' not found.');

/* remove */
if ($object->remove() == false) {
    return $modx->error->failure('An error occurred while trying to remove the '. $class. '.');
}


return $modx->error->success('',$object);
?>
