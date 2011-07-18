<?php
include 'xpdo.config.php';

if (empty($scriptProperties['data'])) return $modx->error->failure('Data not found.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Data not found.');

if (empty($_DATA['tableClass'])) return $modx->error->failure($class.' not specified.');
$object = $xpdo->getObject($_DATA['tableClass'],$_DATA['id']);
if (empty($object)) return $modx->error->failure($_DATA['tableClass'].' not found.');

/* set fields */
$object->fromArray($_DATA);

/* save */
if ($object->save() == false) {
    return $modx->error->failure('An error occurred while trying to save the '. $class .'.');
}

return $modx->error->success('',$object);
?>
