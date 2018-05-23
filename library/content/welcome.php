<h1 class="display-3">Library Application</h1>
<p>This project is made for the web-developement class of ELTE.
    If it not worth maximum points I'll hang myself.
    I actually deal with crippling depression.
    Please help. This is serious.</p>
Felhasználók száma jelenleg: <span id="userCount"/>. Könyvek száma jelenleg: <span id="bookCount"></span>.
<p><a class="btn btn-outline-secondary btn-lg mt-2" href="https://github.com/AlexAegis/elte-web-2/tree/master/library" target="_blank" role="button"><i class="fab fa-github mr-1"></i>/AlexAegis &raquo;</a></p>
<script>
	$(document).ready(function () {
		get('userCount', $('#userCount'));
		get('bookCount', $('#bookCount'));
	});
</script>