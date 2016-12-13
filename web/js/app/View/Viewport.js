App.define('View.Viewport',{

    $viewPort: '#viewport',
    $tabPanel: '#tab-panel',

    onTabSelected: function(tab, id, e){

        tab = $(tab);

        var old = this.$viewPort.find('.tab-pane.active').removeClass('active');
        this.$viewPort.trigger('tab-deselected', [old.attr('id'), old[0]]);

        tab.addClass('active');
        this.$viewPort.trigger('tab-selected', [id, tab[0]]);
    },

    on: function (eventName, handle){
        this.$viewPort.on(eventName, handle);
    },

    onTabClicked: function(el, e){
        el = $(el);
        this.$tabPanel.find('li.active').removeClass('active');
        el.parent().addClass('active');

        var viewTarget = el.data('view');
        if(typeof viewTarget !== 'string') return;

        e.preventDefault();
        viewTarget = $(viewTarget);
        if(viewTarget.length > 0) this.onTabSelected(viewTarget[0], viewTarget, e);
    },

    init: function(){
        var me = this;
        me.$viewPort = $(me.$viewPort);
        me.$tabPanel = $(me.$tabPanel);
        me.$tabPanel.find('a').click(function(e){ me.onTabClicked(this, e); });
    }
});
