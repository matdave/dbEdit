function getTables()
{
    var recieved = function(response)
    {
        var jsonData = Ext.util.JSON.decode(response.responseText);
        buildPage(jsonData.results);
    }
    
    Ext.Ajax.request({
        url: Dbedit.config.connectorUrl
        ,params: {action: 'mgr/dbedit/tables'}
        ,success: recieved
    });
}

function buildPage(tableData)
{    
    var tabs = new MODx.Tabs({
        bodyStyle: 'padding: 10px'
        ,defaults: { border: false ,autoHeight: true }
    });
    
    for(var t = 0; t < tableData.length; t++)
    {
        var arrFields = new Array();
        var arrColumns = new Array();
        var arrFormFields = new Array();
        var arrTableName = tableData[t]['name'].split('_');
        var tableName = arrTableName[arrTableName.length-1]
        
        console.log(tableName);
        
        tab = tabs.add({title: tableName});
        
        for(var c = 0; c < tableData[t]['columns'].length; c++)
        {
            arrFields.push(tableData[t]['columns'][c]['Field']);
            
            var newFormField = new Ext.form.Field({
                xtype: 'textfield'
                ,fieldLabel: tableData[t]['columns'][c]['Field']
                ,name: tableData[t]['columns'][c]['Field']
                ,width: 300
            });
            arrFormFields.push(newFormField);

            var newCol = new Ext.grid.Column({
                header: tableData[t]['columns'][c]['Field']
                ,dataIndex: tableData[t]['columns'][c]['Field']
                ,sortable: true
                ,width: 60
            });
            arrColumns.push(newCol);
        }
        
        grid = new Dbedit.grid.Records({
            tableName: tableName
            ,formFields: arrFormFields
            ,fields: arrFields
            ,columns: arrColumns
        });
        
        tab.add(grid);
    }

    var panel = new MODx.Panel({
        id: 'dbedit-panel'
        ,border: false
        ,baseCls: 'modx-formpanel'
        ,renderTo: 'dbedit-panel-records-div'
        ,items: [
            {html: '<h2>Edit Records</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            }
            ,tabs
        ]
    });  
}

Dbedit.grid.Records = function(config) {
    config = config || {};
    config.className = Ext.util.Format.capitalize(config.tableName);
    Ext.applyIf(config,{
        id: 'dbedit-grid-' + config.tableName
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {action: 'mgr/dbedit/records', userTable: config.tableName, tableClass: config.className}
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'id'  
        ,tbar: 
            [{
                text: 'Add Record'
                ,handler: this.create
                ,blankValues: true
            }]
    });
    Dbedit.grid.Records.superclass.constructor.call(this,config)
};
Ext.extend(Dbedit.grid.Records,MODx.grid.Grid,{
    getMenu: function() {
        var m = [{
            text: 'Update ' + this.config.className
            ,handler: this.update
        },'-',{
            text: 'Remove ' + this.config.className
            ,handler: this.remove
        }];
        this.addContextMenuItem(m);
        return true;
    }
    ,create: function(btn, e)
    {
        this.createWindow = new Dbedit.window.Create({
            className: this.config.className
            ,tableName: this.config.tableName
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            ,fields: this.config.formFields
        });
        this.createWindow.show(e.target);
    }
    ,update: function(btn,e) {
        if (!this.updateWindow) {
            this.updateWindow = new Dbedit.window.Update({
                record: this.menu.record
                ,className: this.config.className
                ,tableName: this.config.tableName
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
                ,fields: this.config.formFields
            });
        } else {
            this.updateWindow.setValues(this.menu.record);
        }
        this.updateWindow.show(e.target);
    }
    ,remove: function() {
        MODx.msg.confirm({
            title: 'Remove ' + this.config.className
            ,text: 'Are you sure you want to remove this ' + this.config.className
            ,url: this.config.url
            ,params: {
                action: 'mgr/dbedit/remove'
                ,id: this.menu.record.id
                ,userTable: this.config.tableName
                ,tableClass: this.config.className
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    ,_loadColumnModel: function() {
        if (this.config.columns) {
            var c = this.config.columns;
            for (var i=0;i<c.length;i++) {
                // if specifying custom editor/renderer
                if(c[i].editor !== null)
                {
                    if (typeof(c[i].editor) == 'string') {
                        c[i].editor = eval(c[i].editor);
                    }
                    if (typeof(c[i].renderer) == 'string') {
                        c[i].renderer = eval(c[i].renderer);
                    }
                    if (typeof(c[i].editor) == 'object' && c[i].editor.xtype) {
                        var r = c[i].editor.renderer;
                        c[i].editor = Ext.ComponentMgr.create(c[i].editor);
                        if (r === true) {
                            c[i].renderer = MODx.combo.Renderer(c[i].editor);
                        } else if (c[i].editor.initialConfig.xtype === 'datefield') {
                            c[i].renderer = Ext.util.Format.dateRenderer(c[i].editor.initialConfig.format || 'Y-m-d');
                        } else if (r === 'boolean') {
                            c[i].renderer = this.rendYesNo;
                        } else if (r === 'password') {
                            c[i].renderer = this.rendPassword;
                        } else if (r === 'local' && typeof(c[i].renderer) == 'string') {
                            c[i].renderer = eval(c[i].renderer);
                        }
                    }
                }
            }
            this.cm = new Ext.grid.ColumnModel(c);
        }
    }
});

Dbedit.window.Create = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: 'Create new ' + config.className
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/dbedit/create'
            ,userTable: config.tableName
            ,tableClass: config.className
        }
    });
    Dbedit.window.Create.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Create,MODx.Window);



Dbedit.window.Update = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: 'Update ' + config.className
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/dbedit/update'
            ,userTable: config.tableName
            ,tableClass: config.className
        }
    });
    Dbedit.window.Update.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Update,MODx.Window);
