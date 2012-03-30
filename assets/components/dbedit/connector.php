<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

$coreConfig = dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once $coreConfig;

require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
$corePath = $modx->getOption('dbedit.core_path',null,$modx->getOption('core_path'));
require_once $corePath.'components/dbedit/model/dbedit.class.php';

$modx->dbedit = new Dbedit($modx);

$modx->lexicon->load('dbedit:default');

$path = $modx->getOption('processorsPath',$modx->dbedit->config,$corePath.'processors/');

$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
?>
