App.define('View.Cooccurrences',{

    $domObj: '#cooccurrences',
    $dataModel: '#cooccurrences-model',
    $tableRowModel: '#cooccurrences-model-row',
    queryInput: 'query-cooccurrences',
    queryUrl: 'twitter/cooccurrences',
    maxTweets: 100,

    emptyMessage: '<h3>Busque por algum tema utilizando a caixa acima</h3>',
    notFoundMessage: '<h3>Nenhum resultado</h3>',
    waitingMessage: '<h3>Por favor, aguarde...</h3>',
    errorMessage: '<h3>Ocorreu um erro durante a consulta</h3>',

    render: function(){
        var me = this;
        me.queryInput = this._appRoot_.get('Util.Classes').getInstance('QueryInput', this.$domObj.find('.query'), {
            id: me.queryInput,
            href: me.queryUrl,
            placeholder: 'Contar co-ocorrência...',
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

        var totalWords = data.totalWords,
            totalTweets = data.totalTweets;
        data = data.cooccurrences;

        for(var i in data){
            this.addViewModel(this.createTweetViewModel({word: i, cooccurrences: data[i]}));
        }

        this.showReport(totalWords, totalTweets);

        if(totalWords > 0){
            this.hideMessage();
            this.showResults();
        }
        else{
            this.showMessage(this.notFoundMessage);
        }
    },

    createTweetViewModel: function(model){
        var view = this.$dataModel.clone(),
            table = view.find('tbody'),
            row, amount = 0, t = 0;

        view.find(".result-header").click(function(e){
            $(this).parent('.list-group-item').toggleClass('collapsed');
        });

        for(var i in model.cooccurrences){
            row = this.$tableRowModel.clone();
            row.find('.word').html(i);
            row.find('.amount').html(model.cooccurrences[i]);
            table.append(row);
            amount += model.cooccurrences[i];
            t++;
        }

        view.find('.result-header .word').html(model.word);
        view.find('.result-header .word-amount').html(t);
        view.find('.result-header .cooccurrences-amount').html(amount);

        return view[0];
    },

    addViewModel: function(view){
        this.$domObj.find('.results').append(view);
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
        this.$domObj.find('.results li').remove();
    },

    ready: function(){
        this.callSuper();
        this.showMessage(this.emptyMessage);
    },

    init: function(){
        this.callSuper();
        this.$tableRowModel = $(this.$tableRowModel).removeAttr('id').remove();
        this.$dataModel = $(this.$dataModel).removeAttr('id').remove();
    }
}, 'Abstract.Viewer');
