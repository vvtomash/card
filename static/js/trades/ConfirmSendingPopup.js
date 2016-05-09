var ConfirmSendingPopupClass = Backbone.View.extend({

	tagName: 'div',

	className: 'modal fade',

	viewTimeout: null,

	events: {
		'click .close, .close-btn': 'closePopup',
		'click .send': 'confirm',
	},

	callback: null,

	showPopup: function(recipient, callback) {
		console.log(recipient.get('username'));
		this.$el.find('.recipient.username').html(recipient.get('username'));
		this.$el.find('.postal .first_name').html(recipient.get('firstName'));
		this.$el.find('.postal .last_name').html(recipient.get('lastName'));
		this.$el.find('.postal .country').html(recipient.get('country'));
		this.$el.find('.postal .city').html(recipient.get('city'));
		this.$el.find('.postal .address').html(recipient.get('address'));
		this.callback = callback;
		this.$el.modal('show');
	},

	closePopup: function() {
		clearTimeout(this.viewTimeout);
	},

	confirm: function() {
		if (typeof(this.callback) ==='function') {
			this.callback();
		}
	}
});

var ConfirmSendingPopup;

$(function() {
	ConfirmSendingPopup = new ConfirmSendingPopupClass({el: '#popup-confirm-sending'});
});