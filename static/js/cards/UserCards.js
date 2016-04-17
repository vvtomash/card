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
		next: '/cards/nextHaves',
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'UserCard:RemoveClick', this.removeCard);
		this.listenTo(Dispatcher, 'QuickAdd:Card', this.addCard);
		this.listenTo(Dispatcher, 'UserCard:Removed', this.getNext);
	},

	addCard: function(cardId) {
		var _this = this;
		ajax(
			this.urls.add,
			{id: cardId},
			function(data) {
				if (data) {
					_this.add([data], {prepend: true});
					notifications.trigger("success", "Card was added successfully");
				}
			}
		);
	},

	removeCard: function(cardId) {
		var _this = this;
		ajax(
			this.urls.remove,
			{id: cardId},
			function(data) {
				if (data) {
					console.log('remove');
					_this.remove(cardId);
					Dispatcher.trigger('UserCard:Removed');
					Dispatcher.trigger('UserCard:Removed:' + cardId);
					notifications.trigger("success", "Card was removed successfully");
				}
			}
		);
	},

	getNext: function() {
		var _this = this;
		ajax(
			this.urls.next,
			{page: pager.getCurrentPage(), count: 1},
			function(data) {
				if (data) {
					_this.add(data);
				}
			}
		);
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
		this.listenTo(Dispatcher, 'UserCard:Removed:' + this.model.get('id'), this.remove);
		this.listenTo(this.model, 'remove', this.remove);
	},

	remove: function() {
		this.$el.remove();
	},

	render: function() {
		this.$el.append("<td>" + this.model.get('name') + "</td>");
		this.$el.append("<td>" + this.model.get('point') + "</td>");
		this.$el.append("<td>" + this.model.get('added_timestamp') + "</td>");
		this.$el.append("<td><a href='#' class='btn btn-danger remove'>Remove</a></td>");
	},

	removeCard: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('UserCard:RemoveClick', this.model.get('id'));
	}
});

var UserCardsViewClass = Backbone.View.extend({
	tagName: "table",
	className: "user-cards",
	cards: [],
	maxCountCards: 0,

	initialize: function() {
		var collection = this.model;
		this.$el.find('tr.user-card').each(function() {
			$this = $(this);
			var card = new UserCard({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				added_timestamp: $this.find('.added-timestamp').text()
			});
			collection.add(card);
			new UserCardView({el: this, model: card});

		});
		this.maxCountCards = pager.getOnPage();
		this.listenTo(this.model, 'add', this.addCard);
	},

	addCard: function(model, collection, options) {
		var userCard = new UserCardView({model: model});
		userCard.render();
		if (options.prepend) {
			this.$el.find('tbody').prepend(userCard.el);
		} else {
			this.$el.find('tbody').append(userCard.el);
		}

		while (this.model.length > this.maxCountCards) {
			var cardId = this.$el.find(".user-card:last").attr("data-id");
			this.model.remove(cardId);
		}
	}
});

$(function() {
	UserCards = new UserCardsCollection;
	UserCardsView = new UserCardsViewClass({el: "table.user-cards", model: UserCards});
});
