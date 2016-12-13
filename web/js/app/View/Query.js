App.define('View.Query',{

    $domObj: '#query',

    onSelected: function(id, obj, e){
        console.log('selected Query');
    },

    onDeselected: function(id, obj, e){
        console.log('deselected Query');
    },

    ready: function(){ this.callSuper(); },
    init: function(){ this.callSuper(); }
}, 'Abstract.Viewer');
