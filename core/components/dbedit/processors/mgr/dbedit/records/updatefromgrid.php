<?php
if (empty($scriptProperties['data'])) return $modx->error->failure('Data not found.');

$_DATA = $modx->fromJSON($scriptProperties['data']);

$class = $_DATA['tableClass'];
$pri_key = $_DATA['tablePriKey'];
$id = $_DATA[$pri_key];

if (!is_array($_DATA)) return $modx->error->failure('Data not found.');

if (empty($class)) return $modx->error->failure($class.' not specified.');

$object = $modx->getObject($class,array($pri_key => $id));

if (empty($object)) return $modx->error->failure($class.' not found.');

/* set fields */
$object->fromArray($_DATA);

/* save */
if ($object->save() == false)
{
    return $modx->error->failure('An error occurred while trying to save the '. $class .'.');
}

return $modx->error->success('',$object);
?>
