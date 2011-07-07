<?php

$dbeditConfig = array();

$dbeditConfig['corePath'] = $modx->getOption('dbedit.core_path',null,$modx->getOption('core_path'));
$dbeditConfig['assetsUrl'] = $modx->getOption('dbedit.assets_url',null,$modx->getOption('assets_url'));
$dbeditConfig['connectorUrl'] = $dbeditConfig['assetsUrl'].'components/dbedit/connector.php';

?>
