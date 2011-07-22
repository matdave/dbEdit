<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$snippets = array();

$dir = dirname(__FILE__).'/snippets/';

if($handle = opendir($dir))
{
    while(($file = readdir($handle)) !== false)
    {
        if(is_file($dir.$file))
        {
            $snippets[] = include $dir.$file;
        }

    }
}

return $snippets;
?>