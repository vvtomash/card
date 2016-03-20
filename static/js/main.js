var notifications = {};
_.extend(notifications, Backbone.Events);
$(function() {
	var notify = new Notifier({
		model: notifications, // your notification object
		wait: 2000 // the duration of notifications as milliseconds
	}).render();
	$(".main").append(notify.el);
})