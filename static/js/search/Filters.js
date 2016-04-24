var FilterModel = Backbone.Model.extend({

});

var FilterView = Backbone.View.extend({

	initialize: function() {
		this.$selectSets = this.$el.find('.select-sets');
		this.$selectSets.selectpicker({
			noneSelectedText: 'Ничего не выбрано',
			liveSearch: true,
			size: 4
		});
		this.$selectColors = this.$el.find('.select-colors');
		this.$selectColors.selectpicker({
			noneSelectedText: 'Ничего не выбрано',
			size: 4
		});
	},

	toggle: function() {
		this.$el.toggleClass('hidden');
	}
});

$(function(){
	var Filter = new FilterView({
		model: new FilterModel,
		el: '.search-filters'
	});

	$('body').on('click', '.search-filters-btn', function() {
		Filter.toggle();
		console.log('show');
	});
});
