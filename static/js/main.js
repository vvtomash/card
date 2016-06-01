var notifications = {};
_.extend(notifications, Backbone.Events);
$(function() {
	var notify = new Notifier({
		model: notifications, // your notification object
		wait: 2000 // the duration of notifications as milliseconds
	}).render();
	$(".main").append(notify.el);

	_.templateSettings = {
		evaluate : /\{\{([\s\S]+?)\}\}/g,
		interpolate : /\{\{=([\s\S]+?)\}\}/g,
		escape : /\{\{-([\s\S]+?)\}\}/g
	};

	$('[data-toggle="tooltip"]').tooltip();

	countdown.setFormat({
		singular: ' ms| s| m| hj| d| w| month| year| decade| century| millennium',
		plural: ' ms| s| m| h| d| w| months| years| decades| centuries| millennia',
		last: ', '
	});

	$('span.timer').each(function(index, span) {
		if(span.dataset.toend) {
			var now = new Date();
			countdown(
				new Date(now.getTime() + span.dataset.toend*1000),
				function(ts) {
					span.innerHTML = ts;
				},
				countdown.HOURS|countdown.MINUTES|countdown.SECONDS
			);
		}
	});

	$('body').popover({
		selector: '.card-data-tooltip-view',
		html: true,
		content: function () {
			console.log($('.card-data-tooltip').html());
			return $('.card-data-tooltip').html();
		},
		delay: {show: 1000, hide: 100000},
		trigger: 'hover'
	});

})

function merge(object1, object2) {
	for (var key in object2) {
		object1[key] = object2[key];
	}
	return object1;
}



