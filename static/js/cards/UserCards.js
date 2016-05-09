var UserCard = Backbone.Model.extend({
	url: '/cards/change',
	defaults: {
		id: null,
		card_id: null,
		set: null,
		name: null,
		point: null,
		foil: null,
		status: 1,
		condition: null,
		added_timestamp: null
	},

	change: function(success, error) {
		var _this = this;
		ajax(
			this.url,
			{
				id: this.get('id'),
				status: Math.abs(this.get('status') - 1)
			},
			function(data) {
				if (data.status) {
					_this.set('status', data.status);
				}
				success(data)
			}
		);
	}
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

	template: function (data) {
		var tmp = _.template($('#user-card-template').html());
		return tmp(data);
	},

	events: {
		"click .remove": "removeCard",
		"click .status": "changeStatus",
		"change .condition select": "changeCondition"
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.$el.attr('data-card-id', this.model.get('card_id'));
		this.listenTo(Dispatcher, 'UserCard:Removed:' + this.model.get('id'), this.remove);
		this.listenTo(this.model, 'remove', this.remove);
		this.listenTo(this.model, 'change:status', function() {
			this.$el.find('.status span.glyphicon').toggleClass('glyphicon-minus').toggleClass('glyphicon-ok');
			this.$el.find('.status').attr('data-value', this.model.get('status'));
		});
		this.listenTo(this.model, 'change:condition', function() {
			this.$el.find('.condition span.glyphicon').toggleClass('glyphicon-minus').toggleClass('glyphicon-ok');
			this.$el.find('.condition').attr('data-value', this.model.get('condition'));
		});
	},

	remove: function() {
		this.$el.remove();
	},

	render: function() {
		this.$el.html(this.template(this.model.attributes));
		this.$el.find('.selectpicker').selectpicker();
		return this;
	},

	removeCard: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('UserCard:RemoveClick', this.model.get('id'));
	},

	changeStatus: function(e) {
		e.preventDefault();
		e.stopPropagation();
		var newStatus = Math.abs(this.model.get('status') - 1);
		this.model.save({id: this.model.get('id'), status: newStatus}, {patch: true});
	},

	changeCondition: function(e) {
		e.preventDefault();
		e.stopPropagation();
		this.model.save({id: this.model.get('id'), condition: e.currentTarget.value}, {patch: true});
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
			var $this = $(this);
			var card = new UserCard({
				id: $this.attr('data-id'),
				card_id: $this.attr('data-card-id'),
				set: $this.find('.set').text(),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				status: $this.find('.status').attr('data-value'),
				foil: $this.find('.foil').attr('data-value'),
				condition: $this.find('.condition').val(),
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
