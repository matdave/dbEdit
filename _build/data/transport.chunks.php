<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$chunks = array();

$dir = dirname(__FILE__).'/chunks/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        {
            $chunks[] = include $dir.$file;
        }

    }
}

return $chunks;
?>