<?php

if ($object->xpdo) 
{
    switch ($options[xPDOTransport::PACKAGE_ACTION]) 
    {
        case xPDOTransport::ACTION_INSTALL:
            $modx = & $object->xpdo;

            $modx->setLogLevel(modX::LOG_LEVEL_INFO);

            $resolverTag = '[Gears - Site Template Resolver] ';

            if (!$modx->hasPermission('directory_create')) 
            {
                $modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Does not have permissions to create directory.');
                return true;
            }

            $modx->getService('fileHandler', 'modFileHandler');

            $assets = $modx->getOption('assets_path');

            if ($assets) 
            {
                $dirs = array(
                    'img'
                    ,'css'
                    ,'js'
                );

                $files = array(
                    'css/all.css'
                    ,'js/main.js'
                    
                );

                $path = $assets . 'templates/site/';
                
                if (is_array($dirs)) 
                {

                    foreach ($dirs as $dir) 
                    {

                        $newDir = $modx->fileHandler->make($path.$dir, array(), 'modDirectory');

                        if (!$newDir->exists()) 
                        {
                            $result = $newDir->create();

                            if ($result !== true) 
                            {
                                $modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Could not create directory:  ' . $path.$dir);
                            }
                        } else {$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Directory:  ' . $dir . ' already exists.  Directory not created.');}
                    }
                } else {$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Invalid directories.');}
                
                if(is_array($files))
                {
                    foreach($files as $file)
                    {
                        $newFile = $modx->fileHandler->make($path.$file, array(), 'modFile');
                        
                        if (!$newFile->exists()) 
                        {
                            if (!$newFile->create()) 
                            {
                                $modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Could not create file:  ' . $path.$file);
                            }
                        } else {$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'File:  ' . $file . ' already exists.  File not created.');}
                    }
                }else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Invalid files.');}
                
            } else {$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag . 'Could not get Assets Path');}

            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;

        case xPDOTransport::ACTION_UPGRADE:
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
?>
