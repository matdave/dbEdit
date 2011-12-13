<?php
include 'config.core.php';

include MODX_CORE_PATH.'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');

// Get the xPDO object
require_once 'core/components/dbedit/processors/mgr/dbedit/xpdo.config.php';

// Add the dbedit package to xPDO
$modelPath = $modx->getOption('core_path') . 'components/dbedit/model/';
$xpdo->addPackage('dbedit', $modelPath);

// These are the classes I want to work with.
$arrClasses = array('Sfowner', 'Sfstores', 'Sfstoreowner');

foreach($arrClasses as $class)
{
    echo '<h2>'.$class.'</h2>';
    
    $arrAggregates = $xpdo->getAggregates($class);

    if(count($arrAggregates) > 0)
    {
        echo "Aggregates:  <br />";
        foreach($arrAggregates as $aggregate)
        {
            if($aggregate['cardinality'] == 'one')
            {
                echo '<pre>';
                print_r($aggregate);
                echo '</pre>';

                $arrAliases = $xpdo->getFieldAliases($aggregate['class']);
                if($arrAliases['dbeditDescription'])
                {
                    $descColumn = $arrAliases['dbeditDescription'];
                }
                $idColumn = $aggregate['foreign'];

                $arrObjects = $xpdo->getCollection($aggregate['class']);
                foreach($arrObjects as $object)
                {
                    $arrListItems[$object->get($idColumn)] = $object->get($descColumn);
                }

                print_r($arrListItems);
            }
        }

    }


    $arrComposites = $xpdo->getComposites($class);
    if(count($arrComposites) > 0)
    {
        echo "Composites:  <br />";
        foreach($arrComposites as $composite)
        {
            if($composite['cardinality'] == 'one')
            {
                echo '<pre>';
                print_r($composite);
                echo '</pre>';
            }
        }
    }
}

?>
