function buildPage()
{
    // Create our grid for the current table
    var grid = new Dbedit.grid.Relationships();

    //  Create a new MODx.Panel for the CMP.
    var panel = new MODx.Panel({
       id: 'dbedit-panel'
       ,border: false
       ,baseCls: 'modx-formpanel'
       ,renderTo: 'dbedit-panel-relationships-div'
       ,items: [
           {html: '<h2>Manage Relationships</h2>'
           ,border: false
           ,cls: 'modx-page-header'
           }
           //  This is our grid we generated above.
           ,grid
       ]
    });
}

Dbedit.grid.Relationships = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        // Set the control's id according to our table name
        id: 'dbedit-grid-relationships'
        ,url: Dbedit.config.connectorUrl
        // Set our default action.
        ,baseParams: {action: 'mgr/dbedit/relationships/get_relationships'}
        // These are necessary for xPDO data operations
        ,fields: ['id', 'local_class', 'foreign_class', 'type', 'local', 'foreign', 'label_field', 'alias', 'cardinality', 'owner']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'id'
        ,tbar: 
            [{
                // This is our button for creating new records
                text: 'New Relationship'
                ,handler: this.create
            }]
        ,columns:[{
            header: 'id'
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
            ,hidden: true
        },{
            header: 'Local Table'
            ,dataIndex: 'local_class'
            ,sortable: true
            ,width: 60
        },{
            header: 'Related Table'
            ,dataIndex: 'foreign_class'
            ,sortable: true
            ,width: 60
        },{
            header: 'Relationship Type'
            ,dataIndex: 'type'
            ,sortable: true
            ,width: 60
        },{
            header: 'Local Key'
            ,dataIndex: 'local'
            ,sortable: true
            ,width: 60
        },{
            header: 'Foreign Key'
            ,dataIndex: 'foreign'
            ,sortable: true
            ,width: 60
        },{
            header: 'Foreign Label'
            ,dataIndex: 'label_field'
            ,sortable: true
            ,width: 60
        },{
            header: 'Alias Name'
            ,dataIndex: 'alias'
            ,sortable: true
            ,width: 60
        },{
            header: 'Cardinality'
            ,dataIndex: 'cardinality'
            ,sortable: true
            ,width: 60
        },{
            header: 'Owner'
            ,dataIndex: 'owner'
            ,sortable: true
            ,width: 60
        }]
    });
    Dbedit.grid.Relationships.superclass.constructor.call(this,config)
};
Ext.extend(Dbedit.grid.Relationships,MODx.grid.Grid,{
    // This handler brings up our context menu with our Update and Delete options
    getMenu: function() {
        var m = [
            {
            text: 'Update Relationship'
            ,handler: this.update
        },'-',
            {
            text: 'Delete Relationship'
            ,handler: this.remove
        }];
        this.addContextMenuItem(m);
        return true;
    }
    // This handler creates a modal window for creating a new record
    ,create: function(btn, e)
    {
        this.createWindow = new Dbedit.window.Create({
            listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            ,blankValues: true
        });

        this.createWindow.show(e.target);
    }
    // This handler creates a modal window for updating a record
    ,update: function(btn,e) 
    {
        this.updateWindow = new Dbedit.window.Update({
            // Pass the current record.
            record: this.menu.record
            ,closeAction: 'close'
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });

        this.updateWindow.setValues(this.menu.record);
        this.updateWindow.show(e.target);
    }
    // This handler deletes the current record
    ,remove: function() {
        MODx.msg.confirm({
            title: 'Delete Relationship'
            ,text: 'Are you sure you want to delete this relationship?'
            ,url: this.config.url
            ,params: {
                action: 'mgr/dbedit/relationships/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});

// Definition for our basic DbEdit window
Dbedit.Window = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        buttons: [{
            text: 'Close'
            ,scope: this
            ,handler: function() { this.close(); }
        },{
            text: 'Save'
            ,scope: this
            ,handler: this.submit
        }]
    });
    Dbedit.Window.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.Window, MODx.Window, {
    submit: function(close) {
        close = close === false ? false : true;
        var f = this.fp.getForm();
        if (f.isValid() && this.fireEvent('beforeSubmit',f.getValues())) {
            f.submit({
                waitMsg: _('saving')
                ,scope: this
                ,failure: function(frm,a) {
                    if (this.fireEvent('failure',{f:frm,a:a})) {
                        MODx.form.Handler.errorExt(a.result,frm);
                    }
                }
                ,success: function(frm,a) {
                    if (this.config.success) {
                        Ext.callback(this.config.success,this.config.scope || this,[frm,a]);
                    }
                    this.fireEvent('success',{f:frm,a:a});
                    if (close) { this.close(); }
                }
            });
        }
    }
});
Ext.reg('dbedit-window', Dbedit.Window);

// Definition for our modal Create window
Dbedit.window.Create = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: 'New Relationship'
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/dbedit/relationships/create'
        }
        ,fields: [{
            xtype: 'textfield'
            ,hidden: true
            ,name: 'id'
            ,id: 'id'
            ,fields: ['id']
        },{
            xtype: 'modx-combo'
            // Set the label from the comment field for column
            ,fieldLabel: 'Local Table'
            // Set the name from the actual field name
            ,name: 'local_class'
            ,id: 'local_class'
            ,width: 300
            ,hiddenName: 'local_class'
            ,displayField: 'class'
            ,valueField: 'class'
            ,url: Dbedit.config.connectorUrl
            ,baseParams: {action: 'mgr/dbedit/relationships/tables'}
            ,fields: ['class']
            ,renderer: true
            ,triggerAction: 'all'
            ,listeners: {
                select: function(e){
                    var localClass = Ext.getCmp('local_class').getValue();

                    var localKey = Ext.getCmp('local');
                    localKey.clearValue();
                    localKey.store.removeAll();
                    localKey.store.reload(
                        {params:
                            {class: localClass}
                        }
                    )
                }
            }
        },{
            xtype: 'modx-combo'
            // Set the label from the comment field for column
            ,fieldLabel: 'Foreign Table'
            // Set the name from the actual field name
            ,name: 'foreign_class'
            ,id: 'foreign_class'
            ,width: 300
            ,hiddenName: 'foreign_class'
            ,displayField: 'class'
            ,valueField: 'class'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/tables'}
            ,fields: ['class']
            ,renderer: true
            ,listeners: {
                select: function(e){
                    var foreignClass = Ext.getCmp('foreign_class').getValue();

                    var foreignKey = Ext.getCmp('foreign');
                    foreignKey.clearValue();
                    foreignKey.store.removeAll();
                    foreignKey.store.reload(
                        {params:
                            {class: foreignClass}
                        }
                    )

                    var foreignLabel = Ext.getCmp('foreign_label');
                    foreignLabel.clearValue();
                    foreignLabel.store.removeAll();
                    foreignLabel.store.reload(
                        {params:
                            {class: foreignClass}
                        }
                    )
                }
            }
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Foreign Label'
            ,name: 'foreign_label'
            ,id: 'foreign_label'
            ,width: 300
            ,hiddenName: 'foreign_label'
            ,displayField: 'column'
            ,valueField: 'column'
            ,mode: 'local'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/columns'}
            ,fields: ['column']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Relationship Type'
            ,name: 'type'
            ,id: 'type'
            ,mode: 'local'
            ,store: ['composite', 'aggregate']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Local Key'
            ,name: 'local'
            ,id: 'local'
            ,width: 300
            ,hiddenName: 'local'
            ,displayField: 'column'
            ,valueField: 'column'
            ,mode: 'local'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/columns'}
            ,fields: ['column']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Foreign Key'
            ,name: 'foreign'
            ,id: 'foreign'
            ,width: 300
            ,hiddenName: 'foreign'
            ,displayField: 'column'
            ,valueField: 'column'
            ,mode: 'local'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/columns'}
            ,fields: ['column']
            ,renderer: true
        },{
            xtype: 'textfield'
            ,fieldLabel: 'Alias Name'
            ,name: 'alias'
            ,id: 'alias'
            ,width: 300
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Cardinality'
            ,name: 'cardinality'
            ,id: 'cardinality'
            ,mode: 'local'
            ,store: ['one', 'many']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Owner'
            ,name: 'owner'
            ,id: 'owner'
            ,mode: 'local'
            ,store: ['local', 'foreign']
            ,renderer: true
        }

        ]
    });
    Dbedit.window.Create.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Create, Dbedit.Window);
Ext.reg('dbedit-window-create', Dbedit.window.Create);

// Definition for our modal Create window
Dbedit.window.Update = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: 'Update Relationship'
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/dbedit/relationships/update'
        }
        ,fields: [{
            xtype: 'textfield'
            ,hidden: true
            ,name: 'id'
            ,id: 'id'
            ,fields: ['id']
        },{
            xtype: 'modx-combo'
            // Set the label from the comment field for column
            ,fieldLabel: 'Local Table'
            // Set the name from the actual field name
            ,name: 'local_class'
            ,id: 'local_class'
            ,width: 300
            ,hiddenName: 'local_class'
            ,displayField: 'class'
            ,valueField: 'class'
            ,url: Dbedit.config.connectorUrl
            ,baseParams: {action: 'mgr/dbedit/relationships/tables'}
            ,fields: ['class']
            ,renderer: true
            ,triggerAction: 'all'
            ,listeners: {
                select: function(e){
                    var localClass = Ext.getCmp('local_class').getValue();

                    var localKey = Ext.getCmp('local');
                    localKey.clearValue();
                    localKey.store.removeAll();
                    localKey.store.reload(
                        {params:
                            {class: localClass}
                        }
                    )
                }
                ,render: function(e){
                    var localClass = Ext.getCmp('local_class').getValue();

                    var localKey = Ext.getCmp('local');
                    //localKey.clearValue();
                    localKey.store.removeAll();
                    localKey.store.reload(
                        {params:
                            {class: localClass}
                        }
                    )

                }
            }
        },{
            xtype: 'modx-combo'
            // Set the label from the comment field for column
            ,fieldLabel: 'Foreign Table'
            // Set the name from the actual field name
            ,name: 'foreign_class'
            ,id: 'foreign_class'
            ,width: 300
            ,hiddenName: 'foreign_class'
            ,displayField: 'class'
            ,valueField: 'class'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/tables'}
            ,fields: ['class']
            ,renderer: true
            ,listeners: {
                select: function(e)
                {
                    var foreignClass = Ext.getCmp('foreign_class').getValue();

                    var foreignKey = Ext.getCmp('foreign');
                    foreignKey.clearValue();
                    foreignKey.store.removeAll();
                    foreignKey.store.reload(
                        {params:
                            {class: foreignClass}
                        }
                    )

                    var foreignLabel = Ext.getCmp('label_field');
                    foreignLabel.clearValue();
                    foreignLabel.store.removeAll();
                    foreignLabel.store.reload(
                        {params:
                            {class: foreignClass}
                        }
                    )
                }
                ,render: function(e)
                {
                    var foreignClass = Ext.getCmp('foreign_class').getValue();

                    var foreignKey = Ext.getCmp('foreign');
                    //foreignKey.clearValue();
                    foreignKey.store.removeAll();
                    foreignKey.store.reload(
                        {params:
                            {class: foreignClass}
                        }
                    )

                    var foreignLabel = Ext.getCmp('label_field');
                    //foreignLabel.clearValue();
                    foreignLabel.store.removeAll();
                    foreignLabel.store.reload(
                        {params:
                            {class: foreignClass}
                        }
                    )
                }

            }
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Foreign Label'
            ,name: 'label_field'
            ,id: 'label_field'
            ,width: 300
            ,hiddenName: 'label_field'
            ,displayField: 'column'
            ,valueField: 'column'
            ,mode: 'local'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/columns'}
            ,fields: ['column']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Relationship Type'
            ,name: 'type'
            ,id: 'type'
            ,mode: 'local'
            ,store: ['composite', 'aggregate']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Local Key'
            ,name: 'local'
            ,id: 'local'
            ,width: 300
            ,hiddenName: 'local'
            ,displayField: 'column'
            ,valueField: 'column'
            ,mode: 'local'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/columns'}
            ,fields: ['column']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Foreign Key'
            ,name: 'foreign'
            ,id: 'foreign'
            ,width: 300
            ,hiddenName: 'foreign'
            ,displayField: 'column'
            ,valueField: 'column'
            ,mode: 'local'
            ,url: Dbedit.config.connectorUrl
            ,baseParams:{action: 'mgr/dbedit/relationships/columns'}
            ,fields: ['column']
            ,renderer: true
        },{
            xtype: 'textfield'
            ,fieldLabel: 'Alias Name'
            ,name: 'alias'
            ,id: 'alias'
            ,width: 300
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Cardinality'
            ,name: 'cardinality'
            ,id: 'cardinality'
            ,mode: 'local'
            ,store: ['one', 'many']
            ,renderer: true
        },{
            xtype: 'modx-combo'
            ,fieldLabel: 'Owner'
            ,name: 'owner'
            ,id: 'owner'
            ,mode: 'local'
            ,store: ['local', 'foreign']
            ,renderer: true
        }

        ]
    });
    Dbedit.window.Create.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Update, Dbedit.Window);
Ext.reg('dbedit-window-update', Dbedit.window.Update);