var UserCard = Backbone.Model.extend({
	id: null,
	name: null,
	point: null,
	added_timestamp: null
});

var UserCardsCollection = Backbone.Collection.extend({
	model: UserCard,

	urls : {
		remove: '/cards/remove',
		add: '/cards/add',
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'UserCard:removeClick', this.removeCard);
	},

	addCard: function(cardId) {
		var _this = this;
		$.ajax(this.urls.add, {
			method: 'post',
			dataType: 'json',
			data: {id: cardId},
			success : function(response) {
				if (response.data) {
					_this.add([response.data]);
				}
			},
			error: function(response) {
				if (response.responseJSON && response.responseJSON.errors) {
					alert('error: ' + response.responseJSON.errors);
				}
			}
		});
	},

	removeCard: function(cardId) {
		var _this = this;
		$.ajax(this.urls.remove, {
			method: 'post',
			dataType: 'json',
			data: {id: cardId},
			success : function(response) {
				if (response.data) {
					_this.remove(cardId);
					Dispatcher.trigger('UserCard:removed:' + cardId);
					alert('card was removed successfully');
				}
			},
			error: function(response) {
				if(response.responseJSON && response.responseJSON.errors) {
					alert('error: ' + response.responseJSON.errors);
				}
			}
		});
	}
});

var UserCardView = Backbone.View.extend({
	tagName: "tr",
	className: "user-card",

	events: {
		"click .remove": "removeCard",
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.listenTo(Dispatcher, 'UserCard:removed:' + this.model.get('id'), this.remove)
	},

	remove: function() {
		this.$el.remove();
	},

	render: function() {
		console.log(this.model);
		this.$el.append("<td>" + this.model.get('name') + "</td>");
		this.$el.append("<td>" + this.model.get('point') + "</td>");
		this.$el.append("<td>" + this.model.get('added_timestamp') + "</td>");
		this.$el.append("<td><a href='#' class='btn btn-danger remove'>Remove</a></td>");
	},

	removeCard: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('UserCard:removeClick', this.model.get('id'));
	}
});

var UserCardsViewClass = Backbone.View.extend({
	tagName: "table",
	className: "user-cards",
	cards: [],

	initialize: function() {
		this.listenTo(this.model, 'add', this.addCard);
		this.listenTo(this.model, 'remove', this.removeCard);
		this.$el.find('tr.user-card').each(function() {
			$this = $(this);
			var card = new UserCard({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				added_timestamp: $this.find('.added-timestamp').text()
			});
			new UserCardView({el: this, model: card});
		});
	},

	addCard: function(model) {
		var userCard = new UserCardView({el: this, model: model});
		userCard.render();
		this.$el.append(userCard.el)
	}
});

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
		"click": "addCard",
	},

	initialize: function(options) {
		this.parent = options.parent || {};
		this.render(this.model);
	},

	addCard: function(e) {
		UserCards.addCard(this.model.get('id'));
	},

	render: function(card) {
		this.$el.html(card.get('name'));
	}
});


$(function() {
	UserCards = new UserCardsCollection;
	UserCardsView = new UserCardsViewClass({el: "table.user-cards", model: UserCards});
	AddCard = new AddCardView({el: 'div.quick-add'});
	searchResult = new searchResultCollection;
	SearchResultView = new SearchResultView({el: 'ul.dropdown-search-result', model: searchResult});
});
