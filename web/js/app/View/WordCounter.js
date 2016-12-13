App.define('View.WordCounter',{

    $domObj: '#wordcounter',

    onSelected: function(id, obj, e){
        console.log('selected wordcounter');
    },

    onDeselected: function(id, obj, e){
        console.log('deselected wordcounter');
    },

    ready: function(){ this.callSuper(); },
    init: function(){ this.callSuper(); }
}, 'Abstract.Viewer');
