<?php
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $object->xpdo;
            $modelPath = $modx->getOption('dbedit.core_path', null, $modx->getOption('core_path').'components/dbedit/').'model/';
            $modx->addPackage('dbedit', $modelPath, $modx->getOption('dbedit.prefix'));
            $manager = $modx->getManager();

            $manager->createObjectContainer('Relationships');

            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
    }
}
return true;
