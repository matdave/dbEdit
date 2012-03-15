<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$settings = array();

$dir = dirname(__FILE__).'/settings/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        { 
            $settings[] = include $dir.$file;
        }

    }
}

return $settings;
?>