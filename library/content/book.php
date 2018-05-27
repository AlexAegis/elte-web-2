<?php session_start();
if (isset($_SESSION['login'])) { ?>
    <h1 id="bookPageTitle" class="display-3 mb-4">Book</h1>
    <div>
        <form id="book" method="post" class="form-inline my-2 my-lg-0 text-left">
            <input id="id" name="id" class="hidden">
            <div class="form-group row col-12">
                <label id="authorLabel" for="author" class="control-label mr-4 col-2">Author</label>
                <input id="author" name="author" type="text" value="" placeholder="Enter author"
                       class="form-control col-6"/>
                <label id="authorError" class="error mdl-color-text--red ml-1 col-2"></label>
            </div>
            <div class="form-group row col-12 mt-2">
                <label id="titleLabel" for="title" class="control-label mr-4 col-2">Title</label>
                <input id="title" name="title" type="text" value="" placeholder="Enter title"
                       class="form-control col-6"/>
                <label id="titleError" class="error mdl-color-text--red ml-1 col-2"></label>
            </div>
            <div class="form-group row col-12 mt-2">
                <label id="pageLabel" for="page" class="control-label mr-4 col-2">Page</label>
                <input id="page" name="page" type="text" value="" placeholder="Enter page" class="form-control col-6"/>
                <label id="pageError" class="error mdl-color-text--red ml-1 col-2"></label>
            </div>
            <div class="form-group row col-12 mt-2">
                <label id="categoryLabel" for="category" class="control-label mr-4 col-2">Category</label>
                <select id="category" name="category" type="text" class="form-control col-6"
                        onchange="refreshCategoryEditButton()"></select>
                <button id="addCategory" type="button" class="btn btn-outline-primary ml-3" data-toggle="modal"
                        data-target="#categoryModal" formnovalidate onclick="emptyCategoryModal();"><i
                            class="fas fa-plus"></i></button>
                <button id="editCategory" type="button" class="btn btn-outline-secondary ml-3" data-toggle="modal"
                        data-target="#categoryModal" formnovalidate onclick="fillCategoryModal();"><i
                            class="far fa-edit"></i></button>
                <label id="categoryError" class="error mdl-color-text--red ml-1 col-2"></label>
            </div>
            <div class="form-group row col-12 mt-2">
                <label id="isbnLabel" for="isbn" class="control-label mr-4 col-2">ISBN</label>
                <input id="isbn" name="isbn" type="text" value="" placeholder="Enter ISBN" class="form-control col-6"/>
                <label id="isbnError" class="error mdl-color-text--red ml-1 col-2"></label>
            </div>
            <div class="form-group row col-12 mt-2 mb-lg-3">
                <label id="is_readLabel" for="is_read" class="control-label mr-4 col-2">Read</label>

                <label>
                    <input id="is_read" name="is_read" type="checkbox" value=""
                           class="form-control chk custom-checkbox col-6"/>
                    <span></span>
                </label>

                <label id="is_readError" class="error mdl-color-text--red ml-1 col-2"></label>
            </div>
            <div class="form-group row col-12 mt-5 offset-0 offset-sm-8">
                <button id="submit" type="submit" class="form-control btn btn-outline-dark btn-lg mt-5">Create</button>
            </div>

        </form>
    </div>


    <!-- Modal -->
    <form id="categoryModalForm" method="post" autocomplete="off">
        <div id="categoryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">Add category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row col-12 mt-2">
                            <input id="categoryId" name="id" class="hidden">
                            <label id="categoryLabel" for="category" class="control-label mr-4 col-2">Category</label>
                            <input id="categoryName" name="name" type="text" value="" placeholder="Enter a category"
                                   autocomplete="new-password" class="form-control col-6"/>
                            <label id="categoryError" class="error mdl-color-text--red ml-1 col-2"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" formnovalidate>Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
		$(document).ready(function () {
			let bookForm = $('#book')
			get(bookForm, 'book', 'retrieve', getParam('id'))
			$('#id').val(getParam('id'))
			if (getParam('id')) {
				$('#bookPageTitle').html('Edit')
				$('#submit').html('Edit')
			} else {
				$('#bookPageTitle').html('Create')
				$('#submit').html('Create')
			}
			bookForm.submit(function (e) {
				e.preventDefault()
				bookForm.find('input').removeClass('is-invalid')
				bookForm.find('.error').html('')
				formController($(this), 'book', 'create', function (response) {
					navigateListPage(response)
				})
			})

			let categoryForm = $('#categoryModalForm')
			categoryForm.submit(function (e) {
				e.preventDefault()
				categoryForm.find('input').removeClass('is-invalid')
				categoryForm.find('.error').html('')
				formController($(this), 'category', 'create', function (response) {
					let select = $('#category')
					$('#categoryModal').modal('hide')
					select.html('')
					get(select, 'category', 'retrieveAll', null, function () {
						select.val(response.id)
					})
				})
			})

			refreshCategoryEditButton()
		})

		function fillCategoryModal() {
			let bookFormCategory = $('#category')
			let categoryFormName = $('#categoryName')
			$('#categoryModalLabel').html('Edit Category')

			$('#categoryId').val(bookFormCategory.val())
			categoryFormName.val(bookFormCategory.find('option:selected').text())
			categoryFormName.focus()
		}

		function emptyCategoryModal() {
			$('#categoryModalLabel').html('Create Category')
			$('#categoryId').val('')
			$('#categoryName').val('')
		}

		function refreshCategoryEditButton() {
			if ($('#category').val() === null || $('#category').val() === '') {
				$('#editCategory').addClass('hidden')
			} else {
				$('#editCategory').removeClass('hidden')
			}
		}
    </script>
<?php } else { ?>
    <p>Please log in to access this feature!</p>
<?php } ?>