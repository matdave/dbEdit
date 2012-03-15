<?php
include($modx->getOption('core_path').'config/config.inc.php');
$xpdo = new xPDO($database_dsn, $database_user, $database_password, array(xPDO::OPT_TABLE_PREFIX => $modx->getOption('dbedit.prefix')));
$modelPath = $modx->getOption('core_path') . 'components/dbedit/model/';
$xpdo->addPackage('dbedit', $modelPath);
?>
