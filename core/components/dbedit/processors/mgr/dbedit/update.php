<?php
$class = $modx->getOption('tableClass', $scriptProperties, '');
$table = $modx->getOption('userTable', $scriptProperties, '');

include 'xpdo.config.php';

if (empty($scriptProperties['id'])) return $modx->error->failure($class.' not specified.');
$object = $xpdo->getObject($class,$scriptProperties['id']);
if (empty($object)) return $modx->error->failure($class.' not found.');

/* set fields */
$object->fromArray($scriptProperties);

/* save */
if ($object->save() == false) {
    return $modx->error->failure('An error occurred while trying to save the '. $class .'.');
}

return $modx->error->success('',$object);
?>
