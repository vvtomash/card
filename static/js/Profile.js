var ProfileModelClass = Backbone.Model.extend({

	url: '/profile/update',

	rules: {
		phone: {
			regexp: [
				/\+\d{3}\(\d{2}\)\d{3}-\d{2}-\d{2}/, "Телефон в международном формате +000(00)000-00-00."
			]
		}
	},

	defaults: {
		id: 0,
		user_id: 0,
		first_name: "",
		last_name: "",
		country: "",
		city: "",
		phone: "",
		address: "",
		zip_code: ""
	},

	validate: function(attributes) {
		var errors = [], validate = true;
		for (var key in attributes) {
			if (this.rules && this.rules[key]){
				var validationErrors = this.validateField(attributes[key], this.rules[key]);
				if (validationErrors) {
					validate = false;
					errors[key] = validationErrors;
				}
			}
		}
		if (!validate) {
			return errors;
		}
	},

	validateField: function(value, rules) {
		var errors = [];
		for (var key in rules) {
			var error;
			switch (key) {
				case 'regexp': {
					if (value && !(new RegExp(rules[key][0])).test(value)) {
						error = rules[key][1];
					}
				} break;
				case 'callback': {
					error = rules[key](value)
				} break;
			}
			error && errors.push(error);
		}
		if (errors.length > 0) {
			return errors;
		}

	},

	handleSaveErrors: function(model, xhr) {
		var response = xhr.responseJSON;
		for (var key in response.errors) {
			var error = response.errors[key];
			if (error.type === "validation") {
				model.trigger("invalid", model, error.messages);
			} else {
				notifications.trigger("error", error);
			}
		}

	}
});

var ProfileViewClass = Backbone.View.extend({

	tagName: "form",
	className: "form-profile",

	events: {
		"change input": "onChange",
		"submit": "onSubmit"
	},

	initialize: function() {
		this.listenTo(this.model, "invalid", this.showError);
		var model = this.model;
		this.$el.find("input").each(function() {
			model.set(this.name, this.value);
		});
	},

	onChange: function(e) {
		var input = e.currentTarget;
		$(input).removeClass("alert-danger");
		this.model.set(input.name, input.value, {validate:true});
	},

	showError: function(model, error) {
		this.$el.find("input").each(function() {
			if (error[this.name]) {
				$(this).addClass("alert-danger");
			}
		});
		notifications.trigger("error", "Validation error")
	},

	onSubmit: function(e) {
		e.preventDefault();
		e.stopPropagation();
		this.model.save([], {error: this.model.handleSaveErrors});
	}
});

$(function() {
	var Profile = new ProfileModelClass;
	var ProfileView = new ProfileViewClass({el: $.find("form.form-profile"), model:Profile});
})