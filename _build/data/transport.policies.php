<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$permissions = include dirname(__FILE__).'/permissions/manager.policy.php';


$policies = array();
$policies[1]= $modx->newObject('modAccessPolicy');
$policies[1]->set('id', 1);
$policies[1]->set('name', 'GearsManagerPolicy');
$policies[1]->set('description', 'Policy for default Gears Manager group.');
$policies[1]->set('parent', 0);
$policies[1]->set('template', 1);
$policies[1]->set('data', $permissions);

return $policies;
?>
