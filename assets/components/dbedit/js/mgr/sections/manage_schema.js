Ext.onReady(function() {
    MODx.load({ xtype: 'dbedit-page-schema'});
});

Dbedit.page.Schema = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'dbedit-panel-schema'
            ,renderTo: 'dbedit-panel-schema-div'
        }]
    });
    Dbedit.page.Schema.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.page.Schema,MODx.Component);
Ext.reg('dbedit-page-schema',Dbedit.page.Schema);
