// Global variables:
var specificFieldName = '';
var addingSpecificField = false;
var deletingObjectModel = false;
var ObjectModelToDelete = '';
var allCPTs = DATA.customPostTypes;


// For the save button
var addObjectModelButton = document.querySelector('.oak_object_model_add_formula__save');
addObjectModelButton.addEventListener('click', function() {
    var slug = document.querySelector('.oak_object_model_add_formula_element__slug').value;
    var name = document.querySelector('.oak_object_model_add_formula_element__name').value;
    var singleName = document.querySelector('.oak_object_model_add_formula_element__singular_name').value;
    var description = document.querySelector('.oak_object_model_add_formula_element__description').value;
    var icon = document.querySelector('.oak_object_model_add_formula_element__icon').value;

    objectModelAlreadyExists = false;
    for (i = 0; i < DATA.customPostTypes.length; i++) {
        // if (DATA.taxonomies[i].)
        if (DATA.customPostTypes[i] == slug.value) 
            objectModelAlreadyExists = true;
    }
    if (slug.trim() == '') {
        openModal('Vous n’avez pas entré le Slug de la taxonomie !', false);
    } else if (objectModelAlreadyExists)
        openModal('Le Custom Post Type' + slug.value + 'existe déjà !', false);
    else if (name.trim() == '') {
        openModal('Vous n’avez pas entré le Nom de la taxonomie !', false);
    } else if (singleName.trim() == '') {
        openModal('Vous n’avez pas entré le Nom au singulier du custom post type !', false);
    } else {
        setLoading();
        slug.innerHTML = '';
        name.innerHTML = '';
        singleName.innerHTML = '';
        description.innerHTML = '';
        icon.innerHTML = '';

        // Lets get the specific fields: 
        var specificFieldsContainer = document.querySelector('.oak_object_model_add_formula_element__specific_fields_container');
        var fieldsLabels = specificFieldsContainer.querySelectorAll('label');
        var fields = '';
        for (var i = 0; i < fieldsLabels.length; i++) {
            var types = '';
            if (fieldsLabels[i].innerHTML.indexOf('select') != -1 || fieldsLabels[i].innerHTML.indexOf('Select') != -1) {
                // This is a select 
                var typesInputs = document.querySelectorAll('.oak_tax_add_formula_element_specific_fields_container__single_field_container')[i].querySelectorAll('.oak_tax_add_formula_element_specific_fields_container_single_field_container_types_container_single_type__');
                for (var j = 0; j < typesInputs.length; j++) {
                    var delimiterToAdd = j == 0 ? '' : '|';
                    types += delimiterToAdd + typesInputs[j].value;
                }
            }
            fields += fieldsLabels[i].innerHTML + ':' + types + ',';
        }

        var publication = document.querySelector('.oak_object_model_add_formula_element__select_publication').value;

        indicators = jQuery('.oak_object_model_add_formula_element__select_indicators').val();

        cpt = { slug, name, singleName, description, icon, publication, indicators, fields };
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',

                // xhrFields: {
                //     withCredentials: true
                // },
                // crossDomain: true,
                // beforeSend: function (xhr) {
                //     xhr.setRequestHeader('Authorization', makeBaseAuth('mrtest', 'MatRep0rT17'));
                // },

                data: {
                    'action': 'oak_save_cpt',
                    'data': cpt
                },
                success: function(data) {
                    doneLoading();
                    allCPTs.push(cpt);
                    addCPTUI(cpt);
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        })
    }
});


function makeBaseAuth (user, pswd) { 
    var token = user + ':' + pswd;
    var hash = "";
    if (btoa) {
       hash = btoa(token);
    }
    return "Basic " + hash;
}

function addCPTUI(cpt) {
    var cptList = document.querySelector('.oak_object_model__custom_post_types_lists');
    var div = document.createElement('div');
    div.className = 'oak_object_model__custom_post_types_lists__single_post_type_container';

    var cptName = document.createElement('span');
    cptName.className = 'oak_object_model__custom_post_types_lists_single_post_type_container__name';
    cptName.innerHTML = cpt.slug;

    var icon = document.createElement('i');
    icon.className = 'oak_object_model__custom_post_types_lists_single_post_type_container__delete_button fas fa-minus';
    icon.addEventListener('click', function() {
        deleteCPT(this);
    });

    div.append(cptName);
    div.append(icon);

    cptList.append(div);
}
// Done with the save button

manageSpecificFields();
function manageSpecificFields() {
    var fieldContainers = document.querySelectorAll('.oak_object_model_add_formula_element__field_container');
    var specificFieldsContainer = document.querySelector('.oak_object_model_add_formula_element__specific_fields_container');
    for (var i = 0; i < fieldContainers.length; i++) {
        fieldContainers[i].setAttribute('index', i);
        fieldContainers[i].addEventListener('click', function() {
            var index = this.getAttribute('index');
            fieldContainers[index].classList.add('oak_object_model_add_formula_element__field_container_already_added');
            var fieldName = fieldContainers[index].querySelector('.oak_object_model_add_formula_element_field_container__field_name').innerHTML;
            if (specificFieldsContainer.innerHTML.indexOf(fieldName) != -1) {
                addingSpecificField = true;
                specificFieldName = fieldName;
                openModal('Le champs a déjà été ajouté. Êtes vous sûr de vouloir continuer?', true)
            } else {
                addSpecificField(fieldName);
            }
        });
    }
}


// Adding a specific field
function addSpecificField(fieldName) {
    var specificFieldsContainer = document.querySelector('.oak_object_model_add_formula_element__specific_fields_container');
    var existingFields = specificFieldsContainer.querySelectorAll('.oak_object_model_add_formula_element_specific_fields_container__single_field_container');
    var fieldId = existingFields.length + 1;
    specificFieldsContainer.append(specificFieldView(fieldName, fieldId));
}

function specificFieldView(specificFieldName, fieldId) {

    var container = document.createElement('div');
    container.className = 'oak_object_model_add_formula_element_specific_fields_container__single_field_container';
    container.setAttribute('field-id', 'oak-field-' + fieldId);

    var fieldLabel = document.createElement('label');
    fieldLabel.className = 'oak_object_model_add_formula_element_specific_field_name'; 
    fieldLabel.setAttribute('for', 'single_name');

    fieldLabel.innerHTML = specificFieldName;

    var deleteFieldButton = document.createElement('i');
    deleteFieldButton.className = 'fas fa-minus oak_object_model_add_formula_element_specific_field_delete_button';
    deleteFieldButton.addEventListener('click', function() {
        this.parentNode.remove();
    });

    container.append(fieldLabel);
    container.append(deleteFieldButton);

    if (specificFieldName.indexOf('select') != -1 || specificFieldName.indexOf('Select') != -1 ) {
        var typesContainer = document.createElement('div');
        typesContainer.className = 'oak_object_model_add_formula_element_specific_fields_container_single_field_container__types_container';
        typesContainer.setAttribute('field-id', fieldId);

        container.append(createSingleTypeContainer());

        var addContainer = document.createElement('oak_object_model_add_formula_element_specific_fields_container_single_field_container__plus_container');
        addContainer.className = 'oak_object_model_add_formula_element_specific_fields_container_single_field_container__plus_container';

        addContainer.addEventListener('click', function() {
            var singleTypeContainer = createSingleTypeContainer();
            this.parentNode.insertBefore(singleTypeContainer, this);
        });
        // var insertedNode = parentNode.insertBefore(newNode, referenceNode);

        var addSpan = document.createElement('span');
        addSpan.innerHTML = 'Ajouter';

        var addIcon = document.createElement('i');
        addIcon.className = 'fas fa-plus';

        addContainer.append(addSpan);
        addContainer.append(addIcon);

        container.append(addContainer);
    }

    return container;
}

function createSingleTypeContainer() {
    var singleTypeContainer = document.createElement('div');
    singleTypeContainer.className = 'oak_object_model_add_formula_element_specific_fields_container_single_field_container_types_container__single_type';

    var singleTypeInput = document.createElement('input');
    singleTypeInput.className = 'oak_object_model_add_formula_element_specific_fields_container_single_field_container_types_container_single_type__';
    singleTypeInput.type = 'text';

    var deleteButton = document.createElement('i');
    deleteButton.className = 'fas fa-minus';
    // deleteButton.setAttribute('field-id', fieldId);
    deleteButton.addEventListener('click', function() {
        this.parentElement.remove();
    });

    singleTypeContainer.append(singleTypeInput);
    singleTypeContainer.append(deleteButton);

    return singleTypeContainer;
}






// Everything related to our modal:
function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    if (addingSpecificField) {
        confirmButtonSpan.innerHTML = 'Ajouter';
    } 
    if (deletingObjectModel) {
        confirmButtonSpan.innerHTML = 'Supprimer';
    }

    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_object_model_add_formula_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
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

var okButtonContainer = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function() {
    closeModals();
}); 

function closeModals() {
    addingSpecificField = false;
    deletingObjectModel = false;
    var modalsContainer = document.querySelector('.oak_object_model_add_formula_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
}

function setLoading() {
    openModal();
    document.querySelector('.oak_loader').classList.remove('oak_hidden');
    document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.add('oak_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.oak_loader').classList.add('oak_hidden');
        document.querySelector('.oak_object_model_add_formula_modal_container__modal').classList.remove('oak_hidden');
    }, 1000);
}

handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        if (addingSpecificField) {
            addSpecificField(specificFieldName);
            closeModals();
        }
        if (deletingObjectModel) {
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'oak_delete_cpt',
                        'data': ObjectModelToDelete
                    },
                    success: function(data) {
                        doneLoading();
                        var cptsContainers = document.querySelectorAll('.oak_object_model__custom_post_types_lists__single_post_type_container');
                        for (var i = 0; i < cptsContainers.length; i++) {
                            var cptName = cptsContainers[i].querySelector('span');
                            if (cptName.innerHTML == ObjectModelToDelete) {
                                cptsContainers[i].remove();
                            }
                        }
                        // console.log(data);
                    },
                    error: function(error) {
                        doneLoading();
                    }
                });
            })
        }
    });

    var cancelButton = document.querySelector('.oak_object_model_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}

// Handling delete custom post types buttons: 
handleDeleteCustomPostTypes();
function handleDeleteCustomPostTypes() {
    var deleteButtons = document.querySelectorAll('.oak_object_model__custom_post_types_lists_single_post_type_container__delete_button');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            deleteCPT(this);
        });
    }
}

function deleteCPT(element) {
    var slugName = element.parentNode.querySelector('span').innerHTML;
    ObjectModelToDelete = slugName;
    deletingObjectModel = true;
    openModal('Êtes vous sûr de vouloir supprimer le modèle ' + slugName + '?', true); 
}
