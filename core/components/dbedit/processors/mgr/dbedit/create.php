<?php
/**
 * @package doodles
 * @subpackage processors
 */
$class = $modx->getOption('tableClass', $scriptProperties, '');
$table = $modx->getOption('userTable', $scriptProperties, '');
//if (empty($scriptProperties['name'])) {
//    $modx->error->addField('name',$modx->lexicon('doodles.doodle_err_ns_name'));
//} else {
//    $alreadyExists = $modx->getObject('Doodle',array('name' => $scriptProperties['name']));
//    if ($alreadyExists) {
//        $modx->error->addField('name',$modx->lexicon('doodles.doodle_err_ae'));
//    }
//}
//
//
//if ($modx->error->hasError()) {
//    return $modx->error->failure();
//}

include($modx->getOption('core_path').'config/config.inc.php');

$xpdo = new xPDO($database_dsn, $database_user, $database_password, array(xPDO::OPT_TABLE_PREFIX => $modx->getOption('dbedit.prefix')));

$modelPath = $modx->getOption('core_path') . 'components/dbedit/model/';

$xpdo->addPackage('dbedit', $modelPath);

$object = $xpdo->newObject($class);
$object->fromArray($scriptProperties);

/* save */
if ($object->save() == false) {
    return $modx->error->failure($class.' not saved.');
}


return $modx->error->success('',$object);