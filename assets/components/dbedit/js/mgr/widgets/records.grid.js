Dbedit.grid.Records = function(config) {
    config = config || {};
    Ext.applyIf(config,{
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
    Dbedit.grid.Records.superclass.constructor.call(this,config)
};

Ext.extend(Dbedit.grid.Records,MODx.grid.Grid);
Ext.reg('dbedit-grid-records',Dbedit.grid.Records);
