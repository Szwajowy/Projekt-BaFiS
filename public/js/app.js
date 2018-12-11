var $genreCollectionHolder;

var $addNewItem = $('<a href="#" class="btn btn-info">Dodaj</a>');

$(document).ready(function () {
    $genreCollectionHolder = $('#genre_list');

    $genreCollectionHolder.append($addNewItem);

    $genreCollectionHolder.data('index', $genreCollectionHolder.find('.genre-row').length);

    $genreCollectionHolder.find('.genre-row').each(function() {
        addRemoveButton($(this));
    });

    $addNewItem.click(function (e) {
        e.preventDefault();
        addNewForm();
    })
})

function addNewForm() {
    var prototype = $genreCollectionHolder.data('prototype');
    var index = $genreCollectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    var $panel = $('<div class="genre-row"></div>').append(newForm);

    $genreCollectionHolder.data('index', index+1);

    addRemoveButton($panel);

    $addNewItem.before($panel);
}

function addRemoveButton($panel) {
    var $removeButton = $('<a href="#" class="btn btn-danger">Usuń</a>');

    $removeButton.click(function (e) {
        e.preventDefault();
        $(e.target).parents('.genre-row').remove();
    });

    $panel.append($removeButton);
}