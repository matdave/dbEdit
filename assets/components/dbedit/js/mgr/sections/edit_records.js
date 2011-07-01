Ext.onReady(function() {
    MODx.load({ xtype: 'dbedit-page-records'});
});

Dbedit.page.Records = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'dbedit-panel-records'
            ,renderTo: 'dbedit-panel-records-div'
        }]
    });
    Dbedit.page.Records.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.page.Records,MODx.Component);
Ext.reg('dbedit-page-records',Dbedit.page.Records);
