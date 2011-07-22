<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$pages = array();

$dir = dirname(__FILE__).'/pages/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        { 
            $pages[] = include $dir.$file;
        }

    }
}

return $pages;
?>
