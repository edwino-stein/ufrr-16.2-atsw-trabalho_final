App.define('View.Home',{

    $domObj: '#home',

    onSelected: function(id, obj, e){
        console.log('selected home');
    },

    onDeselected: function(id, obj, e){
        console.log('deselected home');
    },

    ready: function(){ this.callSuper(); },
    init: function(){ this.callSuper(); }
}, 'Abstract.Viewer');
