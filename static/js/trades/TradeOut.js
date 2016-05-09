var TradeOut = Backbone.Model.extend({
	id: null,
	recipient_email: null,
	name: null,
	point: null,
	time_create: null
});

var TradesOutCollection = Backbone.Collection.extend({
	model: TradeOut,

	urls : {
		confirm: '/trades/confirmSending',
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'Trade:Confirm', this.confirmSending);
	},

	confirmSending: function(tradeId) {
		ajax(
			this.urls.confirm,
			{tradeId: tradeId},
			function(data) {
				if (data) {
					Dispatcher.trigger('Trade:ConfirmedSending:' + tradeId);
					notifications.trigger("success", "Sending was successful confirm");
				}
			}
		);
	}
});

var TradeOutView = Backbone.View.extend({
	tagName: "tr",
	className: "sending-card",

	events: {
		"click .confirm-sending": "confirmSending"
	},

	initialize: function() {
		this.$el.attr('data-id', this.model.get('id'));
		this.listenTo(Dispatcher, 'Trade:ConfirmedSending:' + this.model.get('id'), function() {
			this.$el.find('.confirm-sending').remove();
		}.bind(this))
	},

	confirmSending: function(e) {
		e.preventDefault();
		e.stopPropagation();
		console.log(e);
		Dispatcher.trigger('Trade:Confirm', this.model.get('id'));
	}
});

var TradesOutViewClass = Backbone.View.extend({
	tagName: "table",
	className: "sending-cards",

	initialize: function() {
		this.$el.find('tr.sending-card').each(function() {
			$this = $(this);
			var trade = new TradeOut({
				id: $this.attr('data-id'),
				name: $this.find('.name').text(),
				point: $this.find('.point').text(),
				time_create: $this.find('.time-create').text(),
				recipient_email: $this.find('.recipient').text()
			});
			new TradeOutView({el: this, model: trade});
		});
	}
});

$(function() {
	var TradesOut = new TradesOutCollection;
	var TradesOutView = new TradesOutViewClass({el: "table.sending-cards", model: TradesOut});
});
