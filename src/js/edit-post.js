handleSearchInputs();
function handleSearchInputs() {
    var quantisSearchInput = document.querySelector('.oak_post_quantis_selector_search_input');

    var goodPracticeInput = document.querySelector('.oak_post_goodpractices_selector_search_input');

    var objectsInput = document.querySelector('.oak_post_objects_selector_search_input');

    var sourcesInput = document.querySelector('.oak_post_objects_selector_search_input');
    
    var searchElements = [quantisSearchInput, goodPracticeInput, objectsInput, sourcesInput];
    for (var i = 0; i < searchElements.length; i++) {
        searchElements[i].oninput = function() {
            search(this);
        }
    }
}

function search(element) {
    var options = element.parentNode.querySelectorAll('option');
    for (var i = 0; i < options.length; i++) {
        if (options[i].innerHTML.toLowerCase().indexOf(element.value.toLowerCase()) != -1) {
            options[i].classList.remove('oak_hidden');
        } else {
            options[i].classList.add('oak_hidden');
        }
    }
}