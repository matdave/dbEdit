<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
//$corePath = $modx->getOption('gearsmc.core_path',null,$modx->getOption('core_path').'components/doodles/');
//require_once $corePath.'model/doodles/doodles.class.php';
//$modx->doodles = new Doodles($modx);
// 
//$modx->lexicon->load('en:doodles:default');
// 
///* handle request */
//$path = $modx->getOption('processorsPath',$modx->doodles->config,$corePath.'processors/');

$path = 'c:/users/tony/documents/websites/gears.idb.dev/public_html/trans_pkgs/dbedit/core/components/dbedit/processors/';
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
?>
