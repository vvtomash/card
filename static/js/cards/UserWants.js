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
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'UserWant:RemoveClick', this.removeWant);
		this.listenTo(Dispatcher, 'QuickAdd:Card', this.addWant);
	},

	addWant: function(cardId) {
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

	removeWant: function(cardId) {
		var _this = this;
		ajax(
			this.urls.remove,
			{id: cardId},
			function(data) {
				if (data) {
					_this.remove(cardId);
					Dispatcher.trigger('UserWant:Removed:' + cardId);
					notifications.trigger("success", "Card removed added successfully");
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
		this.listenTo(Dispatcher, 'UserWant:Removed:' + this.model.get('id'), this.remove)
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
		this.listenTo(this.model, 'add', this.addWant);
		this.$el.find('tr.user-want').each(function() {
			$this = $(this);
			var want = new UserWant({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				added_timestamp: $this.find('.added-timestamp').text()
			});
			new UserWantView({el: this, model: want});
		});
	},

	addWant: function(model) {
		var userWant = new UserWantView({model: model});
		userWant.render();
		this.$el.find('tbody').prepend(userWant.el);
	}
});

$(function() {
	UserWants = new UserWantsCollection;
	UserWantsView = new UserWantsViewClass({el: "table.user-wants", model: UserWants});
});
