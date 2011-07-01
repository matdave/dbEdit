<?php
include('C:/Users/tony/documents/websites/gears.idb.dev/core/config/config.inc.php');
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');

$prefix = $modx->getOption('dbedit.prefix');

$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll(PDO::FETCH_COLUMN);
?>

    Dbedit.panel.Records = function(config) {
        config = config || {};
        this.ident = Ext.id();

        Ext.apply(config,{
            border: false
            ,baseCls: 'modx-formpanel'
            ,items: 
            [
                {
                    html: '<h2>Edit Records</h2>'
                    ,border: false
                    ,cls: 'modx-page-header'
                }
                ,{
                    xtype: 'modx-tabs'
                    ,bodyStyle: 'padding: 10px'
                    ,defaults: { border: false ,autoHeight: false }
                    //,border: true
                    ,items: 
                    [
                    <?php
                    foreach ($tables as $table) 
                    {
                        
                        $arrTableName = explode('_', $table);
                        unset($arrTableName[0]);
                        $tableName = implode('', $arrTableName);

                        $className = ucfirst($tableName);
                    ?>
                        {title: '<?php echo $className ?>'
                        ,defaults: { autoHeight: false }
                        ,minHeight: 500
                        ,height: 500
                        //,layout: 'border'
                        ,items: 
                        [
                            {
                               xtype: 'dbedit-grid-<?php echo $tableName ?>'
                               ,preventRender: true
                               ,height: 500
                            }
                        ]},
                    <?php
                    }
                    ?>
                    ]
                }

            ]
            
        });
        Dbedit.panel.Records.superclass.constructor.call(this,config);
    };
    Ext.extend(Dbedit.panel.Records,MODx.Panel);
    Ext.reg('dbedit-panel-records',Dbedit.panel.Records);


    




