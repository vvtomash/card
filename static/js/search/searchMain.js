var UserCardManager = {

	urls : {
		card: {
			add: '/cards/add',
		},
		want: {
			add: '/cards/addWant',
		}
	},

	addCard: function(cardId) {
		this._addCard(cardId, 'card')
	},

	addWant: function(cardId) {
		this._addCard(cardId, 'want');
	},

	_addCard: function(cardId, type) {
		ajax(
			this.urls[type].add,
			{id: cardId},
			function(data) {
				if (data) {
					notifications.trigger("success", "Card succefully added");
				}
			}
		);
	}
};

var CardClass = Backbone.Model.extend({
	id: null,
	name: null,
	description: null,
	point: null
});

var CardViewClass = Backbone.View.extend({
	tagName: "div",
	className: "search-card",
	events: {
		"click .addHaves": "addHaves",
		"click .addWants": "addWants"
	},

	initialize: function () {},

	addWants: function (e) {
		UserCardManager.addWant(this.model.get('id'));
	},

	addHaves: function (e) {
		UserCardManager.addCard(this.model.get('id'));
	}
});

$(function() {
	cardViews = [];
	for (var key = 0; key < searchResult.length; key++) {
		var card = new CardClass(searchResult[key]);
		var el = $(".search-result").find("[data-id=" + card.id + "]");
		var cardView = new CardViewClass({el:el, model: card});
		cardViews.push(cardView);
	}
});