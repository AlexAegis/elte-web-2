$(document).ready(init())

function init(removeParams = false) {
	console.log('asd');
}

jQuery.fn.extend({
	controller: function (controller, action, onSuccess = null, afterError = null) {
		let element = this
		let isForm = element.is('form');
		let doAjax = function(isForm) {
			$.ajax({
				type: 'POST',
				url: './' + controller + 'Controller.php',
				data: (isForm ? element.serialize() + '&' : 'value=' + element.val() + '&') + 'action=' + action,
				success: function (response) {
					let jsonResponse = JSON.parse(response)
					switch (jsonResponse.result) {
						case 'error':
							if (afterError != null) {
								afterError(jsonResponse)
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
	set: function (controller = 'session', action, parameter = null, modifyJson = null, callback = null, elementCallback = null) {
		let element = this;
		return $.ajax({
			type: 'GET',
			url: './' + controller + 'Controller.php',
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
							if (elementCallback != null) {
								elementCallback(input)
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
				} else if (element.is('table')) {
					let thead = $('<thead>')
					if(jsonResponse.headerClass) {
						thead.addClass(jsonResponse.headerClass)
					}
					jsonResponse.header.forEach(e => {
						let th = $('<th>')
						th.html(e)
						thead.append(th)
					});
					element.append(thead)

					let tbody = $('<tbody>')
					jsonResponse.body.forEach(e => {						
						if (elementCallback != null) {
							tbody.append(elementCallback(e))
						}
					});
					element.append(tbody)
				} else if(element.is('div') && element.hasClass('terkep')) {
					for(var i in jsonResponse.agents) {
						element.append('<span data-id="' + jsonResponse.agents[i].id + '" style="transform: translate(' + jsonResponse.agents[i].hosszusag + 'px,' + jsonResponse.agents[i].szelesseg + 'px)"></span>')
					}
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
