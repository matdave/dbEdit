<?php

if(!isset($tplName))
{
    $tplName='insidepage.template.php';
}

if(!isset($tplDir))
{
    $tplDir = 'gears/templates/';
}

include($modx->getOption('core_path').'/components/'.$tplDir.$tplName);

?>