var PagerClass = Backbone.View.extend({
	className: "pager",
	tagName: "div",
	events: {
		"keypress .current-page": "onEnter",
		"change .current-page": "onChange"
	},

	initialize: function() {
		this.$currentPage = this.$el.find("input.current-page");
		this.url = this.$el.attr("data-url");
	},

	onEnter: function(e) {
		if (e.which === 13) {
			window.location.href = this.getPageUrl(e.currentTarget.value);
		}
	},

	getPageUrl: function(page) {
		return (this.url + "/page-" + page).replace('//', '/')
	},

	getCurrentPage: function() {
		return this.$currentPage.val();
	},

	getOnPage: function() {
		return this.$el.attr("data-onPage");
	}

});
var pager;
$(function() {
	pager = new PagerClass({el: "div.pager"});
});


