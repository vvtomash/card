var UserWant = Backbone.Model.extend({
	id: null,
	name: null,
	point: null,
	added_timestamp: null
});

var UserWantsCollection = Backbone.Collection.extend({
	model: UserWant,

	urls : {
		remove: '/cards/removeWant',
		add: '/cards/addWant',
		next: '/cards/nextWants',
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'UserWant:RemoveClick', this.removeWant);
		this.listenTo(Dispatcher, 'QuickAdd:Card', this.addWant);
		this.listenTo(Dispatcher, 'UserWant:Removed', this.getNext);
	},

	addWant: function(cardId) {
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

	removeWant: function(cardId) {
		var _this = this;
		ajax(
			this.urls.remove,
			{id: cardId},
			function(data) {
				if (data) {
					_this.remove(cardId);
					Dispatcher.trigger('UserWant:Removed');
					Dispatcher.trigger('UserWant:Removed:' + cardId);
					notifications.trigger("success", "Card removed added successfully");
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

var UserWantView = Backbone.View.extend({
	tagName: "tr",
	className: "user-want",

	events: {
		"click .remove": "removeWant",
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.listenTo(Dispatcher, 'UserWant:Removed:' + this.model.get('id'), this.remove);
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

	removeWant: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('UserWant:RemoveClick', this.model.get('id'));
	}
});

var UserWantsViewClass = Backbone.View.extend({
	tagName: "table",
	className: "user-wants",
	cards: [],

	initialize: function() {
		var collection = this.model;
		this.$el.find('tr.user-want').each(function() {
			$this = $(this);
			var want = new UserWant({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				added_timestamp: $this.find('.added-timestamp').text()
			});
			collection.add(want);
			new UserWantView({el: this, model: want});
		});
		this.maxCountCards = pager.getOnPage();
		this.listenTo(this.model, 'add', this.addWant);
	},

	addWant: function(model, collection, options) {
		var userWant = new UserWantView({model: model});
		userWant.render();
		if (options.prepend) {
			this.$el.find('tbody').prepend(userWant.el);
		} else {
			this.$el.find('tbody').append(userWant.el);
		}

		while (this.model.length > this.maxCountCards) {
			var cardId = this.$el.find(".user-want:last").attr("data-id");
			this.model.remove(cardId);
		}
	}
});

$(function() {
	UserWants = new UserWantsCollection;
	UserWantsView = new UserWantsViewClass({el: "table.user-wants", model: UserWants});
});
