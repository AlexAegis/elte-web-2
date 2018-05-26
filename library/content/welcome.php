<h1 class="display-3 mb-4">Library Application</h1>
<p>This project is made for the web-developement class of ELTE.
    This project is fully implemented through ajax calls and uses php solely as a backend API and as a
    security guard to refuse printing content if there's no authorised user logged in, even if he loads the page by
    force.
    The database level is accessed through RedBeans ORM.
    The responsivity is Bootstraps responsibility.</p>
Number of users: <span id="userCount"></span>. Number of books in total: <span id="bookCount"></span>.
<p><a class="btn btn-outline-secondary btn-lg mt-5" href="https://github.com/AlexAegis/elte-web-2/tree/master/library"
      target="_blank" role="button"><i class="fab fa-github mr-1"></i>/AlexAegis &raquo;</a></p>
<script>
	$(document).ready(function () {
		get($('#userCount'), 'session', 'count', 'user')
		get($('#bookCount'), 'session', 'count', 'book')
	})
</script>