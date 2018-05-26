function setParam(param, val) {
	window.history.replaceState('', '', updateURLParameter(window.location.href, param, val))
}

function getParam(param) {
	return getUrlParameter(param)
}

function removeParam(param) {
	window.history.replaceState('', '', removeURLParameter(window.location.href, param))
}

function removeParam() {
	window.history.replaceState('', '', window.location.href.split('?')[0])
}

function removeURLParameter(url, parameter) {
	let urlParts = url.split('?')
	if (urlParts.length >= 2) {
		
		let prefix = encodeURIComponent(parameter) + '='
		let pars = urlParts[1].split(/[&;]/g)
		
		for (let i = pars.length; i-- > 0;) {
			if (pars[i].lastIndexOf(prefix, 0) !== -1) {
				pars.splice(i, 1)
			}
		}
		url = urlParts[0] + (pars.length > 0 ? '?' + pars.join('&') : '')
		return url
	} else {
		return url
	}
}

function updateURLParameter(url, param, paramVal) {
	let TheAnchor = null
	let newAdditionalURL = ''
	let tempArray = url.split('?')
	let baseURL = tempArray[0]
	let additionalURL = tempArray[1]
	let temp = ''
	
	if (additionalURL) {
		let tmpAnchor = additionalURL.split('#')
		let TheParams = tmpAnchor[0]
		TheAnchor = tmpAnchor[1]
		if (TheAnchor)
			additionalURL = TheParams
		
		tempArray = additionalURL.split('&')
		
		for (let i = 0; i < tempArray.length; i++) {
			if (tempArray[i].split('=')[0] != param) {
				newAdditionalURL += temp + tempArray[i]
				temp = '&'
			}
		}
	}
	else {
		let tmpAnchor = baseURL.split('#')
		let TheParams = tmpAnchor[0]
		TheAnchor = tmpAnchor[1]
		
		if (TheParams)
			baseURL = TheParams
	}
	
	if (TheAnchor)
		paramVal += '#' + TheAnchor
	
	let rows_txt = temp + '' + param + '=' + paramVal
	return baseURL + '?' + newAdditionalURL + rows_txt
}

function getUrlParameter(sParam) {
	let sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i
	
	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=')
		
		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1]
		}
	}
}

function get(element, controller = 'session', action, parameter = null, modifyJson = null, callback = null) {
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
					get(input, input.attr('name'), 'retrieveAll', null, null, function () {
						input.val(jsonResponse[input.attr('name')])
					})
				})
				element.find(':input:checkbox').each(function () {
					let input = $(this)
					if (jsonResponse[input.attr('name')] === '1') {
						input.prop('checked', true)
					}
				})
			} else if (element.is('select')) {
				jsonResponse.options.forEach(function (option) {
					element.append('<option value=' + option.id + '>' + option.name + '</option>')
				})
			} else {
				element.html(jsonResponse.result)
			}
			if (callback != null) {
				callback()
			}
		}
	})
}