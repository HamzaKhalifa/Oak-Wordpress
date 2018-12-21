// Global variables:
var specificFieldName = '';
var addingSpecificField = false;
var deletingTaxonomy = false;
var taxonomyToDelete = '';

var addTaxButton = document.querySelector('.dawn_tax_add_formula__add_button');
addTaxButton.addEventListener('click', function() {
    var slug = document.querySelector('.dawn_tax_add_formula_element__slug').value;
    var name = document.querySelector('.dawn_tax_add_formula_element__name').value;
    var singleName = document.querySelector('.dawn_tax_add_formula_element__single_name').value;

    taxAlreadyExists = false;
    for (i = 0; i < DATA.taxonomies.length; i++) {
        // if (DATA.taxonomies[i].)
        if (DATA.taxonomies[i].name == slug.value) 
            taxAlreadyExists = true;
    }
    if (slug.trim() == '') {
        openModal('Vous n’avez pas entré le Slug de la taxonomie !', false);
    } else if (taxAlreadyExists)
        openModal('Le taxonomie' + slug.value + 'existe déjà !', false);
    else if (name.trim() == '') {
        openModal('Vous n’avez pas entré le Nom de la taxonomie !', false);
    } else if (singleName.trim() == '') {
        openModal('Vous n’avez pas entré le Nom au singulier de la taxonomie !', false);
    } else {
        setLoading();
        slug.innerHTML = '';
        name.innerHTML = '';
        singleName.innerHTML = '';

        // Lets get the specific fields: 
        var specificFieldsContainer = document.querySelector('.dawn_tax_add_formula_element__specific_fields_container');
        var fieldsLabels = specificFieldsContainer.querySelectorAll('label');
        var fields = '';
        for (var i = 0; i < fieldsLabels.length; i++) {
            var types = '';
            if (fieldsLabels[i].innerHTML.indexOf('select') != -1 || fieldsLabels[i].innerHTML.indexOf('Select') != -1) {
                // This is a select 
                var typesInputs = document.querySelectorAll('.dawn_tax_add_formula_element_specific_fields_container__single_field_container')[i].querySelectorAll('.dawn_tax_add_formula_element_specific_fields_container_single_field_container_types_container_single_type__');
                for (var j = 0; j < typesInputs.length; j++) {
                    var delimiterToAdd = j == 0 ? '' : '|';
                    types += delimiterToAdd + typesInputs[j].value;
                }
            }
            fields += fieldsLabels[i].innerHTML + ':' + types + ',';
        }

        var publication = document.querySelector('.dawn_tax_add_formula_element__select_publication').value;

        tax = { slug, name, singleName, publication, fields };
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'dawn_save_taxonomy',
                    'data': tax
                },
                success: function(data) {
                    doneLoading();
                    addTaxUI(tax);
                    // console.log(data);
                },
                error: function(error) {
                    // console.log(error);
                    doneLoading();
                }
            });
        })
    }
});

function openModal(title, twoButtons) {
    var confirmButtonSpan = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container_add_button_container__text');
    if (addingSpecificField) {
        confirmButtonSpan.innerHTML = 'Ajouter';
    } 
    if (deletingTaxonomy) {
        confirmButtonSpan.innerHTML = 'Supprimer';
    }

    var modalsContainer = document.querySelector('.dawn_tax_add_formula_modal_container');
    modalsContainer.classList.add('dawn_tax_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.dawn_tax_add_formula_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    var addButtonContainer = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container__ok_button_container');
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


var okButtonContainer = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container__ok_button_container');
okButtonContainer.addEventListener('click', function() {
    closeModals();
}); 

function closeModals() {
    addingSpecificField = false;
    deletingTaxonomy = false;
    var modalsContainer = document.querySelector('.dawn_tax_add_formula_modal_container');
    modalsContainer.classList.remove('dawn_tax_add_formula_modal_container__activated');
}

function setLoading() {
    openModal();
    document.querySelector('.dawn_loader').classList.remove('dawn_hidden');
    document.querySelector('.dawn_tax_add_formula_modal_container__modal').classList.add('dawn_hidden');
}

function doneLoading() {
    closeModals();
    setTimeout(function() {
        document.querySelector('.dawn_loader').classList.add('dawn_hidden');
        document.querySelector('.dawn_tax_add_formula_modal_container__modal').classList.remove('dawn_hidden');
    }, 1000);
}

function addTaxUI(taxonomy) {
    var taxList = document.querySelector('.dawn_tax_list');
    var div = document.createElement('div');
    div.className = 'dawn_taxt_list__single_taxt';

    var taxName = document.createElement('span');
    taxName.innerHTML = taxonomy.slug;

    div.append(taxName);

    taxList.append(taxName);

}

function getKeys(obj) {
    var keys = [];
    for(var key in obj){
       keys.push(key);
    }
    return keys;
}

manageSpecificFields();
function manageSpecificFields() {
    var fieldContainers = document.querySelectorAll('.dawn_tax_add_formula_element__field_container');
    var specificFieldsContainer = document.querySelector('.dawn_tax_add_formula_element__specific_fields_container');
    for (var i = 0; i < fieldContainers.length; i++) {
        fieldContainers[i].setAttribute('index', i);
        fieldContainers[i].addEventListener('click', function() {
            var index = this.getAttribute('index');
            fieldContainers[index].classList.add('dawn_tax_add_formula_element__field_container_already_added');
            var fieldName = fieldContainers[index].querySelector('.dawn_tax_add_formula_element_field_container__field_name').innerHTML;
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

function addSpecificField(fieldName) {
    var specificFieldsContainer = document.querySelector('.dawn_tax_add_formula_element__specific_fields_container');
    var existingFields = specificFieldsContainer.querySelectorAll('.dawn_tax_add_formula_element_specific_fields_container__single_field_container');
    var fieldId = existingFields.length + 1;
    specificFieldsContainer.append(specificFieldView(fieldName, fieldId));
    // specificFieldsContainer.innerHTML = specificFieldsContainer.innerHTML + specificFieldView(fieldName, fieldId);
}

function specificFieldView(specificFieldName, fieldId) {

    var container = document.createElement('div');
    container.className = 'dawn_tax_add_formula_element_specific_fields_container__single_field_container';
    container.setAttribute('field-id', 'dawn-field-' + fieldId);

    var fieldLabel = document.createElement('label');
    fieldLabel.className = 'dawn_tax_add_formula_element_specific_field_name'; 
    fieldLabel.setAttribute('for', 'single_name');

    fieldLabel.innerHTML = specificFieldName;

    var deleteFieldButton = document.createElement('i');
    deleteFieldButton.className = 'fas fa-minus dawn_tax_add_formula_element_specific_field_delete_button';
    deleteFieldButton.addEventListener('click', function() {
        this.parentNode.remove();
    });

    container.append(fieldLabel);
    container.append(deleteFieldButton);

    if (specificFieldName.indexOf('select') != -1 || specificFieldName.indexOf('Select') != -1 ) {
        var typesContainer = document.createElement('div');
        typesContainer.className = 'dawn_tax_add_formula_element_specific_fields_container_single_field_container__types_container';
        typesContainer.setAttribute('field-id', fieldId);

        container.append(createSingleTypeContainer());

        var addContainer = document.createElement('dawn_tax_add_formula_element_specific_fields_container_single_field_container__plus_container');
        addContainer.className = 'dawn_tax_add_formula_element_specific_fields_container_single_field_container__plus_container';

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
    singleTypeContainer.className = 'dawn_tax_add_formula_element_specific_fields_container_single_field_container_types_container__single_type';

    var singleTypeInput = document.createElement('input');
    singleTypeInput.className = 'dawn_tax_add_formula_element_specific_fields_container_single_field_container_types_container_single_type__';
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

// This is the selectView: 
//  <div class="dawn_tax_add_formula_element_specific_fields_container_single_field_container__types_container">
//         <div class="dawn_tax_add_formula_element_specific_fields_container_single_field_container_types_container__single_type">
//             <input type="text" class="dawn_tax_add_formula_element_specific_fields_container_single_field_container_types_container_single_type__">
//             <i class="fas fa-minus"></i>
//         </div>
        
//     </div>
//     <div class="dawn_tax_add_formula_element_specific_fields_container_single_field_container__plus_container">
//         <span><?php _e('Ajouter', Dawn::$text_domain) ?></span>
//         <i class="fas fa-plus"></i>
//     </div>

// Handling modal add and cancel buttons: 
handleModalButtons();
function handleModalButtons() {
    var confirmButton = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container__add_button_container');
    confirmButton.addEventListener('click', function() {
        if (addingSpecificField) {
            addSpecificField(specificFieldName);
            closeModals();
        }
        if (deletingTaxonomy) {
            setLoading();
            jQuery(document).ready(function() {
                jQuery.ajax({
                    url: DATA.ajaxUrl,
                    type: 'POST',
                    data: {
                        'action': 'dawn_delete_taxonomy',
                        'data': taxonomyToDelete
                    },
                    success: function(data) {
                        doneLoading();
                        var taxonomiesContainers = document.querySelectorAll('.dawn_taxt_list__single_taxt');
                        for (var i = 0; i < taxonomiesContainers.length; i++) {
                            var taxonomyName = taxonomiesContainers[i].querySelector('span');
                            if (taxonomyName.innerHTML == taxonomyToDelete) {
                                taxonomiesContainers[i].remove();
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

    var cancelButton = document.querySelector('.dawn_tax_add_formula_modal_container_modal_buttons_container__cancel_button_container');
    cancelButton.addEventListener('click', function() {
        closeModals();
    });
}


// Handling deleting taxonomies buttons:
handleDeleteTaxonomies(); 
function handleDeleteTaxonomies() {
    var deleteButtons = document.querySelectorAll('.dawn_tax_list_delete');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function() {
            var slugName = this.parentNode.querySelector('span').innerHTML;
            taxonomyToDelete = slugName;
            deletingTaxonomy = true;
            openModal('Êtes vous sûr de vouloir supprimer la taxonomie ' + slugName + '?', true); 
        });
    }
}
