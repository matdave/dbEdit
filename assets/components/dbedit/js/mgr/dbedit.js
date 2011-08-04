var Dbedit = function(config) {
    config = config || {};
    Dbedit.superclass.constructor.call(this,config);
};
Ext.extend(Dbedit,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('dbedit',Dbedit);


Dbedit = new Dbedit();

