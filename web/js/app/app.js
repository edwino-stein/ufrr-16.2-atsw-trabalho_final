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
            'View.HashtagCounter',
            'View.Cooccurrences'
        ],
        modulesPath: 'js/app/'
    });
})();
