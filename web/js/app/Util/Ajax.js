App.define('Util.Ajax',{

    defaultDataType: 'json',
    defaultRequestMethod: 'GET',
    defaultContentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    defaultProcessData: true,

    request: function (config){
        var url = new this._appRoot_.Base.Url(config.url),
            method = config.method ? config.method : this.defaultRequestMethod,
            dataType = config.dataType ? config.dataType: this.defaultDataType,
            failAction = config.fail ? config.fail : function () {},
            successAction = config.success,
            data = config.data ? config.data : null,
            contentType = config.contentType !== null ? config.contentType : this.defaultContentType,
            processData = config.processData !== null ? config.processData : this.defaultProcessData;

        url.setParam('_', this._appRoot_.Base.getTimeStamp());

        $.ajax({
            url: url.toString(),
            dataType: dataType,
            cache: false,
            type: method,
            data: data,
            processData: processData,
            contentType: contentType,
            success: function(response, textStatus, request) {
                if (response.success) {
                    successAction(response.data, response);
                }
                else {
                    failAction(request);
                }
            },
            error: failAction
        });
    }
});
