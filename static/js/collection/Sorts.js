var SortsViewClass = Backbone.View.extend({

    tagName: 'div',

    className: 'collection-sorts',

    initialize: function() {
        this.$foil = this.selectPickerInit('.select-foil', 'Фойл', {selectedTextFormat: 'values'});
        this.$names = this.selectPickerInit('.select-name', 'Имя');
        this.$sets = this.selectPickerInit('.select-sets', 'Cет');
        this.$colors = this.selectPickerInit('.select-colors', 'Цвет');
        this.$cmc = this.selectPickerInit('.select-cmc', 'CMC');
        this.$rarity = this.selectPickerInit('.select-rarity', 'Редкость');
    },

    selectPickerInit: function(selector, name, options) {
        var $el = this.$el.find(selector);
        var defaults = {
            noneSelectedText: name,
            width: 'fit',
            selectedTextFormat: 'static'
        };
        options = merge(defaults, options || {});
        console.log(options);
        $el.selectpicker(options);
        return $el;
    }
});


$(function(){
    var Sorts = new SortsViewClass({el: '.collection-sorts'});

})