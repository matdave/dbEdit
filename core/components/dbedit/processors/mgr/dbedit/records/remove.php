<?php

$class = $modx->getOption('tableClass', $scriptProperties, '');
$table = $modx->getOption('userTable', $scriptProperties, '');
$id = $modx->getOption($modx->getOption('tablePriKey', $scriptProperties, 'id'), $scriptProperties, '');

$object = $modx->getObject($class,$id);

if (empty($object)) return $modx->error->failure($class.' not found.');

/* remove */
if ($object->remove() == false) {
    return $modx->error->failure($modx->lexicon('dbedit.record_err_save'));
}

return $modx->error->success('',$object);
?>
