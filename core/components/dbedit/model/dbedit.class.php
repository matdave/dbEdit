<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tony
 * Date: 3/16/12
 * Time: 8:42 AM
 * To change this template use File | Settings | File Templates.
 */
class Dbedit
{
    public $modx;
    public $config = array();

    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('core_path');

        $basePath = $this->modx->getOption('dbedit.core_path',$config,$this->modx->getOption('core_path'));
        $basePath .= 'components/dbedit/';

        $assetsUrl = $this->modx->getOption('dbedit.assets_url',$config,$this->modx->getOption('assets_url'));
        $assetsUrl .= 'components/dbedit/';

        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'templatesPath' => $basePath.'templates/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php',
        ),$config);
        $this->modx->addPackage('dbedit',$this->config['modelPath'],$this->modx->getOption('dbedit.prefix'));
    }
}
