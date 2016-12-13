App.define('Util.Classes',{

    instantiable: [],

    Time: function Time(dateString){

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
            if(unInstantiable.indexOf(i) < 0)
                this.instantiable.push(i);
        }
    }
});
