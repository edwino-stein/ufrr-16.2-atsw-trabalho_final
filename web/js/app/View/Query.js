App.define('View.Query',{

    $domObj: '#query',
    $tweetModel: '#tweet-model',
    queryInput: 'query-main',
    queryUrl: 'twitter/query',
    maxTweets: 25,

    emptyMessage: '<h3>Busque por algum tema utilizando a caixa acima</h3>',
    notFoundMessage: '<h3>Nenhum resultado</h3>',
    waitingMessage: '<h3>Por favor, aguarde...</h3>',
    errorMessage: '<h3>Ocorreu um erro durante a consulta</h3>',

    render: function(){
        var me = this;
        me.queryInput = this._appRoot_.get('Util.Classes').getInstance('QueryInput', this.$domObj.find('.query'), {
            id: me.queryInput,
            href: me.queryUrl,
            placeholder: 'Buscar tema...',
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

        var count = 0;
        for(var i in data){
            this.addViewModel(this.createTweetViewModel(data[i]));
            count++;
        }

        this.showReport(count);
        if(count > 0){
            this.hideMessage();
            this.showResults();
        }
        else{
            this.showMessage(this.notFoundMessage);
        }
    },

    showReport: function(data){
        this.$domObj.find('.report .counter').html(data);
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
        this.$domObj.find('.results .list-group-item').remove();
    },

    createTweetViewModel: function(model){

        var view = this.$tweetModel.clone();
        view.find('.text').html(model.text);
        view.find('.date').html(this.rendererDate(model.created_at));
        view.find('.likes .counter').html(model.favorite_count);
        view.find('.retweeties .counter').html(model.retweet_count);

        view.find('.avatar img').attr('src', model.user.profile_image_url);
        view.find('.user .name').html(model.user.name);
        view.find('.user .nick').html('@'+model.user.screen_name);

        return view[0];
    },

    addViewModel: function(view){
        this.$domObj.find('.results').append(view);
    },

    rendererDate: function(date){
        date = this._appRoot_.get('Util.Classes').getInstance('Time', date).date;
        var nr = function(num) {return num < 10 ? '0'+num : num+''},
            weekDay = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'][date.getDay()],
            month = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'][date.getMonth()];
        return weekDay+', '+nr(date.getDate())+' de '+month+' de '+date.getFullYear()+', às '+nr(date.getUTCHours())+':'+nr(date.getUTCMinutes())+':'+nr(date.getUTCSeconds());
    },

    ready: function(){
        this.callSuper();
        this.showMessage(this.emptyMessage);
    },

    init: function(){
        this.callSuper();
        this.$tweetModel = $(this.$tweetModel).removeAttr('id').remove();
    }

}, 'Abstract.Viewer');
