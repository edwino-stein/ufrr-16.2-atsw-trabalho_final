(function(){
    App = new Application({
        modules:[
            'Util.Ajax',
            'Util.Classes',
            'Abstract.Viewer',
            'View.Viewport',
            'View.Home',
            'View.Query',
            'View.WordCounter'
        ],
        modulesPath: 'js/app/'
    });
})();
