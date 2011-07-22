<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$templates = array();

$dir = dirname(__FILE__).'/templates/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        { 
            $templates[] = include $dir.$file;
        }

    }
}

return $templates;
?>
