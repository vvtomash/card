var AddCardView = Backbone.View.extend({
	tagName: "table",

	className: "quick-add",

	requestTimeout: null,

	events: {
		"keyup input": "searchCards"
	},

	urls: {
		search: '/search/cards'
	},

	initialize: function() {
		this.$input = $(this.$el.find('input'));
	},

	searchCards: function(e) {
		if (e.which === 13) {
			this.sendSearchRequest();
		}
		if ((e.which < 47 && e.which > 58) && (e.which == 32)) {
			return;
		}
		var instance = this;
		clearTimeout(this.requestTimeout);
		this.requestTimeout = setTimeout(function(){
			instance.sendSearchRequest.apply(instance)
		}, 1000);
	},

	sendSearchRequest: function() {
		var searchText = this.$input.val();
		if (!searchText) return;
		$.ajax(this.urls.search, {
			method: 'post',
			dataType: 'json',
			data: {searchText: searchText},
			success : function(response) {
				if (response.data) {
					searchResult.reset(response.data);
				}
			}
		})
	}
});

var searchResultCollection = Backbone.Collection.extend();

var SearchResultView = Backbone.View.extend({
	tagName: "ul",

	className: "dropdown-search-result",

	collection: null,

	views: [],

	events: {
		"click": "hide",
	},
	initialize: function() {
		var $el = this.$el;
		$('body').on('click', function() {
			$el.hide();
		});
		this.listenTo(this.model, 'reset', this.render)
		this.$input = $(this.$el.find('input'));
	},

	hide: function(e) {
		this.model.reset();
	},

	render: function() {
		this.emptyLastResult();
		if (this.model.isEmpty()) {
			this.$el.hide();
			return;
		}
		_this = this;
		_this.views = [];
		this.model.each(function(card) {
			var item = new SearchResultItemView({model: card, parent: _this});
			_this.views.push(item);
			_this.$el.append(item.el);
		});
		this.$el.show();
	},

	emptyLastResult: function() {
		for (var i = 0; i < this.views.length; i++) {
			this.views[i].remove();
		}
	}
});

var SearchResultItemView = Backbone.View.extend({
	tagName: "li",

	className: "search-card",

	events: {
		"click": "addCard"
	},

	initialize: function() {
		this.render(this.model);
	},

	addCard: function(e) {
		e.preventDefault();
		Dispatcher.trigger('QuickAdd:Card', this.model.get('id'));
	},

	render: function(card) {
		this.$el.html("<a>" + card.get('name') + "</a>");
	}
});



$(function() {
	AddCard = new AddCardView({el: 'div.quick-add'});
	searchResult = new searchResultCollection;
	SearchResultView = new SearchResultView({el: 'ul.dropdown-search-result', model: searchResult});
});
