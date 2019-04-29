
// Global variables
var adding = false;
var canceling = false;
var updating = false;
var browsingRevisions = false;
var revision = {};
var table = DATA.table;
var elementData = {};
var properties = DATA.properties 
for (var i = 0; i < properties.length; i++) {
    elementData[DATA.table + '_' + properties[i].name] = '';
}
var numberOfExistingRenamingInputs = 0;

// For the languages select change listener 
handleLanguagesSelectListener();
function handleLanguagesSelectListener() {
    var languagesSelect = document.querySelector('.oak_system_bar__languages_select');
    languagesSelect.addEventListener('change', function() {
        var theRevision = null;
        var languageCode = languagesSelect.value;
        for (var i = 0; i < DATA.revisions.length; i++) {
            if (DATA.revisions[i][DATA.table + '_content_language'] == languageCode) {
                theRevision = DATA.revisions[i];
            }
        }
        // Lets change the designation: 
        var designationInput = document.querySelector('.' + DATA.table + '_designation_input');
        if (theRevision != null) {
            designationInput.value = theRevision[DATA.table + '_designation'];
        } else {
            designationInput.value = '';
        }

        // Now lets change the properties
        for (var i = 0; i < DATA.properties.length; i++) {
            if (DATA.properties[i].translatable) {
                var propertyInput = document.querySelector('.' + DATA.table + '_' + DATA.properties[i].name + '_input');
                console.log('.' + DATA.table + '_' + DATA.properties[i].name + '_input');
                if (propertyInput != null) {
                    if (theRevision != null) {
                        propertyInput.value = theRevision[DATA.table + '_' + DATA.properties[i].name];
                    } else {
                        propertyInput.value = '';
                    }
                }
            } 
        }

        // Now for other elements (Forms and models)
        if (DATA.otherElementProperties) {
            initializeElements();
        }

        console.log(theRevision);
    });
}

// For numerotation format (for quanti and quali): 
initializeNumerotationFormat();
function initializeNumerotationFormat() {
    if (table == 'quanti' || table == 'quali') {
        var numerotationSelect = document.querySelector('.' + table + '_numerotation_type_input');
        handleNumerotation(numerotationSelect);
        numerotationSelect.addEventListener('change', function() {
            handleNumerotation(this);
        });
    }
}

function handleNumerotation(numerotationSelect) {
    var numerotationInput = document.querySelector('.' + table + '_numerotation_input');
    switch(numerotationSelect.value) {
        case '1' :
            numerotationInput.setAttribute('type', 'number');
            numerotationInput.setAttribute('onkeypress', '');
        break;
        case 'I': 
            numerotationInput.setAttribute('type', 'text');
            numerotationInput.setAttribute('onkeypress', 'return /[a-z]/i.test(event.key)');
        break;
        case 'a': 
            numerotationInput.setAttribute('type', 'text');
            numerotationInput.setAttribute('onkeypress', 'return /[a-z]/i.test(event.key)');
        break;
        case '1.a': 
            numerotationInput.setAttribute('type', 'text');
            numerotationInput.setAttribute('onkeypress', '');
        break;
    } 
}

function alphaOnly(event) {
    var key = event.keyCode;
    return ((key >= 65 && key <= 90) || key == 8);
};

// For the text fields animation
textFieldsAnimations();
function textFieldsAnimations() {
    var textFields = document.querySelectorAll('.oak_text_field_container');
    for(var i = 0; i < textFields.length; i++) {
        textFields[i].addEventListener('click', function() {
            var input = this.querySelector('input') ? this.querySelector('input') : this.querySelector('textarea');
            input.focus();
        });
    }

    // Un focus all textfields and handle their state
    for(var i = 0; i < textFields.length; i++) {
        if (!jQuery(textFields[i].querySelector('input')).is(':focus')) {
            var input = textFields[i].querySelector('input') ? textFields[i].querySelector('input') : textFields[i].querySelector('textarea');
            if ( input.value == '')
                unfocusTextField(textFields[i]);
            else 
                unfocusTextFieldButSomethingWritten(textFields[i]);
        }   
    }

    // Add the focus listener for the input
    var inputs = document.querySelectorAll('.oak_text_field');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('focus', function() {
            var textFields = document.querySelectorAll('.oak_text_field_container');
            for(var i = 0; i < textFields.length; i++) {
                if (!jQuery(textFields[i].querySelector('input')).is(':focus')) {
                    var input = textFields[i].querySelector('input') ? textFields[i].querySelector('input') : textFields[i].querySelector('textarea');
                    if ( input.value == '')
                        unfocusTextField(textFields[i]);
                    else 
                        unfocusTextFieldButSomethingWritten(textFields[i]);
                }   
            }
            focusTextField(this);
        });
    }
}

function focusTextField(input) {
    var textField = input.parentNode;
    if (!textField.querySelector('.oak_text_field_placeholder')) {
        textField = textField.parentNode;
    }
    removeSomethingWrittenClasses(textField);
    textField.querySelector('.oak_text_field_placeholder').classList.add('oak_text_field_placeholder_focused');
    theInput = textField.querySelector('input') ? textField.querySelector('input') : textField.querySelector('textarea');
    if (theInput.inputMode != 'focus')
        theInput.focus();
    textField.querySelector('.text_field_line').classList.add('text_field_line_focused');
}

function unfocusTextFieldButSomethingWritten(textField) {
    textField.querySelector('.oak_text_field_placeholder').classList.add('oak_text_field_placeholder_not_focused_but_something_written');
    textField.querySelector('.text_field_line').classList.add('text_field_line_not_focused_but_something_written');
}

function removeSomethingWrittenClasses(textField) {
    textField.querySelector('.oak_text_field_placeholder').classList.remove('oak_text_field_placeholder_not_focused_but_something_written');
    textField.querySelector('.text_field_line').classList.remove('text_field_line_not_focused_but_something_written');
}

function unfocusTextField(textField) {
    textField.querySelector('.oak_text_field_placeholder').classList.remove('oak_text_field_placeholder_focused');
    textField.querySelector('.text_field_line').classList.remove('text_field_line_focused');
} 

windowClick();
function windowClick() {
    jQuery(document).ready(function() {
        window.addEventListener('click', function() {
            var textFields = document.querySelectorAll('.oak_text_field_container');
            for(var i = 0; i < textFields.length; i++) {
                var input = textFields[i].querySelector('input') ? textFields[i].querySelector('input') : textFields[i].querySelector('textarea');
                if (!jQuery(input).is(':focus') && input.value == '') {
                    unfocusTextField(textFields[i]);
                }
            }
        })
    });
}

// For the select container listener and checkboxes (unfocus all other textfields) 
otherInputsListeners();
function otherInputsListeners() {
    var selectContainers = document.querySelectorAll('.oak_select_container');
    for (var i = 0; i < selectContainers.length; i++) {
        selectContainers[i].addEventListener('click', function() {
            unfocusAllTextFields();
        });
    }
    
    var inputs = document.querySelectorAll('input');
    var checkboxes = [];
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].getAttribute('type') == 'checkbox') {
            checkboxes.push(inputs[i]);
        }
    }
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function() {
            unfocusAllTextFields();
        });
    }
}

function unfocusAllTextFields() {
    var textFields = document.querySelectorAll('.oak_text_field_container');
    for(var i = 0; i < textFields.length; i++) {
        var input = textFields[i].querySelector('input') ? textFields[i].querySelector('input') : textFields[i].querySelector('textarea');
        if ( input.value == '')
            unfocusTextField(textFields[i]);
        else 
            unfocusTextFieldButSomethingWritten(textFields[i]);
    }
}
 
// For the add button
addButton();
function addButton() {
    var addButton = document.querySelector('.oak_add_element_container__add_button');
    if (addButton) {
        addButton.addEventListener('click', function() {
            var ok = checkOk();
            if (!ok)
                return;
            elementData = createElementData(0);
            adding = true;
            openModal(DATA.addingElementMessage, true);
        });    
    }
}

// For the update button 
updateButton();
function updateButton() {
    var updateButton = document.querySelector('.oak_add_element_container__update_button');
    if (updateButton) {
        updateButton.addEventListener('click', function() {
            elementData = createElementData(DATA.revisions[DATA.revisions.length - 1].field_state);
            updating = true;
            openModal(DATA.modifyingElementMessage, true);
        });
    }
}

// For the register button
registerButton();
function registerButton() {
    var registerButton = document.querySelector('.oak_add_element_container__register_button');
    if (registerButton) {
        registerButton.addEventListener('click', function() {
            elementData = createElementData(1);
            if (DATA.revisions.length == 0) {
                // adding for the first time
                var ok = checkOk();
                if (!ok)
                    return;
                adding = true;
            } else {
                updating = true;
            }
            openModal(DATA.addingToRegisteredElementsListMessage, true);
        });
    }
}

function checkOk() {
    ok = true;
    var designation = document.querySelector('.' + DATA.table + '_designation_input').value;
    if (designation.trim() == '') {
        openModal(DATA.enterDesignationFirstMessage, false);
        ok = false;
    } 
    return ok;
}

// For the broadcast button
broadcastButton();
function broadcastButton() {
    var theBroadcastButton = document.querySelector('.oak_add_element_container__broadcast_button');
    if (theBroadcastButton) {
        theBroadcastButton.addEventListener('click', function() {
            elementData = createElementData(2);
            updating = true;
            openModal(DATA.modifyAndDiffuseMessage, true);
        });
    }
}

// For the back to draft button: 
draftButton();
function draftButton() {
    var draftButton = document.querySelector('.oak_add_element_container__draft_button');
    if (draftButton) {
        draftButton.addEventListener('click', function() {
            elementData = createElementData(0);
            updating = true;
            openModal(DATA.sendToDraftMessage, true);
        });
    }
}

// For the identifier input
if (DATA.revisions < 1)
    createIdentifier();

function createIdentifier() {
    var text = "";
    var possible = "abcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 20; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
      
    var identifierInput = document.querySelector('.' + DATA.table + '_identifier_input');
    identifierInput.value = text;
}

// To initialize the color select: 
jQuery(document).ready(function($){
    jQuery('.oak_color').wpColorPicker();
});

// We create while adding the new revision
function createElementData(state) {
    var keys = getKeys(elementData);

    if (DATA.table == 'object') {
        elementData.object_selectors = '';
    }

    for(var i = 0; i < properties.length; i++) {
        if (document.querySelector('.' + DATA.table + '_' + properties[i].name + '_input')) {
            if (properties[i].input_type == 'text' || properties[i].input_type == 'select' || properties[i].input_type == 'number' || properties[i].input_type == 'color' || properties[i].input_type == 'textarea' || properties[i].input_type == 'quali' || properties[i].input_type == 'quanti' || properties[i].input_type == 'selector' ) {
                // elementData[keys[i]] = document.querySelector('.' + DATA.table + '_' + properties[i].name + '_input').value.toString();
                elementData[keys[i]] = jQuery('.' + DATA.table + '_' + properties[i].name + '_input').val();
                if (Array.isArray(elementData[keys[i]])) {
                    var newValue = '';
                    for (var j = 0; j < elementData[keys[i]].length; j++) {
                        var delimiter = '';
                        if ( j != elementData[keys[i]].length - 1 ) 
                            delimiter = '|';
                        newValue = newValue + elementData[keys[i]][j] + delimiter;
                    }
                    elementData[keys[i]] = newValue;
                }
            }
            else if (properties[i].input_type == 'image')
                elementData[keys[i]] = document.querySelector('.' + DATA.table + '_' + properties[i].name + '_input').parentNode.querySelector('img').getAttribute('src').toString();
            else if (properties[i].input_type == 'file')
                elementData[keys[i]] = document.querySelector('.' + DATA.table + '_' + properties[i].name + '_input').getAttribute('value').toString();
            else if (properties[i].input_type == 'checkbox') 
                elementData[keys[i]] = document.querySelector('.' + DATA.table + '_' + properties[i].name + '_input').checked.toString();
            else if (properties[i].input_type == 'select_with_filters') {
                var dataSelects = document.querySelector('.' + DATA.table + '_' + properties[i].name + '_input').parentNode.parentNode.querySelectorAll('.oak_select_container_with_filters_single_element__data_select');
                var allTheSelectsValues = '';
                for (var k = 0; k < dataSelects.length; k++) {
                    var delimiter = '';
                    if ( k != dataSelects.length - 1 ) 
                        delimiter = '|';
                    allTheSelectsValues = allTheSelectsValues + dataSelects[k].value + delimiter;
                    elementData[keys[i]] = allTheSelectsValues;
                }
            }
        }

        // Check for the selector for each property: 
        if (document.querySelector('.' + DATA.table + '_' + properties[i].name + '_selector')) {
            var selector = document.querySelector('.' + DATA.table + '_' + properties[i].name + '_selector');
            var options = selector.querySelectorAll('option');
            var selectedObjects = [];
            for (var j = 1; j < options.length; j++ ) {
                if (options[j].selected) {
                    selectedObjects.push(options[j].getAttribute('value'));
                }
            }
            for (var j = 0; j < selectedObjects.length; j++) {
                elementData.object_selectors += properties[i].name + ':' + selectedObjects[j] + '|';
            }

            // elementData.object_selectors += properties[i].name + ':' + document.querySelector('.' + DATA.table + '_' + properties[i].name + '_selector').value + '|';
        }
    }
    
    if (state != 0) {
        elementData[table + '_state'] = state ? state.toString() : DATA.revisions[DATA.revisions.length - 1][table + '_state'].toString();
    }
    else
        elementData[table + '_state'] = state.toString();

    // Manage trashed and locked
    elementData[table + '_trashed'] = 'false';
    elementData[table + '_locked'] = 'false';

    // Manage other elements 
    if (DATA.otherElementProperties) {

        var revisionNumber = 1;
        if (DATA.revisions.length != 0) {
            revisionNumber = parseInt(DATA.revisions[DATA.revisions.length - 1][DATA.table + '_revision_number']) + 1;
        }

        var otherElements = [];
        var otherElementsDesignationContainers = document.querySelectorAll('.oak_other_elements_single_elements_container__single_element');
        for (var i = 0; i < otherElementsDesignationContainers.length; i++) {
            otherElements.push({
                elementIdentifier: otherElementsDesignationContainers[i].querySelector('.oak_other_elements_select').value,
                elementOtherDesignation: otherElementsDesignationContainers[i].querySelector('.designation_input').value,
                elementRequired: otherElementsDesignationContainers[i].querySelector('.selector_input').checked,
                elementIndex: i,
                revisionNumber: revisionNumber
            });
        }
        elementData.otherElements = otherElements;
        elementData.otherElementsProperties = DATA.otherElementProperties;
        elementData[table + '_revision_number'] = revisionNumber;

        // Manage fields names:
        if (table == 'model') {
            var modelFieldsNames = '';
            var renamingInputs = document.querySelectorAll('.oak_model_field_renaming_input');
            for(var r = 0; r < renamingInputs.length; r++) {
                var delimiter = '|';
                if (r == renamingInputs.length - 1) 
                    delimiter = '';
                var fieldName = renamingInputs[r].value == '' ? ' ' : renamingInputs[r].value;
                modelFieldsNames = modelFieldsNames + fieldName + delimiter;
            }
            elementData.model_fields_names = modelFieldsNames;
        }
    }

    // Manage objects' terms and form selectors: 
    if (DATA.table == 'object') {
        var selectedTerms = [];
        var selectedTermsInputs = document.querySelectorAll('.oak_autocomplete_selected_input');
        for (var i = 0; i < selectedTermsInputs.length; i++) {
            selectedTerms.push(selectedTermsInputs[i].getAttribute('identifier'));
        }
        elementData.selected_terms = selectedTerms;

        // Check for forms' selectors: 
        var objectFormSelectors = '';
        var formSelectors = document.querySelectorAll('.object_form_selector');
        for (var i = 0; i < formSelectors.length; i++) {
            var formIdentifier = formSelectors[i].getAttribute('form-identifier');
            var options = formSelectors[i].querySelectorAll('option');
            var selectedObjects = [];
            for (var i = 1; i < options.length; i++ ) {
                if (options[i].selected) {
                    selectedObjects.push(options[i].getAttribute('value'));
                }
            }
            for (var j = 0; j < selectedObjects.length; j++) {
                objectFormSelectors += 'form_' + formIdentifier + '_object_' + selectedObjects[j] + '|';
            }
            
        }
        elementData.object_form_selectors = objectFormSelectors;
        
        // Check for model selector: 
        var objectModelSelector = document.querySelector('.object_model_selector');
        if (objectModelSelector) {
            var selectedObjects = jQuery('.object_model_selector').val();
            var selectedObjectsString = '';
            if (selectedObjects != null) {
                for (var i = 0; i < selectedObjects.length; i++) {
                    var delimiter = '|';
                    if (i == selectedObjects.length - 1) 
                        delimiter = '';
                    
                    selectedObjectsString += selectedObjects[i] + delimiter;
                }
            }
            elementData.object_model_selector = selectedObjectsString;
        }
    }

    // Manage performance results: 
    if (DATA.table == 'performance') {
        var performanceResults = '';
        var singlePerformanceResults = document.querySelectorAll('.oak_single_performance_result');
        for (var i = 0; i < singlePerformanceResults.length; i++) {
            var delimiter = '|';
            if ( i == singlePerformanceResults.length - 1 ) 
                delimiter = '';
            var year = singlePerformanceResults[i].querySelector('.performance_goal_year_input').value;
            var goal = singlePerformanceResults[i].querySelector('.performance_goal_input').value;
            var estimation = singlePerformanceResults[i].querySelector('.performance_estimated_input').checked;
            var noValue = singlePerformanceResults[i].querySelector('.performance_no_value_input').checked;

            performanceResults += year + ':' + goal + ':' + estimation + ':' + noValue + delimiter;

            elementData.performance_results = performanceResults;
        }
    }

    // For the language: 
    elementData[DATA.table + '_content_language'] = document.querySelector('.oak_system_bar__languages_select').value;

    console.log(elementData);
    
    return elementData;
}

// for the browse revisions button:
singleElementRevisionView = '';
getSingleElementRevisionView();
function getSingleElementRevisionView() {
    var singleElementInputContainer = document.querySelector('.oak_other_elements_revision_inputs__single_element_container'); 
    if (singleElementInputContainer) {
        singleElementRevisionView = singleElementInputContainer.innerHTML;
        document.querySelector('.oak_other_elements_revision_inputs__single_element_container').remove();
    }
}

browseRevisionsButton();
function browseRevisionsButton() {
    theBrowseRevisionsButton = document.querySelector('.oak_add_element_big_container_tabs_single_tab_section_state__browse');
    theBrowseRevisionsButton.addEventListener('click', function() {
        browsingRevisions = true;
        openModal(DATA.revisionsListMessage, true);
        
        elementData = createElementData();
        for (var i = 0; i < properties.length; i++) {
            if ( properties[i].name != 'revision_number' )
                document.querySelector('.oak_revision_' + properties[i].name + '_field_current').value = elementData[table + '_' + properties[i].name];
        }
        if ( table == 'form' || table == 'model') {
            // Lets first delete what is already there
            var singleElementsRevisionsContainers = document.querySelectorAll('.oak_other_elements_revision_inputs__single_element_container');
            for (var i = 0; i < singleElementsRevisionsContainers.length; i++) {
                singleElementsRevisionsContainers[i].remove();
            }
            // Done deleting what is already there

            var singleElementsContainers = document.querySelectorAll('.oak_other_elements_single_elements_container__single_element');
            for (var i = 0; i < singleElementsContainers.length; i++) {
                var designationsSelect = singleElementsContainers[i].querySelector('.oak_other_elements_select');
                var elementIdentifier = designationsSelect.value;
                var elementName = '';
                var options = designationsSelect.querySelectorAll('option');
                for (var j = 0; j < options.length; j++) {
                    if (options[j].getAttribute('value') == elementIdentifier) {
                        elementName = options[j].innerHTML;
                    }
                }
                var newDesignation = document.querySelector('.designation_input').value;
                var required = document.querySelector('.selector_input').checked;

                var element = {
                    elementName, elementIdentifier, newDesignation, required
                }
                createSingleOtherElementRevisionContainer(element, true);
            }
        }
    });
}

function createSingleOtherElementRevisionContainer(element, current) {
    var otherElementsInputsContainer = current ? document.querySelector('.oak_other_elements_revision_inputs') : document.querySelector('.oak_other_elements_actual_revision_revision_inputs');

    var singleElementDiv = document.createElement('div');
    singleElementDiv.className = 'oak_other_elements_revision_inputs__single_element_container';
    singleElementDiv.innerHTML = singleElementRevisionView;
    
    // Lets populate the inputs with the corresponding data that we found above:
    var inputs = singleElementDiv.querySelectorAll('input');
    var elementKeys = getKeys(element);
    for (var i = 0; i < elementKeys.length; i++) {
        inputs[i].value = element[elementKeys[i]];
    }

    otherElementsInputsContainer.append(singleElementDiv);
}

// For the browse revisions select button: 
browseRevisionsSelectButton();
function browseRevisionsSelectButton() {
    var revisionsButtons = document.querySelectorAll('.oak_add_element_modal_container_modal_content_revisions_content_list_of_revisions__single_revision');
    for( var i = 0; i < revisionsButtons.length; i++ ) {
        revisionsButtons[i].addEventListener('click', function() {
            for (var j = 0; j < revisionsButtons.length; j++) {
                revisionsButtons[j].classList.remove('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
            }
            this.classList.add('oak_object_model_add_formula_modal_container_modal_content_revisions_content_list_of_revisions__single_revision_selected');
            document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container').classList.remove('oak_hidden');

            // Updating the selected revision fields:
            var selectedRevision = DATA.revisions[this.getAttribute('index')];
            revision = selectedRevision;

            for (var m = 0; m < properties.length; m++) {
                if ( properties[m].name != 'revision_number' ) {
                    document.querySelector('.oak_revision_' + properties[m].name + '_field').value = selectedRevision[table + '_' + properties[m].name];
                    checkEquals(document.querySelector('.oak_revision_' + properties[m].name + '_field_current').value, document.querySelector('.oak_revision_' + properties[m].name + '_field').value, document.querySelector('.oak_revision_' + properties[m].name + '_field'));
                }
            }

            if (DATA.otherElementProperties) {
                var singleElementsRevisionsContainers = document.querySelector('.oak_other_elements_actual_revision_revision_inputs').querySelectorAll('.oak_other_elements_revision_inputs__single_element_container');
                for (var i = 0; i < singleElementsRevisionsContainers.length; i++) {
                    singleElementsRevisionsContainers[i].remove();
                }

                for (var j = 0; j < DATA.otherElementProperties.associative_tab_instances.length; j++) {
                    if ( selectedRevision[table + '_revision_number'] == DATA.otherElementProperties.associative_tab_instances[j][table + '_revision_number'] ) {
                        // Lets get the other Element real name
                        var name = '';
                        for (var k = 0; k < DATA.otherElementProperties.elements.length; k++) {
                            if (DATA.otherElementProperties.elements[k][DATA.otherElementProperties.table + '_identifier'] == DATA.otherElementProperties.associative_tab_instances[j][DATA.otherElementProperties.table + '_identifier']) {
                                name = DATA.otherElementProperties.elements[k][DATA.otherElementProperties.table + '_designation'];
                            }
                        }
                        var otherElementData = {
                            name,
                            identifier: DATA.otherElementProperties.associative_tab_instances[j][DATA.otherElementProperties.table + '_identifier'],
                            renaming: DATA.otherElementProperties.associative_tab_instances[j][DATA.otherElementProperties.table + '_designation'],
                            required: DATA.otherElementProperties.associative_tab_instances[j][DATA.otherElementProperties.table + '_required'],
                        } 
                        createSingleOtherElementRevisionContainer(otherElementData, false);
                    }
                }
            }
            
            
        });
    }
}

function checkEquals(value1, value2, field) {
    if (value1 == value2) {
        field.classList.remove('oak_error');
    } else {
        field.classList.add('oak_error');
    }
}

var getKeys = function(obj){
    var keys = [];
    for(var key in obj){
       keys.push(key);
    }
    return keys;
}

// Everything related to performance results: 
var singlePerformanceResultModel;
handlePerformanceResults();
function handlePerformanceResults() {
    if (DATA.table == 'performance') {
        singlePerformanceResultModel = document.querySelector('.oak_single_performance_result').innerHTML;
        document.querySelector('.oak_single_performance_result').remove();
    }
}

initializePerformancesResults();
function initializePerformancesResults() {
    if (DATA.table == 'performance' && DATA.revisions.length >= 1) {
        var performanceResults = [];
        if (DATA.revisions[DATA.revisions.length - 1].performance_results) {
            performanceResults = DATA.revisions[DATA.revisions.length - 1].performance_results.split('|');
        } 
        for (var i = 0; i < performanceResults.length; i++) {
            var attributes = performanceResults[i].split(':');

            addPerformanceResult({
                year: attributes[0],
                goal: attributes[1],
                estimation: attributes[2],
                noValue: attributes[3]
            });
        }
    }
}

handlePerformanceResultAddButton();
function handlePerformanceResultAddButton() {
    if (DATA.table == 'performance') {
        document.querySelector('.oak_performance_result_add_button').addEventListener('click', function() {
            addPerformanceResult();
            // performanceResultsContainer.innerHTML = performanceResultsContainer.innerHTML + singlePerformanceResult;
        });
    }
} 

function addPerformanceResult(data) {
    var performanceResultsContainer = document.querySelector('.oak_performance_results_container');
    var singlePerformanceResult = document.createElement('div');
    singlePerformanceResult.className = 'oak_other_elements_single_elements_container__single_element_not_checked oak_single_performance_result oak_add_element_container__horizontal_container';
    singlePerformanceResult.innerHTML = singlePerformanceResultModel;
    performanceResultsContainer.append(singlePerformanceResult);
    if (data) {
        singlePerformanceResult.querySelector('.performance_goal_year_input').value = data.year;
        singlePerformanceResult.querySelector('.performance_goal_input').value = data.goal;
        singlePerformanceResult.querySelector('.performance_estimated_input').checked = data.estimation == 'true' ? true : false;
        singlePerformanceResult.querySelector('.performance_no_value_input').checked = data.noValue == 'true' ? true : false;
    }
    textFieldsAnimations();
    handleOtherElementsCheckboxes();
}

// Everything related to other elements (table relationships like forms using fields and models using forms)
var singleElementContainer;
if (DATA.otherElementProperties) 
    getSingleElementContainer();
function getSingleElementContainer() {
    singleElementContainer = document.querySelector('.oak_other_elements_single_elements_container__single_element').innerHTML;
    document.querySelector('.oak_other_elements_single_elements_container__single_element').remove();
}

if (DATA.otherElementProperties)
    initializeElements();
function initializeElements() {
    if (DATA.revisions.length > 0) {
        // Lets remove all the already existing other elements:
        var otherElementsContainers = document.querySelectorAll('.oak_other_elements_single_elements_container__single_element');
        for (var i = 0; i < otherElementsContainers.length; i++) {
            otherElementsContainers[i].remove();
        }

        var otherElements = DATA.otherElementProperties.associative_tab_instances;
        // Lets look for the revision which language is the selected one: 
        var theRevision = DATA.revisions[DATA.revisions.length - 1];
        for (var i = 0; i < DATA.revisions.length; i++) {
            if (DATA.revisions[i][DATA.table + '_content_language'] == document.querySelector('.oak_system_bar__languages_select').value) {
                theRevision = DATA.revisions[i];
            }
        }
        for (var i = 0; i < otherElements.length; i++) {
            if ( otherElements[i][table + '_identifier'] == theRevision[table + '_identifier'] 
                && otherElements[i][table + '_revision_number'] == theRevision[table + '_revision_number'] ) {
                    addOtherElement(otherElements[i]);
            }
        }
    }
}

if (DATA.otherElementProperties)
    addOtherElementButton();
function addOtherElementButton() {
    document.querySelector('.oak_other_elements_container__add_button').addEventListener('click', function() {
        addOtherElement();
    });
}

function addOtherElement(data) {
    var otherElementsContainer = document.querySelector('.oak_other_elements_container');
    var newElement = document.createElement('div');
    newElement.className = 'oak_other_elements_single_elements_container__single_element oak_other_elements_single_elements_container__single_element_not_checked';
    newElement.innerHTML = singleElementContainer;

    // If it's a model, we are gonna allow fields renaming: 
    if (DATA.table == 'model') {
        if (data) {
            addFieldsListToSelectedModelForm(data.form_identifier, newElement.querySelector('.oak_model_fields_renaming_container'), true);
        }
        // We are gonna add the listener for the selector change: 
        var elementsSelect = newElement.querySelector('.oak_other_elements_select');
        elementsSelect.addEventListener('change', function() {
            var formIdentifier = this.value;
            for (var i = 0; i < DATA.otherElementProperties.associative_tab_instances.length; i++) {
                // if (DATA.otherElementProperties.associative_tab_instances[i].form_identifier == formIdentifier 
                    /*&& DATA.otherElementProperties.associative_tab_instances[i].model_revision_number == DATA.revisions[DATA.revisions.length - 1].model_revision_number ) { */
                        addFieldsListToSelectedModelForm(formIdentifier, this.parentNode.parentNode.parentNode.querySelector('.oak_model_fields_renaming_container'), false);
                        textFieldsAnimations();
                // }
            }
        });
    }

    otherElementsContainer.append(newElement);

    if (data) {
        var elementsSelect = newElement.querySelector('.oak_other_elements_select');
        elementsSelect.value = data[DATA.otherElementProperties.table + '_identifier'];
        newElement.querySelector('.designation_input').value = data[DATA.otherElementProperties.table + '_designation'];
        newElement.querySelector('.selector_input').checked = data[DATA.otherElementProperties.table + '_required'] == 'true' ? true : false;
    }

    handleOtherElementsCheckboxes();
    textFieldsAnimations();
    handleOtherElementsFilters();
}

function addFieldsListToSelectedModelForm(formIdentifier, renamingContainer, fieldNameAlreadyStored) {
    renamingContainer.innerHTML = '';
    for (var i = 0; i < DATA.otherElementProperties.elements.length; i++) {
        if (DATA.otherElementProperties.elements[i].form_identifier == formIdentifier) {
            var formRevisionNumber = DATA.otherElementProperties.elements[i].form_revision_number;
            for (var j = 0; j < DATA.formsAndFields.length; j++) {
                if (DATA.formsAndFields[j].form_identifier == formIdentifier && DATA.formsAndFields[j].form_revision_number == formRevisionNumber) {
                    // Found a field identifier that belongs to the current form!
                    var fieldFormName = DATA.formsAndFields[j].field_designation;
                    var fieldIdentifier = DATA.formsAndFields[j].field_identifier;
                    var counter = DATA.fields.length - 1;
                    var foundTheField = false;
                    do {
                        if (DATA.fields[counter].field_identifier == fieldIdentifier) {
                            foundTheField = true;
                            var fieldOriginalName = DATA.fields[counter].field_designation;
                            var fieldName = fieldFormName == '' ? fieldOriginalName : fieldFormName;
                            if (fieldNameAlreadyStored) {
                                fieldName = DATA.revisions[DATA.revisions.length - 1].model_fields_names.split('|')[numberOfExistingRenamingInputs];
                            }

                            numberOfExistingRenamingInputs++;
                            var fieldContainer = document.createElement('div');
                            fieldContainer.className = 'oak_text_field_container';
                            fieldContainer.innerHTML = '<input type="text" value="" class="oak_text_field oak_model_field_renaming_input">'
                            + '<span class="oak_text_field_placeholder">Nouvelle Désignation</span>'
                            + '<div class="text_field_line"></div>'
                            + '<span class="text_field_description"></span>'
                            fieldContainer.querySelector('.text_field_description').innerHTML = fieldOriginalName;
                            fieldContainer.querySelector('input').value = fieldName;
                            renamingContainer.append(fieldContainer);
                        }
                        counter--;
                    } while (counter >= 0 && !foundTheField);
                }
            }
        }
    }
}

handleOtherElementsCheckboxes();
function handleOtherElementsCheckboxes() {
    var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', function() {
            checkboxClickListener(this);
        });
    }
}

function checkboxClickListener(checkbox) {
    var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
    if (checkbox.checked) {
        checkbox.parentNode.parentNode.classList.remove('oak_other_elements_single_elements_container__single_element_not_checked');
    } else {
        checkbox.parentNode.parentNode.classList.add('oak_other_elements_single_elements_container__single_element_not_checked');
    }
    var numberOfChecked = 0;
    for (var j = 0; j < checkboxes.length; j++) {
        if (checkboxes[j].checked) 
            numberOfChecked++;
    }
    // Check the number of checked checkboxes
    var numberOfOtherSelectedElements = document.querySelector('.oak_number_of_other_selected_elements');
    if (numberOfOtherSelectedElements)
        numberOfOtherSelectedElements.innerHTML = numberOfChecked;
    var elementHeadder = document.querySelector('.oak_element_header');
    var otherElementsButtons = document.querySelector('.oak_element_header_right_other_elements_buttons');
    var elementHeaderRightButtons = document.querySelector('.oak_element_header_right');
    if (numberOfChecked == 0) {
        elementHeadder.classList.remove('oak_element_header_at_least_one_selected');
        elementHeaderRightButtons.classList.remove('oak_hidden');
        otherElementsButtons.classList.add('oak_hidden');
    } else {
        elementHeadder.classList.add('oak_element_header_at_least_one_selected');
        elementHeaderRightButtons.classList.add('oak_hidden');
        otherElementsButtons.classList.remove('oak_hidden');
    }
}

function handleOtherElementsFilters() {
    for (var i = 0; i < DATA.otherElementProperties.filters.length; i++) {
        var selects = document.querySelectorAll('.' + DATA.otherElementProperties.filters[i].filter_name);
        for (var j = 0; j < selects.length; j++) {
            selects[j].addEventListener('change', function() {
                filterOtherElements(this.parentNode.parentNode.parentNode);
            });
        }
    }
}

function filterOtherElements(otherElementContainer) {
    var otherElementsOptions = otherElementContainer.querySelector('.oak_other_elements_select').querySelectorAll('option');
    for (var j = 0; j < otherElementsOptions.length; j++) {
        hide = false;
        for (var i = 0; i < DATA.otherElementProperties.filters.length; i++) {
            var filterValue = otherElementContainer.querySelector('.' + DATA.otherElementProperties.filters[i].filter_name).value;
            if (filterValue != 0) {
                for (var m = 0; m < DATA.otherElementProperties.elements.length; m++) {
                    if (DATA.otherElementProperties.elements[m][DATA.otherElementProperties.table + '_identifier'] == otherElementsOptions[j].value) {
                        if (DATA.otherElementProperties.elements[m][DATA.otherElementProperties.filters[i].name_in_database] != filterValue) {
                            hide = true;
                        }
                    }
                }
            } 
        }
        if (hide) {
            otherElementsOptions[j].classList.add('oak_hidden');
        } else {
            otherElementsOptions[j].classList.remove('oak_hidden');
        }
    }
}

// Handle select filters: 
handleSelectFilters();
function handleSelectFilters() {
    var filtersContainers = document.querySelectorAll('.oak_select_container__filters_container');
    for (var i = 0; i < filtersContainers.length; i++) {
        var theActualSelect = filtersContainers[i].parentNode.querySelector('select');
        var singleFilters = filtersContainers[i].querySelectorAll('select');
        for (var j = 0; j < singleFilters.length; j++) {
            singleFilters[j].addEventListener('change', function() {
                var theActualSelectOptions = theActualSelect.querySelectorAll('option');
                for (var k = 0; k < theActualSelectOptions.length; k++) {
                    var hide = false;
                    var allFilters = this.parentNode.parentNode.querySelectorAll('select');
                    for (var m = 0; m < allFilters.length; m++) {
                        var propertyName = allFilters[m].getAttribute('property-name');
                            // console.log('value: ', theActualSelectOptions[k].getAttribute(propertyName));
                            // console.log('filter value: ', allFilters[m].value);
                        if (theActualSelectOptions[k].getAttribute(propertyName) != allFilters[m].value && theActualSelectOptions[k].getAttribute(propertyName) != null && allFilters[m].value != 0) {
                            hide = true;
                        }
                    }
                    if (hide) {
                        theActualSelectOptions[k].classList.add('oak_hidden');
                    } else {
                        theActualSelectOptions[k].classList.remove('oak_hidden');
                    }
                }
            })
        }
    }
}

// Get select filters views:
var selectFiltersViews = [];
getSelectFilterViews();
function getSelectFilterViews() {
    var selectFiltersSingleElements = document.querySelectorAll('.oak_select_container_with_filters__single_element');
    for (var i = 0; i < selectFiltersSingleElements.length; i++) {
        selectFiltersViews.push(selectFiltersSingleElements[i].innerHTML);
        if ( selectFiltersSingleElements[i].getAttribute('can-add-more') == 'true' )
            selectFiltersSingleElements[i].remove();
        handleSelectFilters();
    }
}

initializeSelectFilters();
function initializeSelectFilters() {
    var numberOfPropertiesWithSelectFilters = 0;
    if ( DATA.revisions.length > 0 ) {
        for(var i = 0; i < properties.length; i++) {
            if (properties[i].input_type == 'select_with_filters') {
                var theContainer = document.querySelector('.oak_select_container_with_filters_for_' + properties[i].name);
                // Remove what's already in there in case we can't add a new selector: 
                var alreadyExistingEmptySingleElement = theContainer.querySelector('.oak_select_container_with_filters__single_element');
                if (alreadyExistingEmptySingleElement) {
                    alreadyExistingEmptySingleElement.remove();
                }

                var lastRevisionValues = DATA.revisions[DATA.revisions.length - 1][DATA.table + '_' + properties[i].name] ? DATA.revisions[DATA.revisions.length - 1][DATA.table + '_' + properties[i].name].split('|') : [];
                for(var k = 0; k < lastRevisionValues.length; k++) {
                    var newSingleElement = document.createElement('div');
                    newSingleElement.className = 'oak_select_container_with_filters__single_element';
                    newSingleElement.innerHTML = selectFiltersViews[numberOfPropertiesWithSelectFilters];
                    theContainer.append(newSingleElement);
                    newSingleElement.querySelector('.oak_select_container_with_filters_single_element__data_select').value = lastRevisionValues[k];
                    handleSelectFilters();
                }
                numberOfPropertiesWithSelectFilters++;
            }
        }
    }
}

// For the select filters add button
selectFiltersAddButtons();
function selectFiltersAddButtons() {
    var addButtons = document.querySelectorAll('.oak_select_container_with_filters__add_button');
    for (var i =0; i < addButtons.length; i++) {
        addButtons[i].setAttribute('index', i);
        addButtons[i].addEventListener('click', function() {
            var newSingleElement = document.createElement('div');
            newSingleElement.className = 'oak_select_container_with_filters__single_element';
            newSingleElement.innerHTML = selectFiltersViews[this.getAttribute('index')];
            this.parentNode.append(newSingleElement);
            handleSelectFilters();
        })
    }
}

// For the cancel button on the header: 
headerCancelButton();
function headerCancelButton() {
    var cancelButton = document.querySelector('.oak_menu_icon__cancel_icon');
    cancelButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
        var numberOfChecked = 0;
        for (var j = 0; j < checkboxes.length; j++) {
            if (checkboxes[j].checked) 
                numberOfChecked++;
        }
        if (numberOfChecked == 0) {
            additionalData = '';
            if (DATA.elementsType == 'objects') 
                additionalData = '&model_identifier=' + DATA.tableInPlural;
            else if ( DATA.elementsType == 'terms' )
                additionalData = '&taxonomy_identifier=' + DATA.tableInPlural;

            window.location.replace(DATA.adminUrl + '?page=oak_elements_list&elements=' + DATA.elementsType + '&listorformula=list' + additionalData + '&whichpage=0');
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
                checkboxClickListener(checkboxes[i]);
            }
        }
    });
}

// For other elements Delete button 
otherElementsDeleteButton();
function otherElementsDeleteButton() {
    var deleteButton = document.querySelector('.oak_other_elements_delete_button');
    deleteButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkboxes[i].checked = false;
                checkboxClickListener(checkboxes[i]);
                checkboxes[i].parentNode.parentNode.remove();
            }
                
        }
    });
}

otherElementsCopyButton();
function otherElementsCopyButton() {
    var copyButton = document.querySelector('.oak_other_elements_copy_button');
    copyButton.addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('.oak_add_other_elements_list_single_element__chekcbox');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                var otherElementsContainer = document.querySelector('.oak_other_elements_container');
                var newElement = document.createElement('div');
                newElement.className = 'oak_other_elements_single_elements_container__single_element oak_other_elements_single_elements_container__single_element_not_checked';
                newElement.innerHTML = singleElementContainer;
                newElement.querySelector('.designation_input').value = checkboxes[i].parentNode.parentNode.querySelector('.designation_input').value;
                newElement.querySelector('.selector_input').checked = checkboxes[i].parentNode.parentNode.querySelector('.selector_input').checked;
                newElement.querySelector('.oak_other_elements_select').value = checkboxes[i].parentNode.parentNode.querySelector('.oak_other_elements_select').value;

                otherElementsContainer.append(newElement);

                handleOtherElementsCheckboxes();
                textFieldsAnimations();
            }
        }
    });
}

// Initialize the images/files after page load: 
initializeImageMediaModals();
var lastClickedCallingSelector;
function initializeImageMediaModals() {
    var allCallingSelectors = document.querySelectorAll('.oak_calling_selector_image');
    for (var i = 0; i < allCallingSelectors.length; i++) {
        allCallingSelectors[i].addEventListener('click', function() {
            lastClickedCallingSelector = this;
        });
        
        var callingSelector = '.calling_selector_' + allCallingSelectors[i].getAttribute('property-name');
        var mm = new MediaModal(
            {
                calling_selector : callingSelector,
                cb : function(attachments) {
                    var attachment = attachments[0];
                    lastClickedCallingSelector.parentNode.querySelector('img').setAttribute('src', attachment.sizes.full.url)
                }
            },
            {
                title : 'Choisir une image',
                button : {
                text : 'Selectionner une image'
                },
                library : {
                type : "image"
                }
            }
        );
    }
}

initializeFilesMediaModals();
var lastClickedFileCallingSelector;
function initializeFilesMediaModals() {
    var allCallingSelectors = document.querySelectorAll('.oak_calling_selector_file');
    for (var i = 0; i < allCallingSelectors.length; i++) {
        allCallingSelectors[i].addEventListener('click', function() {
            lastClickedFileCallingSelector = this;
        });
        
        var callingSelector = '.calling_selector_' + allCallingSelectors[i].getAttribute('property-name');
        var mm = new MediaModal(
            {
                calling_selector : callingSelector,
                cb : function(attachments) {
                    var ids = jQuery.map(attachments, function(attachment){
                        return attachment.id;
                    });
                    ids = JSON.stringify(ids);
                    lastClickedFileCallingSelector.parentNode.querySelector('input').setAttribute('value', attachments[0].url);
                }
            },
            {
                multiple: true,
                library : {
                  type : "application/pdf"
                }
              }
        );
    }
}

// For the conditions:
handlePropertiesConditions();
function handlePropertiesConditions() {
    for (var i = 0; i < DATA.properties.length; i++) {
        if (DATA.properties[i].condition) {
            var propertyInput = document.querySelector('.' + DATA.table + '_' + DATA.properties[i].name + '_input');
            propertyInput.setAttribute('name', DATA.properties[i].name);
            conditionListener(propertyInput);
            propertyInput.addEventListener('change', function() {
                conditionListener(this);
            });
        }
    }
}

function conditionListener(input) {
    for (var j = 0; j < DATA.properties.length; j++) {
        if (DATA.properties[j].depends) {
            var hide = false;
            var doesDepend = false;
            for (var m = 0; m < DATA.properties[j].depends.length; m++) {
                var conditionInput = document.querySelector('.' + DATA.table + '_' + DATA.properties[j].depends[m].name + '_input');
                var newValue = conditionInput.value == 'on' ? conditionInput.checked.toString() : conditionInput.value;
                if (DATA.properties[j].depends[m].values.indexOf(newValue) == -1) {
                    hide = true;
                }
                if (DATA.properties[j].depends[m].name == input.getAttribute('name')) {
                    doesDepend = true;
                }
            }
            if (doesDepend) {
                if (hide) {
                    document.querySelector('.' + DATA.table + '_' + DATA.properties[j].name + '_input').parentNode.parentNode.classList.add('oak_hidden');
                } else {
                    document.querySelector('.' + DATA.table + '_' + DATA.properties[j].name + '_input').parentNode.parentNode.classList.remove('oak_hidden');
                }
            }
            
        }
    }
}

// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');
    var cancelButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_cancel_button_container__text');
    var confirmButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    if (adding) {
        confirmButtonSpan.innerHTML = 'Ajouter';
        confirmButtonContainer.classList.remove('oak_hidden');
        cancelButtonSpan.innerHTML = 'Annuler';
    }
    if (canceling || updating) {
        confirmButtonSpan.innerHTML = 'Oui';
        cancelButtonSpan.innerHTML = 'Non';
        confirmButtonContainer.classList.remove('oak_hidden');
    }
    var modalContainer = document.querySelector('.oak_add_element_modal_container__modal');
    var revisionsContent = document.querySelector('.oak_add_element_modal_container_modal_content__revisions_content');
    if (browsingRevisions) {
        confirmButtonSpan.innerHTML = 'Importer';
        cancelButtonSpan.innerHTML = 'Annuler';
        confirmButtonContainer.classList.add('oak_hidden');
        modalContainer.classList.add('oak_object_model_add_formula_modal_container_modal__big_modal');
        revisionsContent.classList.remove('oak_hidden');
    } else {
        modalContainer.classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        revisionsContent.classList.add('oak_hidden');
    }

    var confirmButtonSpan = document.querySelector('.oak_add_element_modal_container_modal_buttons_container_add_button_container__text');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

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

okButton();
function okButton() {
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');
    okButtonContainer.addEventListener('click', function() {
        closeModals();
    }); 
}

function closeModals() {
    setTimeout(function() {
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
        document.querySelector('.oak_add_element_modal_container_modal_content__revisions_content').classList.add('oak_hidden');
    }, 500);

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
    adding = canceling = updating = browsingRevisions = false;
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
        if (adding || updating) {
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_element',
                        'element': JSON.stringify(elementData),
                        'table': table,
                        'tableInPlural': DATA.tableInPlural,
                        'fromRevision': false,
                        'properties': DATA.properties
                    },
                    success: function(data) {
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            });
        }
        if (canceling) {
            window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
        }
        if (browsingRevisions) {
            var revisionWithoutId = {}; 
            var revisionKeys = getKeys(revision);
            for(var i = 0; i < revisionKeys.length; i++) {
                if (revisionKeys[i] != 'id') {
                    revisionWithoutId[revisionKeys[i]] = revision[revisionKeys[i]];
                }
            }
            closeModals();
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_register_element',
                        'element': JSON.stringify(revisionWithoutId),
                        'table': table,
                        'tableInPlural': DATA.tableInPlural,
                        'fromRevision': true
                    },
                    success: function(data) {
                        doneLoading();
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            })
        }
    });

    var cancelButton = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

function backToList() {
    window.location.replace(DATA.adminUrl + 'admin.php?page=oak_fields_list');
}