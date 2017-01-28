App.define('View.Query',{

    $domObj: '#query',
    queryInput: 'query-main',
    queryUrl: 'twitter/query',

    onSelected: function(id, obj, e){
        console.log('selected Query');
    },

    onDeselected: function(id, obj, e){
        console.log('deselected Query');
    },

    render: function(){
        var me = this;
        me.queryInput = this._appRoot_.get('Util.Classes').getInstance('QueryInput', this.$domObj.find('.query'), {
            id: me.queryInput,
            href: me.queryUrl,
            placeholder: 'Buscar tema...',
            onQuery: function(){
                console.log(arguments);
            },
            onQueryError: function(){
                console.log(arguments);
            }
        });
    },



    ready: function(){ this.callSuper(); },
    init: function(){ this.callSuper(); }
}, 'Abstract.Viewer');
