<?php
/*$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');
 
$prefix = $modx->getOption('dbedit.prefix');*/

//$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");



include 'C:\Users\tony\Documents\Websites\gears.idb.dev\public_html\trans_pkgs\dbedit\config.core.php';

include MODX_CORE_PATH.'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');


$arrTables = array();

require_once 'xpdo.config.php';

$prefix="user_";
$results = $xpdo->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll(PDO::FETCH_NUM);

// Flatten the Array
foreach($tables as $table)
{
    $arrTableNames[] = $table[0];
}

$arrTables = array();


foreach($arrTableNames as $tableName)
{
    // Generate the xPDO class name for the table
    $className = tableToClassName($tableName);
    
    // Test to see if the class has an associated table
    $tester = $xpdo->getTableName($className);

    // If the class doesn't have an associated table, then its schema hasn't been generated yet,
    // so we don't return it to CMP
    if($tester != '')
    {

        $arrFieldMeta = $xpdo->getFieldMeta($className);
        $arrFieldAliases = $xpdo->getFieldAliases($className);

        $statuses = $xpdo->query("SHOW TABLE STATUS LIKE '".$tableName."'");
        $statuses = $statuses->fetchAll(PDO::FETCH_ASSOC);

        $columns = $xpdo->query("SHOW FULL COLUMNS FROM $tableName");
        $columns = $columns->fetchAll(PDO::FETCH_ASSOC);

        foreach($arrFieldMeta as $column_name => &$arrFields)
        {
            foreach($columns as $column)
            {
                if($column['Field'] == $column_name)
                {
                    $arrFields['columnName'] = $column_name;
                    $arrFields['label'] = $column['Comment'];
                    $arrFields['extra'] = $column['Extra'];
                    $arrFields['relationships'] = getRelationships($className, $column_name, $xpdo);
                }
            }

            $arrMetaNumIndexed[] = $arrFields;
        }

        $arrTables[]= array(
            'tableName' => $statuses[0]['Name']
            ,'className' => $className
            ,'label' => $statuses[0]['Comment']
            ,'columns' => $arrMetaNumIndexed
            //,'relationships' => getRelationships($className, $xpdo)
        );

        unset($arrMetaNumIndexed);

    }
}

echo '<pre>';
        print_r($arrTables);
        echo '</pre>';
/*
echo '<pre>';
print_r($arrPdoTables);
echo '</pre>';*/

/*echo '<pre>';
print_r($arrTables);
echo '</pre>';*/


function tableToClassName($tableName)
{
    $arrName = explode('_', $tableName);

    unset($arrName[0]);

    foreach($arrName as &$name)
    {
        $name = ucfirst($name);
    }

    return implode('', $arrName);
}

function getRelationships($className, $columnName, &$xpdo)
{
    $arrRelationships = array();

    $arrAggregates = $xpdo->getAggregates($className);

    if(count($arrAggregates) > 0)
    {

        foreach($arrAggregates as $aggregate)
        {
            echo 'Column Name:  '.$columnName.'<br />';
            echo 'Local:  '.$aggregate['local'].'<br />';
            if($aggregate['cardinality'] == 'one' && $aggregate['local'] == $columnName)
            {
                $arrAliases = $xpdo->getFieldAliases($aggregate['class']);
                if($arrAliases['dbeditDescription'])
                {
                    $descColumn = $arrAliases['dbeditDescription'];
                }
                else
                {
                    $descColumn = 'name';
                }

                $arrRelationships[] = array(
                    'column' => $aggregate['local']
                    ,'class' => $aggregate['class']
                    ,'foreign' => $aggregate['foreign']
                    ,'label' => $descColumn
                );
            }
        }

    }


    $arrComposites = $xpdo->getComposites($className);
    if(count($arrComposites) > 0)
    {
        foreach($arrComposites as $composite)
        {
            if($composite['cardinality'] == 'one')
            {
                $arrAliases = $xpdo->getFieldAliases($composite['class']);
                if($arrAliases['dbeditDescription'])
                {
                    $descColumn = $arrAliases['dbeditDescription'];
                }
                else
                {
                    $descColumn = 'name';
                }

                $arrRelationships[] = array(
                    'column' => $composite['local']
                    ,'class' => $composite['class']
                    ,'foreign' => $composite['foreign']
                    ,'label' => $descColumn
                );
            }
        }
    }

    return $arrRelationships;
}
?>
