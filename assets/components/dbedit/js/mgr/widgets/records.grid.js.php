<?php
include('C:/Users/tony/documents/websites/gears.idb.dev/core/config/config.inc.php');
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');

$prefix = $modx->getOption('dbedit.prefix');

$results = $modx->query("SHOW TABLES LIKE '".$prefix."%'");
$tables = $results->fetchAll(PDO::FETCH_COLUMN);

foreach($tables as $table)
{
    
    $arrTableName = explode('_', $table);
    unset($arrTableName[0]);
    $tableName = implode('', $arrTableName);
    
    $className = ucfirst($tableName);
    
    $colResults = $modx->query("SHOW COLUMNS FROM " . $table);
    $arrColumns = $colResults->fetchAll();
    
    //print_r($arrColumns);
?>

Dbedit.grid.<?php echo $className; ?> = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'dbedit-grid-<?php echo $tableName; ?>'
        ,url: '/trans_pkgs/dbedit/assets/components/dbedit/connector.php'
        ,baseParams: {action: 'mgr/dbedit/records',userTable: '<?php echo $tableName; ?>',tableClass: '<?php echo $className; ?>'}
        ,fields: [
        <?php
            foreach($arrColumns as $column)
            {
                echo "'".$column['Field'].'\','; 
            }
        ?>
        ]
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'id'
        
        //,save_action: 'mgr/doodle/updateFromGrid'
        //,autosave: true
        ,columns: 
        [
            <?php
            foreach($arrColumns as $column)
            {               
                $o = '{';
                $o .= 'header:\''.$column['Field'].'\'';
                $o .= ',dataIndex: \''.$column['Field'].'\'';
                $o .= ',sortable: true';
                $o .= ',width: 60';
                $o .= '},';
                
                echo $o;
            }
            ?>
        ]   
        ,tbar: 
            [{
            text: 'Add Record'
            ,handler: { xtype: 'dbedit-window-<?php echo $tableName; ?>-create' ,blankValues: true }
        }]
    });
    Dbedit.grid.<?php echo $className; ?>.superclass.constructor.call(this,config)
};

Ext.extend(Dbedit.grid.<?php echo $className; ?>,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
            text: 'Update <?php echo $className; ?>'
            ,handler: this.update<?php echo $className; ?>
        },'-',{
            text: 'Remove <?php echo $className; ?>'
            ,handler: this.remove<?php echo $className; ?>
        }];
        this.addContextMenuItem(m);
        return true;
    }
     ,update<?php echo $className; ?>: function(btn,e) {
        if (!this.update<?php echo $className; ?>Window) {
            this.update<?php echo $className; ?>Window = MODx.load({
                xtype: 'Dbedit-window-<?php echo $tableName; ?>-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        } else {
            this.update<?php echo $className; ?>Window.setValues(this.menu.record);
        }
        this.update<?php echo $className; ?>Window.show(e.target);
    }

    ,remove<?php echo $className; ?>: function() {
        MODx.msg.confirm({
            title: 'Remove <?php echo $className; ?>?'
            ,text: 'Are you sure you want to remove this <?php echo $className; ?>?'
            ,url: this.config.url
            ,params: {
                action: 'mgr/dbedit/remove'
                ,id: this.menu.record.id
                ,userTable: '<?php echo $tableName; ?>'
                ,tableClass: '<?php echo $className; ?>'
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }

});
Ext.reg('dbedit-grid-<?php echo $tableName; ?>',Dbedit.grid.<?php echo $className; ?>);

Dbedit.window.Create<?php echo $className; ?> = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: 'Create new <?php echo $className; ?>'
        ,url: '/trans_pkgs/dbedit/assets/components/dbedit/connector.php'
        ,baseParams: {
            action: 'mgr/dbedit/create'
            ,userTable: '<?php echo $tableName; ?>'
            ,tableClass: '<?php echo $className; ?>'
        }
        ,fields: 
        [
        <?php
            foreach($arrColumns as $column)
            {               
                $o = '{';
                $o .= 'xtype:\'textfield\'';
                $o .= ',fieldLabel: \''.$column['Field'].'\'';
                $o .= ',name: \''.$column['Field'].'\'';
                $o .= ',width: 300';
                $o .= '},';
                
                echo $o;
            }
        ?>     
        
        ]
    });
    Dbedit.window.Create<?php echo $className; ?>.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Create<?php echo $className; ?>,MODx.Window);
Ext.reg('dbedit-window-<?php echo $tableName; ?>-create',Dbedit.window.Create<?php echo $className; ?>);


Dbedit.window.Update<?php echo $className; ?> = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: 'Update <?php echo $className; ?>'
        ,url: '/trans_pkgs/dbedit/assets/components/dbedit/connector.php'
        ,baseParams: {
            action: 'mgr/dbedit/update'
            ,userTable: '<?php echo $tableName; ?>'
            ,tableClass: '<?php echo $className; ?>'
        }
        ,fields: 
        [
        <?php
            foreach($arrColumns as $column)
            {               
                $o = '{';
                $o .= 'xtype:\'textfield\'';
                $o .= ',fieldLabel: \''.$column['Field'].'\'';
                $o .= ',name: \''.$column['Field'].'\'';
                $o .= ',width: 300';
                $o .= '},';
                
                echo $o;
            }
        ?>
        ]
    });
    Dbedit.window.Update<?php echo $className; ?>.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Update<?php echo $className; ?>,MODx.Window);
Ext.reg('Dbedit-window-<?php echo $tableName; ?>-update',Dbedit.window.Update<?php echo $className; ?>);
<?php

unset($tableName, $arrColumns, $className, $colResults);
}
?>
