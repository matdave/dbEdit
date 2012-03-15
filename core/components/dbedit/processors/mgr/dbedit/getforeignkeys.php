<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tony
 * Date: 12/9/11
 * Time: 1:20 PM
 * To change this template use File | Settings | File Templates.
 */
 
$class = $modx->getOption('class', $scriptProperties, '');
$id = $modx->getOption('id', $scriptProperties, '');
$label = $modx->getOption('label', $scriptProperties, '');

include 'xpdo.config.php';
// lexiconize
if (empty($scriptProperties['id'])) return $modx->error->failure($class.' not specified.');
$object = $xpdo->getObject($class,$scriptProperties['id']);
// lexiconize
if (empty($object)) return $modx->error->failure($class.' not found.');

$arrObjects = $xpdo->getCollection($class);
foreach($arrObjects as $object)
{
    $arrListItems[] = array(
        'id' => $object->get($id)
        ,'label' => $object->get($label)
    );
}

return $this->outputArray($arrListItems);
?>