var TradeIn = Backbone.Model.extend({
	id: null,
	sender_email: null,
	name: null,
	point: null,
	time_create: null
});

var TradesInCollection = Backbone.Collection.extend({
	model: TradeIn,

	urls : {
		complete: '/trades/completeTradeIn',
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'TradeIn:Complete', this.completeTrade);
	},

	completeTrade: function(tradeId) {
		ajax(
			this.urls.complete,
			{tradeId: tradeId},
			function(data) {
				if (data) {
					Dispatcher.trigger('TradeIn:Completed:' + tradeId);
					notifications.trigger("success", "Trade was successful completed");
				}
			}
		);
	}
});

var TradeInView = Backbone.View.extend({
	tagName: "tr",
	className: "want-receiving",

	events: {
		"click .complete-trade": "completeTrade",
		"click .open-debate": "openDebate",
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.listenTo(Dispatcher, 'TradeIn:Completed:' + this.model.get('id'), this.remove)
	},

	remove: function() {
		this.$el.remove();
	},

	completeTrade: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('TradeIn:Complete', this.model.get('id'));
	},

	openDebate: function(e) {
		e.preventDefault();
		e.stopPropagation();
		Dispatcher.trigger('TradeIn:OpenDebate', this.model.get('id'));
	}
});

var TradesInViewClass = Backbone.View.extend({
	tagName: "table",
	className: "receiving-cards",

	initialize: function() {
		this.$el.find('tr.receiving-card').each(function() {
			$this = $(this);
			var trade = new TradeIn({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				time_create: $this.find('.time-create').text(),
				sender_email: $this.find('.sender').text()
			});
			new TradeInView({el: this, model: trade});
		});
	}
});

$(function() {
	TradesIn = new TradesInCollection;
	TradesInView = new TradesInViewClass({el: "table.receiving-cards", model: TradesIn});
});
