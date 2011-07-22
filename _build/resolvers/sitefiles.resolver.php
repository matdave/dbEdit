<?php
if ($object->xpdo)
{
	switch ($options[xPDOTransport::PACKAGE_ACTION])
	{
	case xPDOTransport::ACTION_INSTALL:
		$modx =& $object->xpdo;
		
		$modx->setLogLevel(modX::LOG_LEVEL_INFO);

		$resolverTag = '[Gears - Site Files Resolver] ';
	    
		if (!$modx->hasPermission('directory_create')) 
		{
			$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Does not have permissions to create directory.');
			return true;
		}
		
		$modx->getService('fileHandler', 'modFileHandler');           
		
		$assets = $modx->getOption('assets_path');

		if($assets)            
		{  
			
			$dirs = array(
				'images'
				,'movies'
				,'documents'
			);            
			
			if(is_array($dirs))
			{

				foreach($dirs as $dir)
				{
					
					$path = $assets.'site/'.$dir;
					echo $path.'<br />';
					$newDir = $modx->fileHandler->make($path,array(),'modDirectory');	
							
					if(!$newDir->exists())
					{
						$result = $newDir->create();
				
						if($result !== true)
						{
							$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not create directory:  '.$path);
						}
					}
					else {$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Directory:  '.$dir.' already exists.  Directory not created.');}
					
				} 

			}else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Invalid directories.');}   
		}    
		else{$modx->log(xPDO::LOG_LEVEL_ERROR, $resolverTag.'Could not get Assets Path');}       
		
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
