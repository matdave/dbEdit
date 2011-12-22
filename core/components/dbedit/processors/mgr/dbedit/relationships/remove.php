<?php

$class = 'Relationships';

include dirname(dirname(__FILE__)).'/xpdo.config.php';

if (empty($scriptProperties['id'])) return $modx->error->failure($class.' not specified.');

$object = $xpdo->getObject($class,$scriptProperties['id']);

if (empty($object)) return $modx->error->failure($class.' not found.');

/* remove */
if ($object->remove() == false) {
    return $modx->error->failure('An error occurred while trying to remove the '. $class. '.');
}

return $modx->error->success('',$object);
?>
