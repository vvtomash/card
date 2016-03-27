var Want = Backbone.Model.extend({
	id: null,
	name: null,
	point: null,
	email: null
});

var WantsCollection = Backbone.Collection.extend({
	model: Want,

	urls : {
		send: '/trades/startTrade',
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'Wants:SendWant', this.sendCard);
	},

	sendCard: function(wantId) {
		ajax(
			this.urls.send,
			{wantId: wantId},
			function(data) {
				if (data) {
					Dispatcher.trigger('Wants:WantSended:' + wantId);
					notifications.trigger("success", "Card was successful sended");
				}
			}
		);
	}
});

var WantView = Backbone.View.extend({
	tagName: "tr",
	className: "want-cards",

	events: {
		"click .send": "sendCard",
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.listenTo(Dispatcher, 'Wants:WantSended:' + this.model.get('id'), this.remove)
	},

	remove: function() {
		this.$el.remove();
	},

	sendCard: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('Wants:SendWant', this.model.get('id'));
	}
});

var WantsViewClass = Backbone.View.extend({
	tagName: "table",
	className: "want-cards",

	initialize: function() {
		this.$el.find('tr.want-card').each(function() {
			$this = $(this);
			var card = new Want({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				email: $this.find('.email').text()
			});
			new WantView({el: this, model: card});
		});
	}
});

$(function() {
	Wants = new WantsCollection;
	WantsView = new WantsViewClass({el: "table.want-cards", model: Wants});
});
