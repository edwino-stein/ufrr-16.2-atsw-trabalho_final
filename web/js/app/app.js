(function(){
    App = new Application({
        modules:[
            'Util.Ajax',
            'Util.Classes',
            'Abstract.Viewer',
            'View.Viewport',
            'View.Home',
            'View.Query',
            'View.WordCounter',
            'View.HashtagCounter'
        ],
        modulesPath: 'js/app/'
    });
})();
