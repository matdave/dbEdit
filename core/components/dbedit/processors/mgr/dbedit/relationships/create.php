<?php
$object = $modx->newObject('Relationships');
$object->fromArray($scriptProperties);

/* save */
if ($object->save() == false) {
    return $modx->error->failure($modx->lexicon('dbedit.record_err_save'));
}

return $modx->error->success('',$object);