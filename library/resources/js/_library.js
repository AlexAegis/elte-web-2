$(document).ready(init())

function init(removeParams = false) {
	if (removeParams) {
		removeParam()
	}
	$.ajax({
		type: 'GET',
		url: window.location.pathname + '/class/sessionController.php',
		data: {
			action: 'session'
		},
		success: function (response) {
			let jsonResponse = JSON.parse(response)
			switch (jsonResponse.result) {
				case 'logged':
					if (getParam('page') === 'book') {
						
						navigateBookPage(getParam('id'))
					} else if (getParam('page') === 'list') {
						navigateListPage({
							page: getParam('number'),
							id: getParam('id')
						})
					} else { // default landing page on login
						navigateListPage()
					}
					break
				case 'not logged':
					loadWelcomePage(() => {
						$('#email').focus()
					})
					break
			}
		}
	})
	$(document).click(function (event) {
		let clickover = $(event.target)
		let _opened = $('.navbar-collapse').hasClass('navbar-collapse in')
		if (_opened === true && !clickover.hasClass('navbar-toggle')) {
			$('button.navbar-toggle').click()
		}
	})
}

function loadWelcomePage(callback) {
	history.pushState({}, '', window.location.href)
	$('#user').load(window.location.pathname + '/content/user/login.php', callback)
	$('#navigation').html('')
	$('#content').load(window.location.pathname + '/content/welcome.php', callback)
	$('.navbar-collapse').collapse('hide')
}

function loadListPage() {
	$('#user').load(window.location.pathname + '/content/user/logout.php')
	$('#navigation').load(window.location.pathname + '/content/navigation.php', () => {
		$('#listPage').addClass('active')
	})
	$('#content').load(window.location.pathname + '/content/list.php')
	$('.navbar-collapse').collapse('hide')
}

function loadBookPage(id) {
	$('#user').load(window.location.pathname + '/content/user/logout.php')
	$('#navigation').load(window.location.pathname + '/content/navigation.php', () => {
		if (!id) {
			$('#createPage').addClass('active')
		}
	})
	$('#content').load(window.location.pathname + '/content/book.php')
	
	$('.navbar-collapse').collapse('hide')
	
}

function navigateBookPage(id) {
	history.pushState({}, '', window.location.href)
	removeParam()
	setParam('page', 'book')
	if (id != null) {
		setParam('id', id)
	}
	loadBookPage(id)
}

function navigateListPage(response) {
	history.pushState({}, '', window.location.href)
	removeParam()
	setParam('page', 'list')
	if (response != null) {
		if (response.page != null) {
			setParam('number', response.page)
		}
		if (response.id != null) {
			setParam('id', response.id)
		}
	}
	loadListPage()
}

function navigateRegistration() {
	history.pushState({}, '', window.location.href)
	removeParam()
	$('#content').load(window.location.pathname + '/content/registration.php', () => {
		let email = $('#email').val()
		let regName = $('#registrationName')
		if (email.indexOf('@') > -1) {
			$('#registrationEmail').val(email)
			regName.val(email.split('@')[0])
		} else {
			regName.val(email)
		}
		regName.focus()
		let pass = $('#password').val()
		$('#registrationPassword').val(pass)
	})
	$('.navbar-collapse').collapse('hide')
}

jQuery.fn.extend({
	controller: function (controller, action, onSuccess = null) {
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
								jsonResponse.errors.forEach(function (error) {
									let field = element.find('[name=' + error.field + ']')
									field.addClass('is-invalid')
									field.next().append(error.reason + '<br/>')
								})
							} else {
								console.log('unim error')
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
				element.find('input').removeClass('is-invalid')
				element.find('.error').html('')
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


function removeBook(id) {
	$('').controller('book', 'remove&id=' + id, function(response) {
		navigateListPage(response);
	})
}


function logout() {
	$.ajax({
		type: 'POST',
		url: window.location.pathname + '/class/sessionController.php',
		data: {
			action: 'logout',
			parameter: ''
		},
		success: function (response) {
			let jsonResponse = JSON.parse(response)
			if (jsonResponse.result === 'logout') {
				init(true)
			}
		}
	})
}