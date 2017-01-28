App.define('Abstract.Viewer',{

    _isAbstract_: true,
    $domObj: '',
    viewPort: 'View.Viewport',

    onSelected: function(id, obj, e){
        return;
    },

    onDeselected: function(id, obj, e){
        return;
    },

    render: function(){
        return;
    },

    ready: function(){
        var me = this;

        me.viewPort.on('tab-selected', function(e, id, obj){
            if(me.$domObj[0] === obj) me.onSelected(id, obj, e);
        });

        me.viewPort.on('tab-deselected', function(e, id, obj){
            if(me.$domObj[0] === obj) me.onDeselected(id, obj, e);
        });
    },

    init: function(){
        var me = this;
        me.$domObj = $(me.$domObj);
        me.viewPort = this._appRoot_.get(me.viewPort);
        me.render();
    }
});
