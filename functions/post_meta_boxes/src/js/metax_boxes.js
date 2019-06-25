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

    // Removing all single containers: 
    var allSingleContainers = document.querySelectorAll('.oak_post_elements_selector_selected_elements__single_element');
    for (var i = 0; i < allSingleContainers.length; i++) {
        allSingleContainers[i].remove();
    }

    initializeSelectElementsContainers();
    function initializeSelectElementsContainers() {
        var valueContainers = document.querySelectorAll('.oak_post_elements_selector__selected_elements_values_container');
        for (var i = 0; i < valueContainers.length; i++) {
            var valuesArray = valueContainers[i].value.split(',');
            var select = valueContainers[i].parentNode.querySelector('.oak_post_selector');
            select.id = 'oak_post_selector_' + i;
            var options = select.querySelectorAll('option');
            for (var j = 0; j < valuesArray.length; j++) {
                if (valuesArray[j] != '') {
                    for (var m = 0; m < options.length; m++) {
                        if ( options[m].value == valuesArray[j] ) {
                            addElement( valueContainers[i].parentNode.querySelector('.oak_post_elements_selector__selected_elements'), options[m], valuesArray[j] );
                        }
                    }
                }
            }
        }
    }

    function addElement(selectedElementsContainer, option, valueId) {
        var singleElementContainer = document.createElement('div');
        singleElementContainer.className = 'oak_post_elements_selector_selected_elements__single_element';
        singleElementContainer.innerHTML = singleElementContainerView;
    
        selectedElementsContainer.append(singleElementContainer);
    
        singleElementContainer.querySelector('.oak_post_elements_selector_selected_elements_single_element__element_name').innerHTML = option.innerHTML;
        singleElementContainer.id = valueId;
    
        handleRemoveButton(option.parentNode, singleElementContainer);
    };

    handleSelectListeners();
    function handleSelectListeners() {
        var allSelects = document.querySelectorAll('.oak_post_selector');
        for(var i = 0; i < allSelects.length; i++) {
            allSelects[i].id = 'oak_post_selector_' + i;
            // updateSelectedElementsContainer(allSelects[i]);
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

        var valuesContainer = select.parentNode.parentNode.querySelector('.oak_post_elements_selector__selected_elements_values_container');
        valuesContainer.value = selectedValues;

        if (!selectedValues)
            return;
            
        for (var i = 0; i < selectedValues.length; i++) {
            var foundOption = false;
            var incrementer = 0;
            do {
                if (options[incrementer].value == selectedValues[i]) {
                    foundOption = true;
                    // Now adding to the selected elements container: 
                    addElement(selectedElementsContainer, options[incrementer], selectedValues[i])
                }
                incrementer++;
            } while(!foundOption && incrementer < options.length);
        }

        setSortable();
    }

    setSortable();
    function setSortable() {
        // This is where we are gonna set the sortable:
        jQuery( function() {
            jQuery( ".oak_post_elements_selector__selected_elements" ).sortable({
                update: function(event, ui) {
                    modifyValueContainerForPostRequest(ui.item.context.parentNode.parentNode);
                }
            });
            jQuery( ".oak_post_elements_selector__selected_elements" ).disableSelection();
        } );
    }

    function modifyValueContainerForPostRequest(selectorContainer) {
        var valuesContainer = selectorContainer.querySelector('.oak_post_elements_selector__selected_elements_values_container');
        var singleElements = selectorContainer.querySelectorAll('.oak_post_elements_selector_selected_elements__single_element');
        valuesContainer.value = '';
        for( var i= 0; i < singleElements.length; i++ ) {
            if (singleElements[i].id != '') {
                delimiter = ',';
                if ( i== singleElements.length - 1 ) 
                    delimiter = '';

                valuesContainer.value = valuesContainer.value + singleElements[i].id + delimiter;
            }
        }
    }

    function handleRemoveButton(select, singleElementContainer) {
        var theButton = singleElementContainer.querySelector('.oak_post_elements_selector_selected_elements_single_element_element_remove_button');
        theButton.setAttribute('selectId', select.id);
        theButton.setAttribute('optionId', singleElementContainer.id);
        theButton.addEventListener('click', function() {
            var selectorContainer = this.parentNode.parentNode.parentNode;
            this.parentNode.remove();
            modifyValueContainerForPostRequest(selectorContainer);
            var options = document.querySelector('#' + this.getAttribute('selectId')).querySelectorAll('option');
            for (var i = 0; i < options.length; i++) {
                if (options[i].value == this.getAttribute('optionId')) {
                    options[i].selected = false;
                }
            }
        })

        
    }
}