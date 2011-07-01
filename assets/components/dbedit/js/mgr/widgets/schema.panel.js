Dbedit.panel.Schema = function(config) {
    config = config || {};
    this.ident = Ext.id();
  
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: 
        [
            {
                html: '<h2>Manage Schema</h2>'
                ,border: false
                ,cls: 'modx-page-header'
            },
            {
               xtype: 'dbedit-grid-dbedit'
               ,preventRender: true
            }
        ]
    });
    Dbedit.panel.Schema.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.panel.Schema,MODx.Panel);
Ext.reg('dbedit-panel-schema',Dbedit.panel.Schema);


