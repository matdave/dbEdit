<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$template = $modx->newObject('modTemplate');
$template->fromArray(array(
    'templatename' => 'Home Page Template'
    ,'description' => 'Delivered template for the home page.'
    ,'content' => '[[GetTemplate? &tplName=`homepage.template.php`]]'
));

return $template;
?>
