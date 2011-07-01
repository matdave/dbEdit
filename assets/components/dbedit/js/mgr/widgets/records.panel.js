Dbedit.panel.Records = function(config) {
    config = config || {};
    this.ident = Ext.id();
  
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: 
        [
            {
                html: '<h2>Edit Records</h2>'
                ,border: false
                ,cls: 'modx-page-header'
            }
            ,{
                xtype: 'modx-tabs'
                ,bodyStyle: 'padding: 10px'
                ,defaults: { border: false ,autoHeight: false }
                ,border: true
                ,items: 
                [{
                    title: 'Dbedit'
                    ,defaults: { autoHeight: false }
                    ,minHeight: 500
                    ,height: 500
                    ,layout: 'border'
                    ,items: 
                    [
                        {
                           xtype: 'dbedit-grid-records'
                           ,preventRender: true
                           ,height: 500
                        }
                    ]
                }]
            }
            
        ]
    });
    Dbedit.panel.Records.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit.panel.Records,MODx.Panel);
Ext.reg('dbedit-panel-records',Dbedit.panel.Records);


