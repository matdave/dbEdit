<?php
$coreConfig = dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';

require_once $coreConfig;
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
$corePath = $modx->getOption('dbedit.core_path',null,$modx->getOption('core_path'));
//require_once $corePath.'model/doodles/doodles.class.php';
//$modx->doodles = new Doodles($modx);
// 
//$modx->lexicon->load('en:doodles:default');
// 
///* handle request */
//$path = $modx->getOption('processorsPath',$modx->doodles->config,$corePath.'processors/');

$modx->lexicon->load('dbedit:default');

$path = $corePath.'components/dbedit/processors/';

$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
?>
