<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tony
 * Date: 3/16/12
 * Time: 8:50 AM
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/model/dbedit.class.php';

class IndexManagerController extends modExtraManagerController
{
    public static function getDefaultController()
    {
        return 'records';
    }
}

abstract class DbeditManagerController extends modManagerController
{
    public $dbedit;

    public function initialize()
    {
        $this->modx->lexicon->load('dbedit:default');
        $this->dbedit = new Dbedit($this->modx);

        $this->addJavascript($this->dbedit->config['jsUrl'].'mgr/dbedit.js');

        $this->addHtml('<script type="text/javascript">
            Ext.onReady(function(){
                Dbedit.config = '.$this->modx->toJSON($this->dbedit->config).';
            });
        </script>');


        return parent::initialize();
    }

    public function getLanguageTopics()
    {
        return array('dbedit:default');
    }

    public function checkPermissions(){return true;}
}
