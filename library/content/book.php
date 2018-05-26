<?php session_start();
if (isset($_SESSION['login'])) { ?>
<h1 id="bookPageTitle" class="display-3 mb-4">Book</h1>
<div>
    <form id="book" method="post" class="form-inline my-2 my-lg-0 text-left">
        <div class="form-group row col-12">
            <label id="authorLabel" for="author" class="control-label mr-4 col-2">Author</label>
            <input id="author" name="author" type="text" value="" placeholder="Enter author" class="form-control col-8"/>
        </div>
        <div class="form-group row col-12 mt-2">
            <label id="titleLabel" for="title" class="control-label mr-4 col-2">Title</label>
            <input id="title" name="title" type="text" value="" placeholder="Enter title" class="form-control col-8"/>
        </div>
        <div class="form-group row col-12 mt-2">
            <label id="pageLabel" for="page" class="control-label mr-4 col-2">Page</label>
            <input id="page" name="page" type="text" value="" placeholder="Enter page" class="form-control col-8"/>
        </div>

        <div class="form-group row col-12 mt-2">
            <label id="categoryLabel" for="category" class="control-label mr-4 col-2">Category</label>
            <select id="category" name="category" type="text" value="" placeholder="Enter category" class="form-control col-8"></select>
        </div>

        <div class="form-group row col-12 mt-2">
            <label id="isbnLabel" for="isbn" class="control-label mr-4 col-2">ISBN</label>
            <input id="isbn" name="isbn" type="text" value="" placeholder="Enter ISBN" class="form-control col-8"/>
        </div>

        <div class="form-group row col-12 mt-2">
            <label id="is_readLabel" for="is_read" class="control-label mr-4 col-2">Read</label>
            <input id="is_read" name="is_read" type="checkbox" value="" class="form-control col-8"/>
        </div>
        <div class="form-group row col-12 mt-lg-5">
            <button id="submit"
                    type="submit"
                    class="form-control btn btn-outline-dark my-2 my-sm-0 ml-2 btn-lg"
                    onclick="$('#mode').val('login');">
                Create
            </button>
        </div>

    </form>

</div>
    <script>
		$(document).ready(function() {
			let form = $('#book');

			console.log("HELLO");
			setTimeout(function(){
				console.log("THIS IS");
			}, 1000);
			console.log("DOG");

			get(form, "bookController.php", "retrieve", getParam('id'));

/*
			$.when(get($('#category'), "bookController.php", "categories"))
                .done(get(form, "bookController.php", "retrieve", getParam('id')));
*/

            let mode;
            if(getParam('id')) {
            	$('#bookPageTitle').html('Edit');
            	$('#submit').html('Edit');
	            mode = "edit";
            } else {
	            $('#bookPageTitle').html('Create');
	            $('#submit').html('Create');
	            mode = "create";
            }
			form.submit(function (e) {
				e.preventDefault();
				$("#book input").removeClass("is-invalid");
				bookController($(this), mode, mode === 'edit' ? getParam('id') : null);
			});
		});
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>