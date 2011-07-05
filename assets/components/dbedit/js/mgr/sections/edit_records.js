Ext.onReady(function() {
    //MODx.load({ xtype: 'dbedit-page-records'});
    myFunc();
});


Dbedit.panel.Records = function(config) {
    Dbedit.panel.Records.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.panel.Records,MODx.Panel);

Dbedit.page.Records = function(config) {
    Dbedit.page.Records.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.page.Records,MODx.Component);

Dbedit.grid.Records = function(config) {
    Dbedit.grid.Records.superclass.constructor.call(this,config)
};
Ext.extend(Dbedit.grid.Records,MODx.grid.Grid);



function myFunc()
{
    var tabs = new MODx.Tabs(

    );
    
    var tab1 = tabs.add({title: 'tab1'});
    var tab2 = tabs.add({title: 'tab2'});
    var tab3 = tabs.add({title: 'tab3'});
    //tabs.doLayout();
    
    
    var grid1 = new Dbedit.grid.Records({
        id: 'dbedit-grid-records'
        ,url: '/trans_pkgs/dbedit/assets/components/dbedit/connector.php'
        ,baseParams: {action: 'mgr/dbedit/records',userTable: 'dbedit',tableClass: 'Dbedit'}
        ,fields: [
            'id'
            ,'first'
            ,'last'
            ,'address1'
            ,'address2'
            ,'city'
            ,'state'
            ,'zip'
        ]
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'id'
        
        //,save_action: 'mgr/doodle/updateFromGrid'
        //,autosave: true
        ,columns: 
        [
            {header: 'ID'
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'First Name'
            ,dataIndex: 'first'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'Last Name'
            ,dataIndex: 'last'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'Address 1'
            ,dataIndex: 'address1'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'Address 2'
            ,dataIndex: 'address2'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'City'
            ,dataIndex: 'city'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'State'
            ,dataIndex: 'state'
            ,sortable: true
            ,width: 60
            }
            ,{header: 'Zip'
            ,dataIndex: 'zip'
            ,sortable: true
            ,width: 60
            }
        ]           

    });
    tab1.add(grid1);
    
    var panel = new MODx.Panel({
        id: 'dbedit-panel'
        //,renderTo: 'dbedit-panel-records-div'
        ,items: [
            {html: '<h2>Edit Records</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            }
            ,tabs
        ]
    });
    var page = new MODx.Component({components: panel});
    
    MODx.load(page);
    
}




//Dbedit.page.Records = function(config) {
//    config = config || {};
//    Ext.applyIf(config,{
//        components: [{
//            xtype: 'dbedit-panel-records'
//            ,renderTo: 'dbedit-panel-records-div'
//        }]
//    });
//    Dbedit.page.Records.superclass.constructor.call(this,config);
//};
//Ext.extend(Dbedit.page.Records,MODx.Component);
//Ext.reg('dbedit-page-records',Dbedit.page.Records);


