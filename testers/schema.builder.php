<?php

$debug = true;     // if true, will include verbose debugging info, including SQL errors.
$verbose = true;    // if true, will print status info.
 
// The XML schema file *must* be updated each time the database is modified, either
// manually or via this script. By default, the schema is regenerated.
// If you have spent time adding in composite/aggregate relationships to your
// XML schema file (i.e. foreign key relationships), then you may want to set this
// to 'false' in order to preserve your custom modifications.
$regenerate_schema = true;
 
// Class files are not overwritten by default
$regenerate_classes = true;

// Database Login Info can be set explicitly:
$database_server    = '';      // most frequently, your database resides locally
$dbase          = '';       // name of your database
$database_user      = '';       // name of the user
$database_password  = '';   // password for that database user
// If your tables use a prefix, this will help identify them and it ensures that
// the class names appear "clean", without the prefix.

// If you specify a table prefix, you probably want this set to 'true'. E.g. if you
// have custom tables alongside the modx_xxx tables, restricting the prefix ensures
// that you only generate classes/maps for the tables identified by the $table_prefix.
$restrict_prefix = true;

include 'config.core.php';

$corePath = MODX_CORE_PATH;


include $corePath . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');

include $corePath . 'config/config.inc.php';

$package_name = 'dbedit';
$table_prefix = 'user_';

 
//------------------------------------------------------------------------------
//  DO NOT TOUCH BELOW THIS LINE
//------------------------------------------------------------------------------

include_once ($corePath . 'xpdo/xpdo.class.php');
 
// A few definitions of files/folders:
echo $package_dir = $corePath.'components/'.$package_name.'/';
echo "\n". $model_dir = $corePath.'components/'.$package_name.'/model/';
echo "\n". $class_dir = $corePath.'components/'.$package_name.'/model/'.$package_name.'';
echo "\n". $schema_dir = $corePath.'components/'.$package_name.'/model/schema';
echo "\n". $mysql_class_dir = $corePath.'components/'.$package_name.'/model/'.$package_name.'/mysql';
echo "\n". $xml_schema_file = $corePath.'components/'.$package_name.'/model/schema/'.$package_name.'.mysql.schema.xml';
 
// A few variables used to track execution times.
$mtime= microtime();
$mtime= explode(' ', $mtime);
$mtime= $mtime[1] + $mtime[0];
$tstart= $mtime;
 
// Validations
if ( empty($package_name) )
{
    print_msg('<h1>Reverse Engineering Error</h1>
        <p>The $package_name cannot be empty!  Please adjust the configuration and try again.</p>');
    exit;
}

// Create directories if necessary
$dirs = array($package_dir, $schema_dir ,$mysql_class_dir, $class_dir);

foreach ($dirs as $d)
{
    if ( !file_exists($d) )
    {
        if ( !mkdir($d, 0777, true) )
        {
            print_msg( sprintf('<h1>Reverse Engineering Error</h1>
                <p>Error creating <code>%s</code></p>
                <p>Create the directory (and its parents) and try again.</p>'
                , $d
            ));
            exit;
        }
    }
    if ( !is_writable($d) )
    {
        print_msg( sprintf('<h1>Reverse Engineering Error</h1>
            <p>The <code>%s</code> directory is not writable by PHP.</p>
            <p>Adjust the permissions and try again.</p>'
        , $d));
        exit;
    }
}

if ( $verbose )
{
    print_msg( sprintf('<br/><strong>Ok:</strong> The necessary directories exist and have the correct permissions inside of <br/>
        <code>%s</code>', $package_dir));
}

// Delete/regenerate map files?
if ( file_exists($xml_schema_file) && !$regenerate_schema && $verbose)
{
    print_msg( sprintf('<br/><strong>Ok:</strong> Using existing XML schema file:<br/><code>%s</code>',$xml_schema_file));
}

$xpdo = new xPDO("mysql:host=$database_server;dbname=$dbase", $database_user, $database_password, $table_prefix);

// Set the package name and root path of that package
$xpdo->setDebug($debug);

$manager = $xpdo->getManager();
$generator = $manager->getGenerator();

//Use this to create an XML schema from an existing database
if ($regenerate_schema)
{
    $xml = $generator->writeSchema($xml_schema_file, $package_name, 'xPDOObject', $table_prefix, $restrict_prefix);
    if ($verbose)
    {
        print_msg( sprintf('<br/><strong>Ok:</strong> XML schema file generated: <code>%s</code>',$xml_schema_file));
    }
}
$xml = file_get_contents($xml_schema_file);
$orig_doc = new DOMDocument();
$orig_doc->formatOutput = true;
$orig_doc->loadXML($xml);

$xpdo->addPackage($package_name, $model_dir);
addRelationships($orig_doc->documentElement, $xpdo);
$orig_doc->save($xml_schema_file);

// Use this to generate classes and maps from your schema
if ($regenerate_classes)
{
    //print_msg('<br/>Attempting to remove/regenerate class files...');
    delete_class_files( $class_dir );
    delete_class_files( $mysql_class_dir );
}

// This is harmless in and of itself: files won't be overwritten if they exist.
$generator->parseSchema($xml_schema_file, $model_dir);


$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

echo "Custom Table schema has been generated.\n";

if ($verbose)
{
    print_msg("<br/><br/><strong>Finished!</strong> Execution time: {$totalTime}<br/>");

    if ($regenerate_schema)
    {
        print_msg("<br/>If you need to define aggregate/composite relationships in your XML schema file, be sure to regenerate your class files.");
    }

}

exit ();


/*------------------------------------------------------------------------------
INPUT: $dir: a directory containing class files you wish to delete.
------------------------------------------------------------------------------*/
function delete_class_files($dir)
{
    global $verbose;

    $all_files = scandir($dir);
    foreach ( $all_files as $f )
    {
        if ( preg_match('#\.class\.php$#i', $f) || preg_match('#\.map\.inc\.php$#i', $f))
        {
            if ( unlink("$dir/$f") )
            {
                if ($verbose)
                {
                    print_msg( sprintf('<br/>Deleted file: <code>%s/%s</code>',$dir,$f) );
                }
            }
            else
            {
                print_msg( sprintf('<br/>Failed to delete file: <code>%s/%s</code>',$dir,$f) );
            }
        }
    }
}
/*------------------------------------------------------------------------------
Formats/prints messages.  The behavior is different if the script is run
via the command line (cli).
------------------------------------------------------------------------------*/
function print_msg($msg)
{
    if ( php_sapi_name() == 'cli' )
    {
        $msg = preg_replace('#<br\s*/>#i', "\n", $msg);
        $msg = preg_replace('#<h1>#i', '== ', $msg);
        $msg = preg_replace('#</h1>#i', ' ==', $msg);
        $msg = preg_replace('#<h2>#i', '=== ', $msg);
        $msg = preg_replace('#</h2>#i', ' ===', $msg);
        $msg = strip_tags($msg) . "\n";
    }
    print $msg;
}

function addRelationships(&$node, $xpdo)
{

    echo "Adding relationships.\n";
    $objects = $node->getElementsByTagName('object');

    foreach($objects as $object)
    {
        if ($object->attributes->length > 0)
        {
            $className =  trim($object->getAttribute('class'));

            echo "Class name:  ".$className."\n";

            $relationships = $xpdo->getCollection('Relationships', array('local_class' => $className));

            foreach($relationships as $relationship)
            {
                $rel_elem = new DOMElement($relationship->get('type'));
                $object->appendChild($rel_elem);

                $rel_elem->setAttribute('alias', $relationship->get('alias'));
                $rel_elem->setAttribute('class', $relationship->get('foreign_class'));
                $rel_elem->setAttribute('local', $relationship->get('local'));
                $rel_elem->setAttribute('foreign', $relationship->get('foreign'));
                $rel_elem->setAttribute('cardinality', $relationship->get('cardinality'));
                $rel_elem->setAttribute('owner', $relationship->get('owner'));
            }
        }

    }
}