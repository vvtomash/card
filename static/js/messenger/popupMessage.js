var PopupMessageClass = Backbone.View.extend({

	tagName: 'div',

	className: 'modal fade',

	viewTimeout: null,

	events: {
		'click .close, .close-btn': 'closePopup',
	},

	showPopup: function(message) {
		this.$el.find('.from').html(message.get('from'));
		this.$el.find('.subject').html(message.get('subject'));
		this.$el.find('.body').html(message.get('body'));
		this.$el.modal('show');
		if (message.get('status') === 'new') {
			this.viewTimeout = setTimeout(function() {
				Dispatcher.trigger('Message:Read', message);
			}, 1500);
		}
	},

	closePopup: function() {
		clearTimeout(this.viewTimeout);
	}
});

var MessagePopup;

$(function() {
	MessagePopup = new PopupMessageClass({el: '#popup-message'});
})