Ext.onReady(function(){
    MODx.load({xtype: 'dbedit-panel-schema'});
});

Dbedit.panel.Schema = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,renderTo: 'dbedit-panel-schema-div'
        ,items:
            [
                {
                    html: '<h2>'+_('dbedit.schema_manage')+'</h2>'
                    ,border: false
                    ,cls: 'modx-page-header'
                }
                ,{xtype: 'dbedit-grid-schema'}
            ]
    });
    Dbedit.panel.Schema.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.panel.Schema,MODx.Panel);
Ext.reg('dbedit-panel-schema',Dbedit.panel.Schema);

Dbedit.grid.Schema = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'dbedit-grid-schema'
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {action: 'mgr/dbedit/schema/get_schema'}
        ,fields: ['table_name', 'has_schema']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'table_name'
        ,columns:
            [
                {header: 'Name'
                    ,dataIndex: 'table_name'
                    ,sortable: true
                    ,width: 60
                }
                ,{header: 'Has Schema?'
                    ,dataIndex: 'has_schema'
                    ,sortable: true
                    ,width: 60
                }
            ]
        ,tbar:[
            {
                text: _('dbedit.schema_generate')
                ,handler: this.generateSchema
            }
        ]
    });
    Dbedit.grid.Schema.superclass.constructor.call(this,config)
};

Ext.extend(Dbedit.grid.Schema,MODx.grid.Grid,{
    generateSchema: function(btn)
    {
        var grid = this;
        MODx.Ajax.request({
            url: Dbedit.config.connectorUrl
            ,params: {
                action: 'mgr/dbedit/schema/generate_schema'
                ,corePath: Dbedit.config.corePath
                ,packageName: 'dbedit'
            }
            ,listeners:{
                'success':{fn:function(){
                    grid.refresh();
                    MODx.msg.alert(_('dbedit.schema_refresh_title'),_('dbedit.schema_refresh_message'));
                }}
            }
        });
    }
});
Ext.reg('dbedit-grid-schema',Dbedit.grid.Schema);


