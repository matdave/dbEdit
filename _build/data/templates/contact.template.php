<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$template = $modx->newObject('modTemplate');
$template->fromArray(array(
    'templatename' => 'Contact Page Template'
    ,'description' => 'Delivered template for contact us page.'
    ,'content' => '[[GetTemplate? &tplName=`contact.template.php`]]'
));

return $template;
?>
