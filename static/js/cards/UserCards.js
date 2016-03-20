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
		this.listenTo(Dispatcher, 'QuickAdd:Card', this.addCard);
	},

	addCard: function(cardId) {
		var _this = this;
		ajax(
			this.urls.add,
			{id: cardId},
			function(data) {
				if (data) {
					_this.add([data]);
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
					_this.remove(cardId);
					Dispatcher.trigger('UserCard:removed:' + cardId);
					notifications.trigger("success", "Card was removed successfully");
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
		this.listenTo(Dispatcher, 'UserCard:removed:' + this.model.get('id'), this.remove)
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
		var userCard = new UserCardView({model: model});
		userCard.render();
		this.$el.find('tbody').prepend(userCard.el)
	}
});

$(function() {
	UserCards = new UserCardsCollection;
	UserCardsView = new UserCardsViewClass({el: "table.user-cards", model: UserCards});
});
