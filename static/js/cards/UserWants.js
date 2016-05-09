var UserWant = Backbone.Model.extend({
    url: '/cards/changeWant',
	STATUS_ON: 'active',
	STATUS_OFF: 'blocked',
	defaults: {
		id: null,
		set: null,
		name: null,
		point: null,
		status: null,
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
		"click .status": "changeStatus",
	},

	template: function (data) {
		var tmp = _.template($('#user-want-template').html());
		return tmp(data);
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.listenTo(Dispatcher, 'UserWant:Removed:' + this.model.get('id'), this.remove);
		this.listenTo(this.model, 'remove', this.remove);
        this.listenTo(this.model, 'change:status', function() {
            this.$el.find('.status span.glyphicon').toggleClass('glyphicon-minus').toggleClass('glyphicon-ok');
            this.$el.find('.status').attr('data-value', this.model.get('status'));
        });
	},

	remove: function() {
		this.$el.remove();
	},

	render: function() {
		this.$el.html(this.template(this.model.attributes));
		return this;
	},

	removeWant: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('UserWant:RemoveClick', this.model.get('id'));
	},

	changeStatus: function(e) {
		e.preventDefault();
		e.stopPropagation();
        var newStatus = this.model.STATUS_OFF;
		if (this.model.get('status') === this.model.STATUS_OFF) {
            newStatus = this.model.STATUS_ON;
        }
		this.model.save({id: this.model.get('id'), status: newStatus}, {patch: true});
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
				status: $this.find('.status').attr('data-value'),
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
