Dbedit.grid.Dbedit = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'dbedit-grid-dbedit'
        ,url: '/trans_pkgs/dbedit/assets/components/dbedit/connector.php'
        ,baseParams: {action: 'mgr/dbedit/tables'}
        ,fields: ['name', 'status']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        //,save_action: 'mgr/doodle/updateFromGrid'
        //,autosave: true
        ,columns: 
        [
            {header: 'Name'
            ,dataIndex: 'name'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'Has Schema?'
            ,dataIndex: 'status'
            ,sortable: true
            ,width: 60
            }
        ]            
    });
    Dbedit.grid.Dbedit.superclass.constructor.call(this,config)
};

Ext.extend(Dbedit.grid.Dbedit,MODx.grid.Grid);
Ext.reg('dbedit-grid-dbedit',Dbedit.grid.Dbedit);
