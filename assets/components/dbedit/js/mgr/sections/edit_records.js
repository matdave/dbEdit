function getTables()
{
    //Success callback for the Ajax Request.  This passes the table metadata to
    //the main buildPage function
    var recieved = function(response)
    {
        var jsonData = Ext.util.JSON.decode(response.responseText);
        buildPage(jsonData.results);
    }
    
    //Request all of table metadata from the tables processor
    Ext.Ajax.request({
        url: Dbedit.config.connectorUrl
        ,params: {action: 'mgr/dbedit/tables'}
        ,success: recieved
    });
}

function buildPage(tableData)
{    
    //our tab group
    var tabs = new MODx.Tabs({
        bodyStyle: 'padding: 10px'
        ,defaults: { border: false ,autoHeight: true }
    });

    // For each custom table...
    for(var t = 0; t < tableData.length; t++)
    {
        var arrFields = new Array();
        var arrColumns = new Array();
        var arrFormFields = new Array();
        var arrCreateFields = new Array();
        
        // Get the name of the table, i.e. user_table, and strip of the prefix.
        var arrTableName = tableData[t]['info']['Name'].split('_');
        var tableName = arrTableName[arrTableName.length-1];
        var tableTitle = tableData[t]['info']['Comment'];
        
        // Create a new tab for our table
        var tab = tabs.add({title: tableTitle});
        
        // For each column in this table
        for(var c = 0; c < tableData[t]['columns'].length; c++)
        {
            // Add the column name to our array of field names
            arrFields.push(tableData[t]['columns'][c]['Field']);
            
            // By default, all columns are visible
            var hidden = false;
            
            // If the column is an auto_increment (just a integer id), hide it.
            if(tableData[t]['columns'][c]['Extra'] == 'auto_increment')
            {
                hidden = true;
            }
            
            // Build our collection of form fields by passing in:
            // our column object
            // our array of form fields (for our create and update modal dialogs)
            // whether or not the field is hidden
            buildFormFields(tableData[t]['columns'][c], arrFormFields, hidden);
            buildFormFields(tableData[t]['columns'][c], arrCreateFields, hidden)

            // Same as above.  Here we're building our collection of grid control columns
            buildGridColumns(tableData[t]['columns'][c], arrColumns, hidden);
        }

       
        // Create our grid for the current table
        grid = new Dbedit.grid.Records({
            // Pass in the actual table name.  This will be passed to processors
            // for accessing the table via xPDO.
            tableName: tableName
            // Pass the table's title to the config.  We will use this for
            // Modal window titles
            ,tableTitle: tableTitle
            // Pass in our array of form fields.  This will be used to generate
            // our modal Create and Update windows
            ,formFields: arrFormFields
            // We need to pass a separate array of form fields to the create form.
            // Otherwise, we won't get a blank form after an update
            ,createFields: arrCreateFields
            // Pass our array of data fields.  The grid will use these for data access
            ,fields: arrFields
            // Pass our array of columns.  This defines the columns in each grid.
            ,columns: arrColumns
        });
        
        // Add our new grid to the current tab
        tab.add(grid);
    }

    //  Create a new MODx.Panel for the CMP.
    var panel = new MODx.Panel({
        id: 'dbedit-panel'
        ,border: false
        ,baseCls: 'modx-formpanel'
        ,renderTo: 'dbedit-panel-records-div'
        ,items: [
            {html: '<h2>'+_('dbedit.edit_records')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            }
            //  This is our collection of tabs we generated above.
            ,tabs
        ]
    });  
}


Dbedit.grid.Records = function(config) {
    config = config || {};
    // Create a config variable - className.  This will be passed to the processors
    // for xPDO access.
    config.className = Ext.util.Format.capitalize(config.tableName);
    Ext.applyIf(config,{
        // Set the control's id according to our table name
        id: 'dbedit-grid-' + config.tableName
        ,url: Dbedit.config.connectorUrl
        // Set our default action.  Also, we pass the tableName and className 
        // to the processor for xPDO access
        ,baseParams: {action: 'mgr/dbedit/records', userTable: config.tableName, tableClass: config.className}
        // This is the processor for inline grid editing
        ,save_action: 'mgr/dbedit/updateFromGrid'
        // We need to pass the tableName and className separately for inline editing.
        // These are necessary for xPDO data operations
        ,saveParams: {userTable: config.tableName, tableClass: config.className}
        // Allow inline grid editing
        ,autosave: true
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'id'  
        ,tbar: 
            [{
                // This is our button for creating new records
                text: _('dbedit.record_create')
                ,handler: this.create
            }]
    });
    Dbedit.grid.Records.superclass.constructor.call(this,config)
};
Ext.extend(Dbedit.grid.Records,MODx.grid.Grid,{
    // This handler brings up our context menu with our Update and Delete options
    getMenu: function() {
        var m = [{
            text: _('dbedit.record_update')
            ,handler: this.update
        },'-',{
            text: _('dbedit.record_remove')
            ,handler: this.remove
        }];
        this.addContextMenuItem(m);
        return true;
    }
    // This handler creates a modal window for creating a new record
    ,create: function(btn, e)
    {
        this.createWindow = new Dbedit.window.Create({
            // Pass the className for xPDO
            className: this.config.className
            // Pass the tableName for xPDO
            ,tableName: this.config.tableName
            // Pass the tableTitle for the window title
            ,tableTitle: this.config.tableTitle
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            // Pass our collection of form fields for data access
            ,fields: this.config.createFields
        });

        this.createWindow.show(e.target);
    }
    // This handler creates a modal window for updating a record
    ,update: function(btn,e) 
    {
        this.updateWindow = new Dbedit.window.Update({
            // Pass the current record.
            record: this.menu.record
            // Pass the className for xPDO
            ,className: this.config.className
            // Pass the tableName for xPDO
            ,tableName: this.config.tableName
            // Pass the tableTitle for the window title
            ,tableTitle: this.config.tableTitle
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
            // Pass our collection of form fields for data access
            ,fields: this.config.formFields
        });
        this.updateWindow.setValues(this.menu.record);
        this.updateWindow.show(e.target);
    }
    // This handler deletes the current record
    ,remove: function() {
        MODx.msg.confirm({
            title: _('dbedit.record_remove')
            ,text: _('dbedit.record_remove_confirm')
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
});

// Definition for our modal Create window
Dbedit.window.Create = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('dbedit.record_create')
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/dbedit/create'
            // We finally pass the tableName to the processor for xPDO
            ,userTable: config.tableName
            // We finally pass the className to the processor for xPDO
            ,tableClass: config.className
        }
    });
    Dbedit.window.Create.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Create,MODx.Window);

// Definition for our modal Create window
Dbedit.window.Update = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('dbedit.record_update')
        ,url: Dbedit.config.connectorUrl
        ,baseParams: {
            action: 'mgr/dbedit/update'
            // We finally pass the tableName to the processor for xPDO
            ,userTable: config.tableName
            // We finally pass the className to the processor for xPDO
            ,tableClass: config.className
        }
    });
    Dbedit.window.Update.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.window.Update,MODx.Window);

function buildFormFields(tableData, arrFormFields, hidden)
{
    // Our config array
    var arrConfig = {
        // Set the label from the comment field for column
        fieldLabel: tableData['Comment']
        // Set the name from the actual field name
        ,name: tableData['Field']
        // Set a default width of 300
        ,width: 300
        // Set whether the column is hidden
        ,hidden: hidden
    }
    
    // Get the field type from the column info.  Strip out the size.  i.e. Varchar(200)
    var arrType = tableData['Type'].split('(');
    var type = arrType[0];
    
    // Our new form field
    var newFormField;
    
    // Depending on our type, select what type of field to create.  Pass in our 
    // config array from above
    switch(type)
    {
        case 'text':
            newFormField = new Ext.form.TextArea(arrConfig);
        break;
        
        case 'date':
            newFormField = new Ext.form.DateField(arrConfig);
        break;
        
        case 'int':
            newFormField = new Ext.form.NumberField(arrConfig);
        break;
        
        default:
            newFormField = new Ext.form.TextField(arrConfig);
    }
    
    // Add the new form field to our collection
    arrFormFields.push(newFormField);
}

function buildGridColumns(tableData, arrColumns, hidden)
{   
    // This will be the xtype for our grid column
    var xtype;
    
    // Get the field type from the column info.  Strip out the size.  i.e. Varchar(200)
    var arrType = tableData['Type'].split('(');
    var type = arrType[0];
   
    // Depending on our type, select what type of column to create.
    // This will be used for inline field editing.
    switch(type)
    {
        case 'text':
            xtype = 'textarea';
        break;
        
        case 'date':
            xtype = 'datefield';
        break;
        
        case 'int':
            xtype = 'numberfield';
        break;
        
        default:
            xtype = 'textfield';
    }
    
    // Create config array for our new column 
    var column = {
        // Get the column header from the table column's Comment field
        header: tableData['Comment']
        // Set the datafield name from the actual column name
        ,dataIndex: tableData['Field']
        // Allow sorting
        ,sortable: true
        // Set a default width of 60
        ,width: 60
        // Set whether the column is hidden
        ,hidden: hidden
        // Set the type of field for inline editing
        ,editor: {xtype: xtype}
    }
    
    // Create the new ExtJS column
    var newCol = new Ext.grid.Column(column);
    // Add the column to our column collection
    arrColumns.push(newCol);
}
