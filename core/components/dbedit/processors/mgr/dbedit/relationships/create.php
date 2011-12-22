<?php
include dirname(dirname(__FILE__)).'/xpdo.config.php';

$class = 'Relationships';

$object = $xpdo->newObject($class);
$object->fromArray($scriptProperties);

/* save */
if ($object->save() == false) {
    return $modx->error->failure($modx->lexicon('dbedit.record_err_save'));
}

return $modx->error->success('',$object);