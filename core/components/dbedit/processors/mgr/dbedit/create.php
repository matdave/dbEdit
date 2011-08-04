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

include 'xpdo.config.php';

$object = $xpdo->newObject($class);
$object->fromArray($scriptProperties);

/* save */
if ($object->save() == false) {
    return $modx->error->failure($modx->lexicon('dbedit.record_err_save'));
}

return $modx->error->success('',$object);