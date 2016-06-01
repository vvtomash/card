var FiltersViewClass = Backbone.View.extend({

    tagName: 'div',

    className: 'collection-filters',

    initialize: function() {
        this.$sets = this.selectPickerInit('.select-sets', 'Сет');
        this.$types = this.selectPickerInit('.select-types', 'Тип');
        this.$colors = this.selectPickerInit('.select-colors', 'Цвет');
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
    }
});


$(function(){
    var Filters = new FiltersViewClass({el: '.collection-filters'});

});