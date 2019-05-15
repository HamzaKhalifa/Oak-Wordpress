handleSearchInputs();
function handleSearchInputs() {
    var searchElements = document.querySelectorAll('.oak_post_search_input');
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

handleSelectedElementsContainers();
function handleSelectedElementsContainers() {
    var singleElementContainerView = '';
    var singleElementContainer = document.querySelector('.oak_post_elements_selector_selected_elements__single_element');
    singleElementContainerView = singleElementContainer.innerHTML;
    singleElementContainer.remove();

    handleSelectListeners();
    function handleSelectListeners() {
        var allSelects = document.querySelectorAll('.oak_post_selector');
        for(var i = 0; i < allSelects.length; i++) {
            allSelects[i].id = 'oak_post_selector_' + i;
            updateSelectedElementsContainer(allSelects[i]);
            allSelects[i].addEventListener('change', function() {
                updateSelectedElementsContainer(this);
            });
        }
    }

    function updateSelectedElementsContainer(select) {
        var options = select.querySelectorAll('option');
        var selectedElementsContainer = select.parentNode.parentNode.querySelector('.oak_post_elements_selector__selected_elements');
        selectedElementsContainer.innerHTML = '';

        var selectedValues = jQuery('#' + select.id).val();
        for (var i = 0; i < selectedValues.length; i++) {
            var foundOption = false;
            var incrementer = 0;
            do {
                if (options[incrementer].value == selectedValues[i]) {
                    foundOption = true;
                    // Now adding to the selected elements container: 
                    var singleElementContainer = document.createElement('div');
                    singleElementContainer.className = 'oak_post_elements_selector_selected_elements__single_element';
                    singleElementContainer.innerHTML = singleElementContainerView;

                    selectedElementsContainer.append(singleElementContainer);

                    singleElementContainer.querySelector('.oak_post_elements_selector_selected_elements_single_element__element_name').innerHTML = options[incrementer].innerHTML;
                    singleElementContainer.id = selectedValues[i];

                    handleRemoveButton(select, singleElementContainer);
                }
                incrementer++;
            } while(!foundOption && incrementer < options.length);
        }
    }

    function handleRemoveButton(select, singleElementContainer) {
        var theButton = singleElementContainer.querySelector('.oak_post_elements_selector_selected_elements_single_element_element_remove_button');
        theButton.setAttribute('selectId', select.id);
        theButton.setAttribute('optionId', singleElementContainer.id);
        theButton.addEventListener('click', function() {
            this.parentNode.remove();
            var options = document.querySelector('#' + this.getAttribute('selectId')).querySelectorAll('option');
            for (var i = 0; i < options.length; i++) {
                if (options[i].value == this.getAttribute('optionId')) {
                    options[i].selected = false;
                }
            }
        })
    }
}