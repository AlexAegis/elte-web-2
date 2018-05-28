$(document).ready(init())

function init(removeParams = false) {

}

jQuery.fn.extend({
	controller: function (controller, action, onSuccess = null, afterError = null) {
		let element = this
		let isForm = element.is('form');
		let doAjax = function(isForm) {
			$.ajax({
				type: 'POST',
				url: window.location.pathname + 'class/' + controller + 'Controller.php',
				data: (isForm ? element.serialize() + '&' : 'value=' + element.val() + '&') + 'action=' + action,
				success: function (response) {
					let jsonResponse = JSON.parse(response)
					switch (jsonResponse.result) {
						case 'error':
							if(isForm) {
								element.find('input').each(function () {
									$(this).removeClass('is-invalid')
									$(this).next().html('')
								})
								console.log(jsonResponse.errors)
								jsonResponse.errors.forEach(function (error) {
									element.find('[name=' + error.field + ']').each(function () {
										$(this).addClass('is-invalid')
										$(this).next().append(error.reason + '<br/>')
									})
								})
							} else {
								element.removeClass('is-invalid')
								element.next().html('')
								jsonResponse.errors.forEach(function (error) {
									element.addClass('is-invalid')
									element.next().append(error.reason + '<br/>')
								})
							}
							
							if (afterError != null) {
								afterError()
							}
							break
						case 'success':
							if (onSuccess !== null) {
								onSuccess(jsonResponse)
							}
							break
					}
				}
			})
		}
		if(isForm) {
			element.submit(function (e) {
				e.preventDefault()
				doAjax(isForm);
			})
		} else {
			doAjax(isForm);
		}
	},
	set: function (controller = 'session', action, parameter = null, modifyJson = null, callback = null, selectCallback = null) {
		let element = this;
		return $.ajax({
			type: 'GET',
			url: window.location.pathname + '/class/' + controller + 'Controller.php',
			data: {
				action: action,
				parameter: parameter
			},
			success: function (response) {
				let jsonResponse = JSON.parse(response)
				if (modifyJson !== null) {
					jsonResponse.result = modifyJson(jsonResponse)
				}
				if (element.is('form')) {
					element.find(':input:not(:checkbox):not(:button)').each(function () {
						let input = $(this)
						input.val(jsonResponse[input.attr('name')])
					})
					element.find('select').each(function () {
						let input = $(this)
						input.html('');
						input.set(input.attr('name'), 'retrieveAll', null, null, function () {
							input.val(jsonResponse[input.attr('name')])
							if (selectCallback != null) {
								selectCallback(input)
							}
						})
					})
					element.find(':input:checkbox').each(function () {
						let input = $(this)
						if (jsonResponse[input.attr('name')] === '1') {
							input.prop('checked', true)
						}
					})
				} else if (element.is('select')) {
					element.append('<option value=""></option>') // noselectoption
					jsonResponse.options.forEach(function (option) {
						element.append('<option value=' + option.id + '>' + option.name + '</option>')
					})
				} else {
					element.html(jsonResponse.result)
				}
				if (callback != null) {
					callback(jsonResponse)
				}
			}
		})
	}
})
