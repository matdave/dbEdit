<?php
// Set the delimiter for the title
if (!isset($delimiter))
{
    $delimiter = ' - ';
}

// Print the site name by default
if (!isset($printSiteName))
{
    $printSiteName = 1;
}

//  Do not print the longtitle by default
if (!isset($printLongTitle))
{
    $printLongTitle = 0;
}

// Add something to the begining of the title
if(!isset($prepend))
{
    $prepend = '';
}

// Add something to the end of the title
if(!isset($append))
{
    $append = '';
}

if(!class_exists(GearsSEO))
{
    include($modx->getOption('core_path').'/components/gears/snippets/gearsseo/gearsseo.class.php');
}

$title = new GearsSEO($modx);
return $title->GetPageTitle($delimiter, $printSiteName, $printLongTitle, $prepend, $append);
unset($title);
?>
