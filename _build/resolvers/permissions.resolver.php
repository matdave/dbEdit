<?php

if ($object->xpdo)
{
    switch ($options[xPDOTransport::PACKAGE_ACTION])
    {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:

            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $resolverTag = '[Gears - Permissions Resolver] ';
            
            $permissions = array();
            $permissions[] = $modx->getObject('modAccessPermission',array('name' => 'gears.view_support'));
            $permissions[] = $modx->getObject('modAccessPermission',array('name' => 'gears.view_siteschedule'));
            $permissions[] = $modx->getObject('modAccessPermission',array('name' => 'gears.view_logout'));

            /* administrator template/policy */
            $template = $modx->getObject('modAccessPolicyTemplate', array('name' => 'AdministratorTemplate'));

            if($template)
            {
                if(is_array($permissions))
                {
                    $template->addMany($permissions);
                    $template->save();
                    unset($permissions);
    
                    $policy = $modx->getObject('modAccessPolicy', array('name' => 'Administrator'));
                    
                    if($policy)
                    {
                        $permissions = $policy->get('data');
                        if(is_array($permissions))
                        {
                            $permissions['gears.view_support'] = true;
                            $permissions['gears.view_siteschedule'] = true;
                            $permissions['gears.view_logout'] = true;
                            $policy->set('data', $permissions);
                            $policy->save();
                        }
                        else{$modx->log(modX::LOG_LEVEL_ERROR,$resolverTag.'Could not get permissions for Administrator Access Policy!');}
                        
                    }
                    else{$modx->log(modX::LOG_LEVEL_ERROR,$resolverTag.'Could not load Administrator Access Policy!');}
                    
                } 
                else{$modx->log(modX::LOG_LEVEL_ERROR,$resolverTag.'Could not load custom permissions!');}
                
            }
            else{$modx->log(modX::LOG_LEVEL_ERROR,$resolverTag.'Could not load Administrator Policy Template!');}
            
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
        
        case xPDOTransport::ACTION_UNINSTALL:

            $modx =& $object->xpdo;
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);

            $policy = $modx->getObject('modAccessPolicy', array('name' => 'Administrator'));
            $permissions = $policy->get('data');
            unset($permissions['gears.view_support']);
            unset($permissions['gears.view_siteschedule']);
            unset($permissions['gears.view_logout']);
            $policy->set('data', $permissions);
            $policy->save();

            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
    }
}
return true;

?>
