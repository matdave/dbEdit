<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$menus = array();

$dir = dirname(__FILE__).'/menus/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        { 
            $menus[] = include $dir.$file;
        }

    }
}

return $menus;
?>