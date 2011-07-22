<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$template = $modx->newObject('modTemplate');
$template->fromArray(array(
    'templatename' => 'Inside Page Template'
    ,'description' => 'Delivered template for inside pages.'
    ,'content' => '[[GetTemplate? &tplName=`insidepage.template.php`]]'
));

return $template;
?>
