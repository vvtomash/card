var FilterModels = Backbone.Model.extend({
    url: '/collection/search',

    defaults : {
        'expansion': [],
        'type': [],
        'color': [],
        'cmc': null,
        'rarity': [],
    },

    parse: function(response, options) {}
});

var FiltersViewClass = Backbone.View.extend({

    tagName: 'div',

    className: 'collection-filters',

    events: {
        'change .selectpicker' : 'onChangeFilter',
        'click .apply-filters' : 'applyFilter',
    },

    initialize: function() {
        this.$expansion = this.selectPickerInit('.select-expansion', 'Сет');
        this.$type = this.selectPickerInit('.select-type', 'Тип');
        this.$color = this.selectPickerInit('.select-color', 'Цвет');
        this.$cmc = this.selectPickerInit('.select-cmc', 'CMC');
        this.$rarity = this.selectPickerInit('.select-rarity', 'Редкость');
    },

    selectPickerInit: function(selector, name) {
        var $el = this.$el.find(selector);
        $el.selectpicker({
            noneSelectedText: name,
            size: 6,
            showContent: true,
            width: '100%',
            selectedTextFormat: 'static',
            multiple: true
        });
        return $el;
    },

    onChangeFilter: function(e) {
        var $select = $(e.currentTarget);
        var filter = $select.attr('name');
        if (this.model.has(filter)) {
            this.model.set(filter, $select.val());
        }
        console.log(filter);
        console.log($select.val());
    },

    applyFilter: function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.model.save();
    }
});


$(function(){
    var Filters = new FiltersViewClass({el: '.collection-filters', model: new FilterModels});

});