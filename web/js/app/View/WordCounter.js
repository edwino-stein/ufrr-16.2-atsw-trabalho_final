App.define('View.WordCounter',{

    $domObj: '#wordcounter',
    $tableRowModel: '#wordcounter-model',
    queryInput: 'query-wordcounter',
    queryUrl: 'twitter/wordcount',
    maxTweets: 15,

    emptyMessage: '<h3>Busque por algum tema utilizando a caixa acima</h3>',
    notFoundMessage: '<h3>Nenhum resultado</h3>',
    waitingMessage: '<h3>Por favor, aguarde...</h3>',
    errorMessage: '<h3>Ocorreu um erro durante a consulta</h3>',

    render: function(){
        var me = this;
        me.queryInput = this._appRoot_.get('Util.Classes').getInstance('QueryInput', this.$domObj.find('.query'), {
            id: me.queryInput,
            href: me.queryUrl,
            placeholder: 'Contar palavras...',
            maxCount: this.maxTweets,
            onBeforeQuery: function(){
                me.queryInput.disableQuery(true);
                me.showMessage(me.waitingMessage);
                me.cleanResults();
                me.hideResults();
                me.hideReport();
            },
            onQuery: function(data, request){
                me.onQuery(data);
            },
            onQueryError: function(){
                me.showMessage(me.errorMessage);
            }
        });
    },

    onQuery: function(data){
        for(var i in data.words){
            this.addViewModel(this.createTweetViewModel({word: i, amount: data.words[i]}));
        }

        this.showReport(data.totalWords, data.totalTweets);

        if(data.totalTweets > 0){
            this.hideMessage();
            this.showResults();
        }
        else{
            this.showMessage(this.notFoundMessage);
        }
    },

    createTweetViewModel: function(model){
        var view = this.$tableRowModel.clone();
        console.log(model);
        view.find('.word').html(model.word);
        view.find('.amount').html(model.amount);
        return view[0];
    },

    addViewModel: function(view){
        this.$domObj.find('.results tbody').append(view);
    },

    showReport: function(words, tweets){
        this.$domObj.find('.report .word-counter').html(words);
        this.$domObj.find('.report .tweet-counter').html(tweets);
        this.$domObj.find('.report').show();
    },

    hideReport: function(){
        this.$domObj.find('.report').hide();
    },

    showMessage: function(message){
        this.$domObj.find('.message').html(message).show();
    },

    hideMessage: function(){
        this.$domObj.find('.message').hide();
    },

    showResults: function(){
        this.$domObj.find('.results').show();
    },

    hideResults: function(){
        this.$domObj.find('.results').hide();
    },

    cleanResults: function(){
        this.$domObj.find('.results tbody .tr').remove();
    },

    onSelected: function(id, obj, e){
        console.log('selected wordcounter');
    },

    onDeselected: function(id, obj, e){
        console.log('deselected wordcounter');
    },

    ready: function(){
        this.callSuper();
        this.showMessage(this.emptyMessage);
    },

    init: function(){
        this.callSuper();
        this.$tableRowModel = $(this.$tableRowModel).removeAttr('id').remove();
    }
}, 'Abstract.Viewer');
