App.define('View.WordCounter',{

    colorPallet: 'ColorPallet',

    $domObj: '#wordcounter',
    $tableRowModel: '#wordcounter-model',
    queryInput: 'query-wordcounter',
    queryUrl: 'twitter/wordcount',
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

        var d = [], model;
        for(var i in data.words){
            model = {word: i, amount: data.words[i]};
            this.addViewModel(this.createTweetViewModel(model));
            d.push(model);
        }

        this.renderChart(d, true);

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
            labels.push(data[i].word);
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

    onSelected: function(id, obj, e){
        console.log('selected wordcounter');
    },

    onDeselected: function(id, obj, e){
        console.log('deselected wordcounter');
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
