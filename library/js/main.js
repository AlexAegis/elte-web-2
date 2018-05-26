$(document).ready(init());

function init(removeParams = false) {
	if(removeParams) {
		removeParam();
	}
	$.ajax({
		type: "GET",
		url: window.location.pathname + '/class/sessionController.php',
		data: {
			action: 'session'
		},
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			switch (jsonResponse.result) {
				case 'logged':
					if (getParam('page') === 'book') {
						
						navigateBookPage(getParam('id'));
					} else if(getParam('page') === 'list') {
						navigateListPage({
							page: getParam('number'),
							id: getParam('id')
						});
					}  else { // default landing page on login
						navigateListPage();
					}
					break;
				case 'not logged':
					loadWelcomePage(() => {
						$('#email').focus();
					});
					break;
			}
		}
	});
	
	$(document).click(function (event) {
		let clickover = $(event.target);
		let _opened = $(".navbar-collapse").hasClass("navbar-collapse in");
		if (_opened === true && !clickover.hasClass("navbar-toggle")) {
			$("button.navbar-toggle").click();
		}
	});
}

function loadWelcomePage(callback) {
	history.pushState({},"", window.location.href);
	$('#user').load(window.location.pathname + '/content/user/login.php', callback);
	$('#navigation').html('');
	$('#content').load(window.location.pathname + '/content/welcome.php', callback);
	$('.navbar-collapse').collapse('hide');
}

function loadListPage() {
	$('#user').load(window.location.pathname + '/content/user/logout.php');
	$('#navigation').load(window.location.pathname + '/content/navigation.php', () => {
		$('#listPage').addClass('active');
	});
	$('#content').load(window.location.pathname + '/content/list.php');
	$('.navbar-collapse').collapse('hide');
}

function loadBookPage(id) {
	$('#user').load(window.location.pathname + '/content/user/logout.php');
	$('#navigation').load(window.location.pathname + '/content/navigation.php', () => {
		if(!id) {
			$('#createPage').addClass('active');
		}
	});
	$('#content').load(window.location.pathname + '/content/book.php');
	
	$('.navbar-collapse').collapse('hide');

}

function navigateBookPage(id) {
	history.pushState({},"",window.location.href);
	removeParam();
	setParam("page", "book");
	if(id != null) {
		setParam("id", id);
	}
	loadBookPage(id);
}

function navigateListPage(response) {
	history.pushState({},"",window.location.href);
	removeParam();
	setParam("page", "list");
	if(response != null) {
		if(response.page != null) {
			setParam("number", response.page);
		}
		if(response.id != null) {
			setParam("id", response.id);
		}
	}
	loadListPage();
}

function userController(data, action) {
	$.ajax({
		type: "POST",
		url: window.location.pathname + 'class/userController.php',
		data: data.serialize() + '&action=' + action,
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			switch (jsonResponse.result) {
				case 'loginSuccess':
					navigateListPage();
					break;
				case 'loginError':
					if(jsonResponse.errors.includes('invalidPassword')) {
						$('#password').addClass('is-invalid');
					}
					if(jsonResponse.errors.includes('invalidEmail')) {
						$('#email').addClass('is-invalid');
					}
					break;
				case 'registrationSuccess':
					loadWelcomePage(() => {
						$('#email').val(jsonResponse.email);
						$('#password').val(jsonResponse.password);
						$('#login').focus();
					});
					break;
				case 'registrationError':
					if(jsonResponse.errors.includes('nameAlreadyTaken')) {
						$('#registrationName').addClass('is-invalid');
					}
					if(jsonResponse.errors.includes('emailAlreadyTaken')) {
						$('#registrationEmail').addClass('is-invalid');
					}
					break;
				case 'navigateRegistration':
					$('#content').load(window.location.pathname + '/content/registration.php', () => {
						let dataArray = data.serializeArray();
						let email = dataArray.filter(e => e.name === 'email').map(e => e.value)[0];
						let regName = $('#registrationName');
						if (email.indexOf('@') > -1) {
							$('#registrationEmail').val(email);
							regName.val(email.split('@')[0]);
						} else {
							regName.val(email);
						}
						regName.focus();
						$('#registrationPassword').val(dataArray.filter(e => e.name === 'password').map(e => e.value)[0]);
					});
					break;
			}
		}
	});
}

function formController(data, controller, action, param = null, onSuccess = null) {
	$.ajax({
		type: "POST",
		url: window.location.pathname + 'class/' + controller + 'Controller.php',
		data: data.serialize() + '&action=' + action,// + (param === null ? null : ""),
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			switch (jsonResponse.result) {
				case 'createError':
					jsonResponse.errors.forEach(function(error) {
						let field = data.find('[name=' + error.field + ']');
						field.addClass('is-invalid');
						field.next().html(error.reason);
					});
					break;
				case 'createSuccess':
					if(onSuccess !== null) {
						onSuccess(jsonResponse);
					}
					break;
			}
		}
	});
}

function logout() {
	$.ajax({
		type: "POST",
		url: window.location.pathname + '/class/sessionController.php',
		data: {
			action: 'logout',
			parameter: ''
		},
		success: function(response) {
			let jsonResponse = JSON.parse(response);
			if (jsonResponse.result === 'logout') {
				init(true);
			}
		}
	});
}