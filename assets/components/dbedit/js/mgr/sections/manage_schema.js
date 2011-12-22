function buildPage()
{
    // Create our grid for the current table
    var grid = new MODx.grid.Grid({
        url: Dbedit.config.connectorUrl
        ,baseParams: {action: 'mgr/dbedit/get_schema'}
        ,fields: ['table_name', 'has_schema']
        ,columns: [
            {header: 'Table Name'
                ,dataIndex: 'table_name'
                ,sortable: true
                ,width: 100
            }
            ,{header: 'Has Schema?'
                ,dataIndex: 'has_schema'
                ,sortable: true
                ,width: 100
            }
        ]

    });

    //  Create a new MODx.Panel for the CMP.
    var panel = new MODx.Panel({
        id: 'dbedit-panel'
        ,border: false
        ,baseCls: 'modx-formpanel'
        ,renderTo: 'dbedit-panel-schema-div'
        ,items: [
            {html: '<h2>'+_('dbedit.schema_manage')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            }
            //  This is our grid we generated above.
            ,buildMenu()
            ,grid
        ]
    });
}

function buildMenu()
{
    var generateSchema = function(btn){
        MODx.Ajax.request({
            url: Dbedit.config.connectorUrl
            ,params: {
                action: 'mgr/dbedit/generate_schema'
                ,corePath: Dbedit.config.corePath
                ,packageName: 'dbedit'
            }
            ,listeners:{
                'success': {fn:MODx.msg.alert(_('dbedit.schema_refresh_title'),_('dbedit.schema_refresh_message')),scope:this}
            }
        });
    }

    var button = new Ext.Button({
        text: _('dbedit.schema_generate')
        ,handler: generateSchema
    });


    return button;
}


