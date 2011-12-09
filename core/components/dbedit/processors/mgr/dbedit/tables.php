<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$query = $modx->getOption('query', $scriptProperties, '');

// Get our custom prefix from the modx setting
$prefix = $modx->getOption('dbedit.prefix');

// Get all of our tables that have our custom prefix
$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll();

// Include the xpdo object.  We'll need this later
require_once 'xpdo.config.php';

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
        // Get the xPDO meta data for the table/class
        $arrFieldMeta = $xpdo->getFieldMeta($className);

        // Get the table's metadata from MySQL.  This is the only place we can get the comment field
        // to use as our friendly table name
        $statuses = $xpdo->query("SHOW TABLE STATUS LIKE '".$tableName."'");
        $statuses = $statuses->fetchAll(PDO::FETCH_ASSOC);

        // Get the full column information for the table.  This is where we get the comment field for the friendly column name,
        // and the extra field so we know if the field is autoincremented, and can be ignored.
        $columns = $xpdo->query("SHOW FULL COLUMNS FROM $tableName");
        $columns = $columns->fetchAll(PDO::FETCH_ASSOC);

        // For each column from the xPDO class ($arrFieldMeta)
        foreach($arrFieldMeta as $column_name => &$arrFields)
        {
            // For each column from MySQL ($columns)
            foreach($columns as $column)
            {
                // If the xPDO column and the MySQL column are the same
                if($column['Field'] == $column_name)
                {
                    // Get the actual column name, the column comment, and the extra field
                    $arrFields['columnName'] = $column_name;
                    $arrFields['label'] = $column['Comment'];
                    $arrFields['extra'] = $column['Extra'];
                }
            }
            // Add the MySQL metadata to the xPDO class metadata.  We're add this to $arrMetaNumIndexed, because
            // we want our array to be numerically indexed, not associative.
            $arrMetaNumIndexed[] = $arrFields;
        }

        // Build our table object and add it to our array of tables
        $arrTables[]= array(
            'tableName' => $statuses[0]['Name']
            ,'className' => $className
            ,'label' => $statuses[0]['Comment']
            ,'columns' => $arrMetaNumIndexed
            ,'relationships' => getRelationships($className, $xpdo)
        );

        // Unset $arrMetaNumIndexed, otherwise the columns accumulate from each table.
        unset($arrMetaNumIndexed);
    }


}

return $this->outputArray($arrTables);

// This function parses the table name to build the correct xPDO class name
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

// This function parses any composites or aggregates (relationships) defined for the xPDO class
function getRelationships($className, &$xpdo)
{
    $arrRelationships = array();

    // Get the aggregates for the class
    $arrAggregates = $xpdo->getAggregates($className);

    // If we find any aggregates
    if(count($arrAggregates) > 0)
    {
        foreach($arrAggregates as $aggregate)
        {
            // If the aggregate is a one-to-many relationship
            if($aggregate['cardinality'] == 'one')
            {
                // Get any field aliases for the class.  These are used to get the appropriate label field for
                // building relationships
                $arrAliases = $xpdo->getFieldAliases($aggregate['class']);

                // If we find the 'dbeditDescription' alias, use that for field for our UI label
                if($arrAliases['dbeditDescription'])
                {
                    $descColumn = $arrAliases['dbeditDescription'];
                }
                // Specify 'name' as the default label
                else
                {
                    $descColumn = 'name';
                }

                // Build our relationship object.
                $arrRelationships[$aggregate['local']] = array(
                    'class' => $aggregate['class']
                    ,'foreign' => $aggregate['foreign']
                    ,'label' => $descColumn
                );
            }
        }

    }

    // This code works exactly as above except for composites.  I should probably combine these in some way
    // because there is a lot of repeated code.
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

                $arrRelationships[$composite['local']] = array(
                    'class' => $composite['class']
                    ,'foreign' => $composite['foreign']
                    ,'label' => $descColumn
                );
            }
        }
    }

    return $arrRelationships;
}