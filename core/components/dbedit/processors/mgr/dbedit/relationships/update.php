<?php
$class = 'Relationships';

// lexiconize
if (empty($scriptProperties['id'])) return $modx->error->failure($class.' not specified.');
$object = $modx->getObject($class,$scriptProperties['id']);
// lexiconize
if (empty($object)) return $modx->error->failure($class.' not found.');

/* set fields */
$object->fromArray($scriptProperties);

/* save */
if ($object->save() == false) {
    return $modx->error->failure($modx->lexicon('dbedit.record_err_save'));
}

return $modx->error->success('',$object);
?>
