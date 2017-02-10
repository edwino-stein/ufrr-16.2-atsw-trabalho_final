App.define('Util.Classes',{

    instantiable: [],

    Time: function Time(dateString){

        if(typeof(dateString) === 'object' && dateString.date) dateString = dateString.date;

        if(typeof(dateString) === 'string'){

            var timeStamp = Date.parse(dateString.replace(' ', 'T')+'Z');

            if(!isNaN(timeStamp)){
                this.date = new Date(timeStamp);
            }

            else if (RegExp(/(((0|1)\d)|(2[0-3])):([0-5])\d(:([0-5])\d)?/g).test(dateString)){
                dateString = RegExp(/(((0|1)\d)|(2[0-3])):([0-5])\d(:([0-5])\d)?/g).exec(dateString)[0].split(':');
                this.date = new Date();
                this.date.setUTCHours(dateString[0]);
                this.date.setUTCMinutes(dateString[1]);
                this.date.setUTCSeconds(dateString[2] ? dateString[2] : 0);
            }

            else{
                throw 'Formato de tempo inválido.'
            }
        }

        else if(dateString instanceof Date){
            this.date = dateString;
        }
        else{
            this.date = new Date();
        }

        this.getHours = function(asString){
            if(!asString) return this.date.getUTCHours();
            var hour = this.date.getUTCHours();
            return (hour < 10 ? '0' : '')+hour;
        };

        this.setHours = function (hour){
            this.date.setUTCHours(hour);
            return this;
        };

        this.getMinutes = function (asString){
            if(!asString) return this.date.getUTCMinutes();
            var minutes = this.date.getUTCMinutes();
            return (minutes < 10 ? '0' : '') + minutes;
        };

        this.setMinutes = function (minutes){
            this.date.setUTCMinutes(minutes);
            return this;
        };

        this.getSeconds = function (asString){
            if(!asString) return this.date.getUTCSeconds();
            var seconds = this.date.getUTCSeconds();
            return (seconds < 10 ? '0' : '') + seconds;
        };

        this.setSeconds = function (seconds){
            this.date.setUTCSeconds(seconds);
            return this;
        };

        this.toString = function (asDate){

            if(asDate) return this.date.toUTCString();

            return this.getHours(true)+':'+this.getMinutes(true)+':'+this.getSeconds(true);
        };
    },

    QueryInput: function QueryInput (renderTo, config){

        if(typeof(window.QueryInputCfg) !== 'object'){
            window.QueryInputCfg = {
                initted: false,
                domObj: $('#query-input-abstract').removeAttr('id').remove(),
                instanceCounter: 0
            };
        }

        var me = this;
        me.config = typeof(config) !== 'object' ? {} : config;
        me.config.id = typeof(config.id) !== 'string' ? 'query-input-' + QueryInput.instanceCounter : config.id;
        me.config.href = typeof(config.href) !== 'string' ? '' : config.href;
        me.config.method = typeof(config.method) !== 'string' ? 'GET' : config.method;
        me.config.dataType = typeof(config.dataType) !== 'string' ? 'json' : config.dataType;
        me.config.placeholder = !config.placeholder ? "Buscar..." : config.placeholder;
        me.config.maxCount = !config.maxCount ? 15 : config.maxCount;
        me.config.onBeforeQuery = typeof(config.onBeforeQuery) !== 'function' ? function(){ me.disableQuery(true); } : config.onBeforeQuery;
        me.config.onQuery = typeof(config.onQuery) !== 'function' ? function(){} : config.onQuery;
        me.config.onAfterQuery = typeof(config.onAfterQuery) !== 'function' ? function(){  me.disableQuery(false); } : config.onAfterQuery;
        me.config.onQueryError = typeof(config.onQueryError) !== 'function' ? function(){ console.log(arguments); } : config.onQueryError;

        me.domObj = window.QueryInputCfg.domObj.clone();
        me.disabled = false;

        me.disableQuery = function(disabled){
            me.domObj.find('input[type=text]').prop('disabled', disabled);
            me.domObj.find('button').prop('disabled', disabled);
            me.disabled = disabled;
        };

        me.hasDisabled = function(){
            return me.disabled;
        };

        me.getValue = function(){
            return me.domObj.find('input[type=text]').val();
        };

        me.setValue = function (value){
            me.domObj.find('input[type=text]').val(value);
        };

        me.setPlaceholder = function(placeholder){
            me.domObj.find('input[type=text]').attr('placeholder', placeholder);
        };

        me.doQuery = function(value){
            me.setValue(value);
            me.domObj.submit();
        };

        me.domObj.submit(function(e){
            e.preventDefault();

            var data = me.getValue();
            if(data === '') return;

            me.config.onBeforeQuery(e);
            var ajax = QueryInput.classScope._appRoot_.get('Util.Ajax');
            ajax.request({
                url: me.config.href,
                data: {
                    q: data,
                    count: me.config.maxCount
                },
                method: me.config.method,
                dataType: me.config.dataType,
                success: me.config.onQuery,
                fail: me.config.onQueryError,
                complete: me.config.onAfterQuery
            });
        });

        me.domObj.attr('id', me.config.id);
        me.setPlaceholder(me.config.placeholder);
        $(renderTo).append(me.domObj);
        me.disableQuery(false);
        window.QueryInputCfg.instanceCounter++;
    },

    ColorPallet: function ColorPallet(){

        var baseColors = ["red", "orange", "yellow", "green", "aqua", "blue", "violet", "red"];
        var colorInterval = 1/baseColors.length;
        var colorRange = 500;

        function Color(colorArray){
            this.colorArray = colorArray;

            this.getRed = function(hex){
                if(hex) return (this.colorArray[0] < 16 ? '0' : '') + this.colorArray[0].toString(16);
                return this.colorArray[0];
            };

            this.getGreen = function(hex){
                if(hex) return (this.colorArray[1] < 16 ? '0' : '') + this.colorArray[1].toString(16);
                return this.colorArray[1]
            };

            this.getBlue = function(hex){
                if(hex) return (this.colorArray[2] < 16 ? '0' : '') + this.colorArray[2].toString(16);
                return this.colorArray[2]
            };

            this.getRGB = function(){
                return [
                    this.getRed(),
                    this.getGreen(),
                    this.getBlue(),
                ];
            };

            this.getHex = function(){
                return '#'+this.getRed(true)+this.getGreen(true)+this.getBlue(true);
            };
        }

        this.canvas = $.parseHTML('<canvas width="'+colorRange+'" height="1"></canvas>')[0];
        this.context = this.canvas.getContext("2d");

        //$('#viewport').append(this.canvas);

        var gradient = this.context.createLinearGradient(0, 0, colorRange, 0);
        for(var i in baseColors){
            gradient.addColorStop(i*colorInterval, baseColors[i]);
        }

        this.context.fillStyle = gradient;
        this.context.fillRect(0, 0, colorRange, 1);

        this.getColor = function(offset){
            var maxColor = colorRange;
            if(offset >= maxColor) offset = offset - maxColor;
            if(offset < 0) offset = maxColor + offset;

            var color = this.context.getImageData(offset, 0, 1, 1).data;
            $('#color').css('background-color', 'rgb('+color[0]+','+color[1]+','+color[2]+')')
            return new Color(color);
        };

        this.getColorByTonality = function(tonality, offset){

            tonality = (baseColors.indexOf(tonality) * colorInterval * colorRange) - 1;
            if(tonality < 0) tonality = 0;

            return this.getColor(tonality + offset);
        };
    },

    getInstance: function(className){

        if(this.instantiable.indexOf(className) < 0)
            throw  'Classe inválida';

        var args = Array.prototype.slice.call(arguments);
        args.shift();

        return new this[className](...args);
    },


    init: function(){
        var unInstantiable = ['_appRoot_', '_initted_', '_namespace_', '_parent_', '_super_', 'apply', 'hasProperty', 'init', 'ready', 'getInstance', 'instantiable'];

        for(var i in this){
            if(unInstantiable.indexOf(i) < 0){
                this.instantiable.push(i);
                this[i].classScope = this;
            }

        }
    }
});
