var Recipient = Backbone.Model.extend({
	url: function() {
		return '/profile/user/' + this.get('id')
	},

	defaults: {
		id: null,
		username: null,
		firstName: null,
		lastName: null,
		country: null,
		city: null,
		address: null
	},

	parse: function(response) {
		this.set('username', response.data.username);
		this.set('firstName', response.data.first_name)
		this.set('lastName', response.data.last_name)
		this.set('country', response.data.country)
		this.set('city', response.data.city)
		this.set('address', response.data.address)
	}
});

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
					window.location.reload();
				}
			}
		);
	}
});

var WantView = Backbone.View.extend({
	tagName: "tr",
	className: "want-cards",

	events: {
		"click .send .btn": "sendCard",
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
		var recipientId = e.currentTarget.dataset.recipientId;
		var recipient = new Recipient({id: recipientId});
		recipient.fetch({
			success: function(recipient) {
				ConfirmSendingPopup.showPopup(recipient,
					function() {
						Dispatcher.trigger('Wants:SendWant', this.model.get('id'));
					}.bind(this)
				);
			}.bind(this)
		});
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
