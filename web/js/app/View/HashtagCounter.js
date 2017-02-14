App.define('View.HashtagCounter',{

    colorPallet: 'ColorPallet',

    $domObj: '#hashcounter',
    $tableRowModel: '#hashcounter-model',
    queryInput: 'query-hashcounter',
    queryUrl: 'twitter/hashtagcount',
    maxTweets: 100,

    emptyMessage: '<h3>Busque por algum tema utilizando a caixa acima</h3>',
    notFoundMessage: '<h3>Nenhum resultado</h3>',
    waitingMessage: '<h3>Por favor, aguarde...</h3>',
    errorMessage: '<h3>Ocorreu um erro durante a consulta</h3>',

    chartObj: null,

    render: function(){
        var me = this;
        me.queryInput = this._appRoot_.get('Util.Classes').getInstance('QueryInput', this.$domObj.find('.query'), {
            id: me.queryInput,
            href: me.queryUrl,
            placeholder: 'Contar hashtags...',
            maxCount: this.maxTweets,
            onBeforeQuery: function(){
                me.queryInput.disableQuery(true);
                me.showMessage(me.waitingMessage);
                me.cleanResults();
                me.hideResults();
                me.hideReport();
                me.hideChart(true);
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

        var hashtagsTotal = data.hashtagsTotal,
            totalTweets = data.totalTweets;

        data = this.preProcessData(data.hashtags);

        for(var i in data.sorted){
            this.addViewModel(this.createTweetViewModel(data.sorted[i]));
        }


        this.renderChart(data.sorted, true);

        this.showReport(hashtagsTotal, totalTweets);

        if(hashtagsTotal > 0){
            this.hideMessage();
            this.showResults();
        }
        else{
            this.showMessage(this.notFoundMessage);
        }
    },

    preProcessData: function(data){

        var list = [];
        for(var i in data){
            list.push({hashtag: i, amount: data[i]});
        }

        list.sort(function(a, b){
            return (a.amount - b.amount)*(-1);
        });

        return {
            sorted: list,
        };
    },

    createTweetViewModel: function(model){
        var view = this.$tableRowModel.clone();
        view.find('.hashtag').html(model.hashtag);
        view.find('.amount').html(model.amount);
        return view[0];
    },

    addViewModel: function(view){
        this.$domObj.find('.results tbody').append(view);
    },

    showReport: function(hashtags, tweets){
        this.$domObj.find('.report .hashtags-counter').html(hashtags);
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
        this.$domObj.find('.results tbody tr').remove();
    },

    renderChart: function (data, show){
        this.destroyChart();
        if(show) this.showChart();

        var canvas = $.parseHTML('<canvas></canvas>')[0];
        this.$domObj.find('.chart').append(canvas);

        var labels = [],
            values = [],
            backgroundColor = [],
            baseColors = ["red", "orange", "yellow", "green", "aqua", "blue", "violet"],
            colorIndex = Math.floor((Math.random() * (baseColors.length -1)) + 1),
            colorOffset = 1,
            color = null;

        for(var i in data){
            labels.push(data[i].hashtag);
            values.push(data[i].amount);

            color = this.colorPallet.getColorByTonality(baseColors[colorIndex++], colorOffset);

            if(colorIndex >= baseColors.length){
                colorIndex = 0;
                colorOffset += 10;
            }

            backgroundColor.push(color.getHex());
        }

        Chart.defaults.global.legend.display = false;
        this.chartObj = new Chart(canvas, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'My dataset',
                    data: values,
                    backgroundColor: backgroundColor
                }]
            },
        });
    },

    showChart: function (){
        this.$domObj.find('.chart').show();
    },

    hideChart: function (destroy){
        this.$domObj.find('.chart').hide();
        if(destroy) this.destroyChart();
    },

    destroyChart: function (){
        this.chartObj = null;
        this.$domObj.find('.chart *').remove();
    },

    ready: function(){
        this.callSuper();
        this.colorPallet = this._appRoot_.get('Util.Classes').getInstance(this.colorPallet);
        this.showMessage(this.emptyMessage);
    },

    init: function(){
        this.callSuper();
        this.$tableRowModel = $(this.$tableRowModel).removeAttr('id').remove();
    }
}, 'Abstract.Viewer');
