var UserMessage = Backbone.Model.extend({
	defaults: {
		id: 0,
		from: '',
		subject: '',
		body: '',
		added_timestamp: '',
		status: ''
	}
});

var MessagesListCollection = Backbone.Collection.extend({
	model: UserMessage,

	urls: {
		remove: '/inbox/removeMessage',
		read: '/inbox/readMessage',
		next: '/inbox/nextMessage'
	},

	initialize: function() {
		this.listenTo(Dispatcher, 'Message:Read', this.markAsRead);
	},

	removeMessage: function(id, onSuccess, onError) {
		var _this = this;
		ajax(
			this.urls.remove,
			{id: id},
			function() {
				_this.remove(id);
				_this.nextMessage();
				onSuccess()
			},
			onError
		);
	},

	nextMessage: function() {
		var _this = this;
		ajax(
			this.urls.next,
			{count: 1},
			function(data) {
				for (var key in data) {
					var message = data[key];
					_this.add({
						id: message.id,
						from: message.author.username,
						subject: message.subject,
						body: message.body,
						added_timestamp: message.added_timestamp,
						status: message.status
					});
				}

			}
		);
	},

	markAsRead: function(message) {
		ajax(
			this.urls.read,
			{id: message.get('id')},
			function(data) {
				message.set('status', 'read');
			}
		);
	}
});

var InboxView = Backbone.View.extend({

	className: 'table',

	tagName: 'inbox',

	events: {
		'click .remove': 'onRemoveClick',
		'click tr': 'showMessage',
	},

	initialize: function() {
		var inbox = this;
		this.$el.find('tr.user-message').each(function() {
			$messageEl = $(this);
			var message = new UserMessage({
				id: $messageEl.attr('data-id'),
				from: $messageEl.find('td.from').text(),
				subject: $messageEl.find('td.subject').text(),
				body: $messageEl.find('td.body').text(),
				added_timestamp: $messageEl.find('td.added-timestamp').text(),
				status: $messageEl.attr('data-status')
			});
			inbox.model.add(message);
		});
		this.listenTo(this.model, 'add', this.renderMessage);
		this.listenTo(this.model, 'remove', this.removeMessage);
		this.listenTo(Dispatcher, 'Message:Read', this.markAsRead);
	},

	onRemoveClick: function(e) {
		e.preventDefault();
		e.stopPropagation();
		var $message = $(e.currentTarget).parent('tr');
		this.model.removeMessage(
			$message.attr('data-id'),
			function() {
				notifications.trigger("success", "Message was removed");
			}
		);
	},

	renderMessage: function(message) {
		var $message = $('<tr>');
		$message.attr('data-id', message.get('id'));
		$message.attr('data-status', message.get('status'));
		if (message.get('status') === 'new') {
			$message.addClass('new-message');
		}
		$message.append($('<td>').addClass('from').html(message.get('from')));
		$message.append($('<td>').addClass('subject').html(message.get('subject')));
		$message.append($('<td>').addClass('body').html(message.get('body').substr(0, 50)));
		$message.append($('<td>').addClass('added-timestamp').html(message.get('added_timestamp')));
		$message.append(
			$('<td>').addClass('remove').
				html('<a type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>')
		);
		this.$el.append($message);
	},

	removeMessage: function(model) {
		this.$el.find('tr[data-id='+model.get('id')+']').remove();
	},

	showMessage: function(e) {
		var messageId = $(e.currentTarget).attr('data-id');
		MessagePopup.showPopup(this.model.get(messageId));
	},

	markAsRead: function(message) {
		this.$el.find('tr[data-id='+message.get('id')+']').removeClass('new-message');
	}
});

$(function() {
	var Inbox = new InboxView({model: new MessagesListCollection, el: "table.inbox"});
});