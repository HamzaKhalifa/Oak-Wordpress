var elementToDelete;
var deleting = false;
var deletingDefinitely = false;
var importing = false;
var restoring = false;
var choosingModel = false;
var table = DATA.table;
var tableInPlural = DATA.tableInPlural;

// For the languages select
handleLanguagesSelectListener();
function handleLanguagesSelectListener() {
    var languagesSelect = document.querySelector('.oak_system_bar__languages_select');
    languagesSelect.addEventListener('change', function() {
        var listRows = document.querySelectorAll('.oak_list_row');
        for (var i = 0; i < listRows.length; i++) {
            var element = {};
            var identifier = listRows[i].getAttribute('identifier');
            j = DATA.elements.length - 1;
            var foundTheAssociatedLanguageInstance = false;
            do {
                if (DATA.elements[j][DATA.table + '_content_language'] == languagesSelect.value
                    && DATA.elements[j][DATA.table + '_identifier'] == identifier) {
                    foundTheAssociatedLanguageInstance = true;
                    element = DATA.elements[j];
                }
                j--;
            } while(!foundTheAssociatedLanguageInstance && j >= 0);

            var language = '';
            if (!foundTheAssociatedLanguageInstance) {
                var foundElement = false;
                j = DATA.elements.length - 1;
                do {
                    if (DATA.elements[j][DATA.table + '_identifier'] == identifier) {
                        foundElement = true;
                        element = DATA.elements[j];
                        language = ' (' + DATA.elements[j][DATA.table + '_content_language'] + ')';
                    }
                    j--;
                } while (!foundElement && j >= 0);
            }
            var titleContainers = listRows[i].querySelectorAll('.oak_list_titles_container__title');
            console.log(titleContainers);
            titleContainers[0].innerHTML = element[DATA.table + '_designation'] + language;
            for (var k = 0; k < 3; k++) {
                titleContainers[k + 1].innerHTML = element[DATA.propertiesToShowInList[k].property] + language;
            }
        }
    })
}

// For the cancel current action OR return to content library button: 
cancelActionButton();
function cancelActionButton() {
    var cancelButton = document.querySelector('.oak_menu_icon__cancel_icon');

    cancelButton.addEventListener('click', function() {
        if (classExists(this, 'fa-times')) {
            manageMenuForNothingSelected();
            var checkers = document.querySelectorAll('.oak_list_titles_container__checkbox');
            for (var i = 0; i < checkers.length; i++) {
                checkers[i].parentNode.parentNode.classList.remove('oak_list_row__selected');
                checkers[i].checked = false;
            }
        } else {
            window.location.replace(DATA.adminUrl + 'index.php');
        }
    });
}

// For the search button
searchButton();
function searchButton() {
    var searchIconButton = document.querySelector('.oak_menu_search_icon');
    searchIconButton.addEventListener('click', function() {
        var searchInput = document.querySelector('.oak_element_header_right__search_input');
        var oakHiddenExists = false;
        for(var i = 0; i < searchInput.classList.length; i++) {
            if (searchInput.classList[i] == 'oak_hidden')
                oakHiddenExists = true;
        }
        if (oakHiddenExists) {
            searchInput.classList.remove('oak_hidden');
            this.classList.add('fa-times');
        } else {
            searchInput.classList.add('oak_hidden');
            this.classList.remove('fa-times');
            document.querySelector('.oak_element_header_right__search_input').value = '';
            search();
        }
    });
}

// For the search button
searchInput();
function searchInput() {
    var searchButton = document.querySelector('.oak_element_header_right__search_input');
    searchButton.oninput = function() {
        search();
    }
}

function search() {
    var searchedDesignation = document.querySelector('.oak_element_header_right__search_input').value;
    var allDesignationsSpans = document.querySelectorAll('.oak_list_titles_container__the_title');
    for (var i = 0; i < allDesignationsSpans.length; i++) {
        if (allDesignationsSpans[i].parentNode.parentNode.getAttribute('filtered') != 'true') {
            if (searchedDesignation == '') {
                allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_list_highlighted');
                allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_hidden');
            } else {
                if (allDesignationsSpans[i].innerHTML.indexOf(searchedDesignation) != -1) {
                    // if (allDesignationsSpans[i].innerHTML == searchedDesignation) {
                    allDesignationsSpans[i].parentNode.parentNode.classList.add('oak_list_highlighted');
                    allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_hidden');
                    allDesignationsSpans[i].parentNode.parentNode.scrollIntoView();
                } else {
                    allDesignationsSpans[i].parentNode.parentNode.classList.remove('oak_list_highlighted');
                    allDesignationsSpans[i].parentNode.parentNode.classList.add('oak_hidden');
                }
            }
        }
        
    }
}

// For the delete button
deleteButton();
function deleteButton() {
    var deleteButton = document.querySelector('.oak_element_header_right_delete_button');
    deleteButton.addEventListener('click', function() {
        var message = '';
        var trashSelectValue = document.querySelector('.oak_trash_list_select').value;
        if (trashSelectValue == 'trashed') {
            deletingDefinitely = true;
            message = 'Êtes vous sûr de vouloir supprimer l\'élement définitivement ?';
        } else {
            message = 'Êtes vous sûr de vouloir supprimer les élements sélectionnés ?';
            deleting = true;
        }
        openModal(message, true);
    });
}

// For the restore button
restoreButton();
function restoreButton() {
    var restoreButton = document.querySelector('.oak_element_header_right_restore_button');
    restoreButton.addEventListener('click', function() {
        openModal(DATA.restoringSelectedElementsMessage, true);
        restoring = true;
    });
}

// For the copy button
copy();
function copy() {
    document.querySelector('.oak_element_header_right_copy_button').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
        var selectedIdentifiers = [];
        for (var i = 1; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedIdentifiers.push(checkboxes[i].parentNode.parentNode.getAttribute('identifier'));
            }
        }
        var copies = [];
        for (var i = 0; i < selectedIdentifiers.length; i++) {
            var foundIt = false;
            var counter = DATA.elements.length - 1;
            do {
                if (DATA.elements[counter][DATA.table + '_identifier'] == selectedIdentifiers[i]) {
                    foundIt = true;
                    var newIdentifier = createIdentifier();
                    for(var j = 0; j < DATA.elements.length; j++) {
                        if (DATA.elements[j][DATA.table + '_identifier'] == selectedIdentifiers[i]) {
                            var copy = {};
                            var keys = getKeys(DATA.elements[j]);
                            for (var k = 0; k < keys.length; k++) {
                                if (keys[k] != table + '_identifier' && keys[k] != table + '_designation' && keys[k] != 'id') {
                                    copy[keys[k]] = DATA.elements[j][keys[k]];
                                }
                            }
                            copy[table + '_identifier'] = newIdentifier;
                            copy[table + '_designation'] = DATA.elements[j][table + '_designation'] + ' (copy)';
                            copy['copy_identifier'] = DATA.elements[j][DATA.table + '_identifier'];
                            copies.push(copy);
                        }
                    }
                }
                counter--;
            } while(!foundIt && counter >= 0 );
        }
        var numberOfReturns = 0;
        setLoading();
        var whichCall = 0;
        for (var i = 0; i < copies.length; i++) {
            setTimeout(function() {
                jQuery(document).ready(function() {
                    jQuery.ajax({
                        url: DATA.ajaxUrl,
                        type: 'POST',
                        data: {
                            'action': 'oak_register_element',
                            'element': JSON.stringify(copies[whichCall]),
                            'table': DATA.table,
                            'tableInPlural': DATA.tableInPlural,
                            'fromRevision': false,
                            'properties': DATA.properties,
                            'copy': true,
                        },
                        success: function(data) {
                            console.log(data);
                            numberOfReturns++;
    
                            if (numberOfReturns == copies.length) {
                                window.location.reload();
                                doneLoading();
                            }
                        },
                        error: function(error) {
                            doneLoading();
                        }
                    });
                    whichCall++;
                });
            }, 1000);
        }
    });
}

function createIdentifier() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < 20; i++) 
      text += possible.charAt(Math.floor(Math.random() * possible.length));
      
    return text;
}

// For the infinite scroll
jQuery(document).ready(function() {
    jQuery('.oak_elements_list').infiniteScroll({
        // options
        path: '.pagination__next',
        append: '.oak_list_row',
        history: false,
        // prefill: true,
        loadOnScroll: false,
        loading:  { 
            finishedMsg: 'No more items to load', 
            // img: 'images/ajax-loading.gif' 
        },
        onInit: function() {
            this.on( 'load', function() {
              checkListeners();
              setTimeout(checkListeners, 1000);
              document.querySelector('.oak_infinite_scroll_loader').classList.add('oak_hidden');
            });
        },
    });
})

// For infinite scroll load next
handleLoadNext();
function handleLoadNext() {
    var loadNextButton = document.querySelector('.oak_list_loader_and_pagination_container__load_next');
    loadNextButton.addEventListener('click', function() {
        jQuery('.oak_elements_list').infiniteScroll('loadNextPage');
        checkListeners();
        document.querySelector('.oak_infinite_scroll_loader').classList.remove('oak_hidden');
    });
}

// For the select all checkboxes
selectAllCheckboxes();
function selectAllCheckboxes() {
    var selectAllCheckbox = document.querySelector('.oak_select_all_checkbox');
    selectAllCheckbox.addEventListener('change', function() {
        var allSelectChecbkBoxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
        for (var i = 0; i < allSelectChecbkBoxes.length; i++) {
            allSelectChecbkBoxes[i].checked = selectAllCheckbox.checked;
        }
    });
}
// Done with the select all checkbox

// For the check listeners
checkListeners();
function checkListeners() {
    var checkers = document.querySelectorAll('.oak_list_titles_container__checkbox');
    for (var i = 0; i < checkers.length; i++) {
        checkers[i].setAttribute('index', i);
        checkers[i].addEventListener('change', function() {
            if (this.checked) {
                this.parentNode.parentNode.classList.add('oak_list_row__selected');
                var listHeader = document.querySelector('.oak_element_header');
                listHeader.classList.add('oak_element_header_at_least_one_selected');
                document.querySelector('.oak_menu_icon__cancel_icon').classList.add('fa-times');

                var changeToolBar = false;
                if (this.getAttribute('index') == 0) {
                    for (var j = 1; j < checkers.length; j++) {
                        if (!classExists(checkers[j].parentNode.parentNode, 'oak_hidden'))
                            changeToolBar = true;
                    }
                }
                if (this.getAttribute('index') != 0 || (this.getAttribute('index') == 0 && changeToolBar )) {
                    document.querySelector('.oak_element_header_right_upload_button').classList.add('oak_hidden');
                    document.querySelector('.fa-copy').classList.remove('oak_hidden');
                    document.querySelector('.fa-trash-alt').classList.remove('oak_hidden');
                    if (document.querySelector('.oak_trash_list_select').value == 'trashed')
                        document.querySelector('.fa-window-restore').classList.remove('oak_hidden');
                }
            }
            else {
                this.parentNode.parentNode.classList.remove('oak_list_row__selected');
                // Check if there is still at least one selected
                var thereIs = false;
                for (var j = 0; j < checkers.length; j++) {
                    if (checkers[j].checked && j != 0) {
                        thereIs = true;
                    }
                }
                if (!thereIs || this.getAttribute('index') == 0) {
                    manageMenuForNothingSelected();
                }
            }
            if (this.getAttribute('index') == 0) {
                for (var j = 0; j < checkers.length; j++) {
                    if (this.checked) 
                        checkers[j].parentNode.parentNode.classList.add('oak_list_row__selected');
                    else 
                        checkers[j].parentNode.parentNode.classList.remove('oak_list_row__selected');
                }
            }
    
            // Check if there is only one element selected to add the edit button: 
            var editButton = document.querySelector('.oak_elemnt_header_right_edit_button');
            var numberOfSelected = 0;
            for (var j = 0; j < checkers.length; j++) {
                if (this.getAttribute('index') == 0) { 
                    if (this.checked) 
                        checkers[j].parentNode.parentNode.classList.add('oak_list_row__selected');
                    else 
                        checkers[j].parentNode.parentNode.classList.remove('oak_list_row__selected');
                }
    
                if (checkers[j].checked && j != 0) 
                    numberOfSelected++;
            }
            if (numberOfSelected == 1) {
                editButton.classList.remove('oak_hidden');
            } else {
                editButton.classList.add('oak_hidden');
            }
        });
    }
}

function manageMenuForNothingSelected() {
    var checkers = document.querySelectorAll('.oak_list_titles_container__checkbox');
    document.querySelector('.oak_element_header').classList.remove('oak_element_header_at_least_one_selected');
    checkers[0].checked = false;
    checkers[0].parentNode.parentNode.classList.remove('oak_list_row__selected');
    document.querySelector('.oak_element_header_right_upload_button').classList.remove('oak_hidden');
    document.querySelector('.fa-copy').classList.add('oak_hidden');
    document.querySelector('.fa-trash-alt').classList.add('oak_hidden');
    if (document.querySelector('.oak_trash_list_select').value == 'trashed')
        document.querySelector('.fa-window-restore').classList.add('oak_hidden');
    document.querySelector('.oak_menu_icon__cancel_icon').classList.remove('fa-times');
}

// For the edit button
edit();
function edit() {
    var editButton = document.querySelector('.oak_elemnt_header_right_edit_button');
    editButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            var elementsTypeToPutInUrl = DATA.elementsType;
            if (i != 0 && checkboxes[i].checked && !classExists(checkboxes[i].parentNode.parentNode, 'oak_hidden')) {
                var identifier = checkboxes[i].parentNode.parentNode.getAttribute('identifier');
                var additionalData = ''
                if (DATA.elementsType == 'objects') 
                    additionalData = '&model_identifier=' + DATA.tableInPlural;
                else if (DATA.elementsType == 'term_objects') {
                    additionalData = '&model_identifier=' + checkboxes[i].parentNode.parentNode.getAttribute('model-identifier');
                    elementsTypeToPutInUrl = 'objects';
                }
                else if ( DATA.elementsType == 'terms' )
                    additionalData = '&taxonomy_identifier=' + DATA.tableInPlural;

                window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_element&' + table + '_identifier=' + identifier + '&elements=' + elementsTypeToPutInUrl + '&listorformula=formula' + additionalData);
            }
        }
    });
}

function classExists(element, className) {
    for (var i = 0; i < element.classList.length; i++) {
        if (element.classList[i] == className) 
            return true
    }

    return false;
}

// For the add button
add();
function add() {
    var addButton = document.querySelector('.oak_list_add_button');
    addButton.addEventListener('click', function() {
        additionalData = '';
        if (DATA.elementsType == 'objects') 
            additionalData = '&model_identifier=' + DATA.tableInPlural;
        else if ( DATA.elementsType == 'terms' )
            additionalData = '&taxonomy_identifier=' + DATA.tableInPlural;
        else if ( DATA.elementsType == 'term_objects' ) {
            choosingModel = true;
            openModal(DATA.choosingModelMessage);
            return;
        }
        window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_element&elements=' + DATA.elementsType + '&listorformula=formula' + additionalData);
    });
}
// Done with the add button

// For the import button
importButton();
function importButton() {
    var importButton = document.querySelector('.oak_element_header_right_upload_button');
    importButton.addEventListener('click', function() {
        importing = true;
        openModal('', true);
    });
}
// Done with the import button

// For the sort selector: 
handleSortSelector();
function handleSortSelector() {
    var sortSelector = document.querySelector('.oak_elements_list__sort_select');
    sortSelector.addEventListener('change', function() {
        var difference = window.location.href.length - window.location.href.indexOf('whichpage=') - 10;
        difference = difference + '';
        var whichpage = '';
        for (var i = difference.length; i > 0; i--) {
            whichpage += window.location.href[window.location.href.length - i];
        }
        var currentLinkWithoutPage = window.location.href.substring(0, window.location.href.indexOf('whichpage='));
        var theUrl = currentLinkWithoutPage + '&sort=' + this.value + '&whichpage=' + whichpage;
        window.location.replace(theUrl);
    })
}
// Done with the sort selector

// For the model download button
exportButton();
function exportButton() {
    var downloadButton = document.querySelector('.oak_element_header_right_download_button');
    downloadButton.addEventListener('click', function() {
        exportData();
    });
    function exportData() {
        var identifiersToExport = [];
        var checkBoxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
        for (var i = 1; i < checkBoxes.length; i++) {
            if (checkBoxes[i].checked) {
                identifiersToExport.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
            }
        }
        var rows = [];
        for (var i = 0; i < DATA.elements.length; i++) {
            if (identifiersToExport.indexOf(DATA.elements[i][table + '_identifier']) != -1 ) {
                var rowValues = [];
                for (var j = 0; j < DATA.properties.length; j++) {
                    rowValues.push(formatWordForSCV(DATA.elements[i][table + '_' + DATA.properties[j].name]));
                }
                // To push the modification time property: 
                rowValues.push(DATA.elements[i][table + '_modification_time']);
                rows.push(rowValues);
            }
        }
        var model = '';
        for (var i = 0; i < DATA.properties.length; i++) {
            model += table + '_' + DATA.properties[i].name + ',';
        }
        let csvContent = 'data:text/csv;charset=utf-8,' + model + table + '_modification_time\r\n';
        // let csvContent = 'data:text/csv;charset=utf-8,id,field_designation,field_identifier,field_instructions,field_placeholder,field_default_value,field_function,field_max_length,field_selector,field_type,field_after,field_before,field_modification_time,field_state,field_trashed,field_locked' + '\r\n';
        for (var i = 0; i < rows.length; i++) {
            let row = rows[i].join(",");
            var nextLine = '';
            if (i != rows.length - 1) 
                nextLine = '\r\n';
            csvContent += row + nextLine;
        }

        // For the associative table
        var rows = [];
        if (DATA.otherElementProperties && DATA.otherElementProperties.associative_tab_instances.length > 0) {
            var keys = getKeys(DATA.otherElementProperties.associative_tab_instances[0]);
            for (var i = 0; i < DATA.otherElementProperties.associative_tab_instances.length; i++) {
                if (identifiersToExport.indexOf(DATA.otherElementProperties.associative_tab_instances[i][table + '_identifier']) != -1 ) {
                    var rowValues = [];
                    for (var j = 0; j < keys.length; j++) {
                        if (keys[j] != 'id') {
                            rowValues.push(formatWordForSCV(DATA.otherElementProperties.associative_tab_instances[i][keys[j]]));
                        }
                    }
                    rows.push(rowValues);
                }
            }
            var model = '';
            for (var i = 0; i < keys.length; i++) {
                if (keys[i] != 'id') {
                    model += keys[i] + ',';
                }
            }
            let associativeTableCSV = 'data:text/csv;charset=utf-8,' + model + '\r\n';
            console.log(rows);
            for (var i = 0; i < rows.length; i++) {
                let row = rows[i].join(",");
                var nextLine = '';
                if (i != rows.length - 1) 
                    nextLine = '\r\n';
                associativeTableCSV += row + nextLine;
            }
            var encodedUriForAssociativeTableCSV = encodeURI(associativeTableCSV);
            window.open(encodedUriForAssociativeTableCSV);
        }
        // Done with the associative table

        // setTimeout(function() {
            
        // }, 2000)
        var encodedUri = encodeURI(csvContent);
        window.open(encodedUri);
    }
}

var getKeys = function(obj){
    var keys = [];
    for(var key in obj){
       keys.push(key);
    }
    return keys;
}

function formatWordForSCV(word) {
    var result = word;
    result = addSlashes(result);
    result = "'" + result + "'";
    return result;
}

function addSlashes(string) {
    if (string != null) {
        return string.replace(/\\/g, '\\\\')
            .replace(/'/g, '\\\'')
            .replace(/"/g, '\\"')
            .replace(/\n/g, '\\\\n')
            .replace(/\f/g, '\\\\f')
            .replace(/\r/g, '\\\\r')
            .replace(/\t/g, '\\\\t')
    } else {
        return 'null';
    }
}
// Done with the grouped action select

// For the filters
manageFilters();
function manageFilters() {
    var filterButton = document.querySelector('.oak_groupd_actions__filter_button');
    filterButton.addEventListener('click', function() {
        
        var firstProperty = document.querySelector('.oak_grouped_actions__first_property_filter').value;
        var secondProperty = document.querySelector('.oak_grouped_actions__second_property_filter').value;
        var trashed = document.querySelector('.oak_trash_list_select').value == 'trashed' ? 'true' : 'false';
        
        var filterUrl = window.location.href.substring(0, window.location.href.indexOf('whichpage')) + 'firstproperty=' + firstProperty + '&secondproperty=' + secondProperty + '&trashed=' + trashed + '&whichpage=0';
        window.location.replace(filterUrl);
    });
}

// function filterResult() {
//     var allNaturesButton = document.querySelector('.oak_grouped_actions__all_natures');
//     var allFunctionsButton = document.querySelector('.oak_grouped_actions__all_functions');
//     var trashSelect = document.querySelector('.oak_trash_list_select');
//     var naturesContainers = document.querySelectorAll('.oak_list_nature');
//     var functionsContainers = document.querySelectorAll('.oak_list_function');

//     var considerNature = false;
//     var considerFunction = false;

//     if (allNaturesButton.value != 'all-natures') 
//         considerNature = true;

//     if (allFunctionsButton.value != 'all-functions')
//         considerFunction = true;
    
//     for (var i = 0; i < naturesContainers.length; i++) {
//         var hide = false;
        
//         if (considerNature && naturesContainers[i].innerHTML != allNaturesButton.value) {
//             hide = true;
//         }

//         if (considerFunction && functionsContainers[i].innerHTML != allFunctionsButton.value) {
//             hide = true;
//         }

//         if ( trashSelect.value == 'trashed' && functionsContainers[i].parentNode.parentNode.getAttribute('trashed') != 'true' || trashSelect.value != 'trashed' && functionsContainers[i].parentNode.parentNode.getAttribute('trashed') == 'true' ) {
//             hide = true;
//         }

//         if (hide) {
//             naturesContainers[i].parentNode.parentNode.classList.add('oak_hidden');
//             naturesContainers[i].parentNode.parentNode.setAttribute('filtered', true);
//         } else {
//             naturesContainers[i].parentNode.parentNode.classList.remove('oak_hidden');
//             naturesContainers[i].parentNode.parentNode.setAttribute('filtered', false);
//         }
//     }
// }
// Done with the all natures button

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');
    if (deleting) {
        confirmButtonSpan.innerHTML = 'Supprimer';
    }
    var modelsList = document.querySelector('.oak_add_element_modal_container_modal__models_list');
    if (choosingModel) {
        modelsList.style.display = 'flex';
    } else {
        modelsList.style.display = 'none';
    }

    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    if (importing) {
        modalTitle.innerHTML = '<h3 class="oak_add_element_modal_container_modal_title_container__title">Importer des données d\'un fichier CSV</h3><input class="oak_csv_file_input" type="file">';
        confirmButtonSpan.innerHTML = 'Importer';
    }

    var addButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
    if ( twoButtons) {
        addButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        addButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

// For the ok modal button
okButton();
function okButton() {
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
    okButtonContainer.addEventListener('click', function() {
        closeModals();
    }); 
}

function closeModals() {
    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    deleting = false;
    importing  = false;
    restoring = false;
    choosingModel = false;
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_add_element_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        console.log('kdfjdkfkd');
        if (importing) {
            var input = document.querySelector('.oak_csv_file_input');
            readCSV(input);
        }
        if (deleting || deletingDefinitely) {
            var identifiersToDelete = [];
            var checkBoxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
            for (var i = 1; i < checkBoxes.length; i++) {
                if (checkBoxes[i].checked && !classExists(checkBoxes[i].parentNode.parentNode, 'oak_hidden')) {
                    identifiersToDelete.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                }
            }
            setLoading();
            var functionName = deleting ? 'oak_send_to_trash' : 'oak_delete_definitely';
            var tableInPlural = DATA.tableInPlural;

            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'data': {
                            'table': DATA.table,
                            'tableInPlural': tableInPlural,
                            'identifiers': identifiersToDelete,
                            'otherElementsTableName': DATA.otherElementProperties ? DATA.otherElementProperties.table_name : false,
                        },
                        'action': functionName
                    },
                    success: function(data) {
                        console.log(data);
                        doneLoading();
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                        window.localStorage.reload();
                    }
                });
            });
        }
        if (restoring) {
            var identifiersToRestore = [];
            var checkBoxes = document.querySelectorAll('.oak_list_titles_container__checkbox');
            for (var i = 1; i < checkBoxes.length; i++) {
                if (checkBoxes[i].checked) {
                    identifiersToRestore.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                }
            }
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST', 
                    data: {
                        'data': {
                            'table': DATA.table,
                            'tableInPlural': DATA.tableInPlural,
                            'identifiers': identifiersToRestore
                        },
                        'action': 'oak_restore_from_trash'
                    },
                    success: function(data) {
                        doneLoading();
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        }
    });

    var cancelButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

handleAddObjectModelButtons();
function handleAddObjectModelButtons() {
    var modelsButtons = document.querySelectorAll('.oak_modal_select_model_button');
    for (var i = 0; i < modelsButtons.length; i++) {
        modelsButtons[i].addEventListener('click', function() {
            var modelIdentifier = this.getAttribute('model-identifier');

            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_add_element&elements=objects&listorformula=formula&model_identifier=' + modelIdentifier + '&term_identifier=' + DATA.termIdentifier);
        });
    }
}

function readCSV(input) {
    if (typeof (FileReader) != 'undefined') {
        var reader = new FileReader();
        reader.onload = function (e) {
            var rows = e.target.result.split('\n');
            console.log('rows as they are' + rows);
            for (var i = 0; i < rows.length; i++ ) {
                var valuesOfI = CSVtoArray(rows[i]);
                for (var j = 0; j < valuesOfI.length; j++) {
                    valuesOfI[j] = valuesOfI[j].replace(/\\"/g, '"')
                        .replace(/\\'/g, '\'')
                        .replace(/\\\\n/g, '\\n')
                        .replace(/\\\\f/g, '\\f')
                        .replace(/\\\\r/g, '\\r')
                        .replace(/\\\\t/g, '\\t')
                        .replace(/\\\\/g, '\\');
                    rows[i] = valuesOfI;
                }
            }
            console.log(rows);
            var tableName = tableInPlural
            var wellDefinedTableName = false;
            if (rows[0][0].split('_')[0] != rows[0][1].split('_')[0]) {
                // Then this is an associative table import: 
                tableName = DATA.otherElementProperties.table_name;
                wellDefinedTableName = true;
            }
            console.log(tableName);
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_import_csv',
                        'rows': rows,
                        'table': tableName,
                        'single_name': DATA.table,
                        'wellDefinedTableName': wellDefinedTableName
                    },
                    success: function(data) {
                        doneLoading();
                        window.location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                    }
                });
            })
        }
        reader.readAsText(input.files[0]);
        closeModals();
        setLoading();
    } else {
        alert('This browser does not support HTML5.');
    }
}

function CSVtoArray(text) {
    var re_valid = /^\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*(?:,\s*(?:'[^'\\]*(?:\\[\S\s][^'\\]*)*'|"[^"\\]*(?:\\[\S\s][^"\\]*)*"|[^,'"\s\\]*(?:\s+[^,'"\s\\]+)*)\s*)*$/;
    var re_value = /(?!\s*$)\s*(?:'([^'\\]*(?:\\[\S\s][^'\\]*)*)'|"([^"\\]*(?:\\[\S\s][^"\\]*)*)"|([^,'"\s\\]*(?:\s+[^,'"\s\\]+)*))\s*(?:,|$)/g;
    // Return NULL if input string is not well formed CSV string.
    if (!re_valid.test(text)) return null;
    var a = [];                     // Initialize array to receive values.
    text.replace(re_value, // "Walk" the string using replace with callback.
        function(m0, m1, m2, m3) {
            // Remove backslash from \' in single quoted values.
            if      (m1 !== undefined) a.push(m1.replace(/\\'/g, "'"));
            // Remove backslash from \" in double quoted values.
            else if (m2 !== undefined) a.push(m2.replace(/\\"/g, '"'));
            else if (m3 !== undefined) a.push(m3);
            return ''; // Return empty string.
        });
    // Handle special case of empty last value.
    if (/,\s*$/.test(text)) a.push('');
    return a;
};