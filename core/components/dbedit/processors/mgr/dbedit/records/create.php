<?php
/**
 * @package doodles
 * @subpackage processors
 */
$class = $modx->getOption('tableClass', $scriptProperties, '');
$table = $modx->getOption('userTable', $scriptProperties, '');

$object = $modx->newObject($class);
$object->fromArray($scriptProperties, '', true);

/* save */
if ($object->save() == false) {
    return $modx->error->failure($modx->lexicon('dbedit.record_err_save'));
}

return $modx->error->success('',$object);