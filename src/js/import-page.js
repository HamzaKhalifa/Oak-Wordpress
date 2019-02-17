var publications = [];
var allData = [];
var step = 'organization';
var selectedData = {
    organization: null,
    publication: null,
    taxonomies: [],
    terms: [],
    models: [],
    objects: [],
    forms: [],
    fields: [],
    glossaries: [],
    qualis: [],
    quantis: []
};

(function() {
    setLoading();
    jQuery(document).ready(function() {
        jQuery.ajax({
            url: DATA.centralUrl,
            type: 'POST',
            data: {
                'action': 'oak_get_all_data_for_corn',
                'data': ''
            },
            success: function(data) {
                doneLoading();
                console.log(data);
                allData = data.data;
                console.log(allData);
                populateImportContainer(
                    'Organisations',
                    allData.organizationsWithoutRedundancy, 
                    ['Nom de l\'organisation', 'Pays du siège', 'Type', 'Secteur d\'activité'],
                    ['organization_identifier', 'organization_designation', 'organization_country', 'organization_type', 'organization_sectors'],
                    'organization',
                    'organization'
                );
            },
            error: function(error) {
                console.log(error);
                doneLoading();
            } 
        });
    });

    function populateImportContainer(title, data, dataInfo, dataFields, dataType, nextStep) {
        document.querySelector('.next_button_container_next').classList.add('oak_hidden');
        document.querySelector('.screen_title').innerHTML = title;
        var importContainer = document.querySelector('.import_container');
        var styleAddedToTitle = dataType == 'organization' ? 'style="margin-left: 35px;"' : dataType == 'publication' ? 'style="margin-left: 35px;"' : '';
        var oakHidden = dataType == 'organization' ? 'oak_hidden' : dataType == 'publication' ? 'oak_hidden' : '';
        importContainer.innerHTML = '<div class="import_container__line">'
            + '<div class="import_container_line__checkbox_container">'
            + '<input type="checkbox" class="import_container__element_checkbox ' + oakHidden + '">'
            + '<h4 ' + styleAddedToTitle + ' class="import_container_line_column_value import_container_line__title">' + dataInfo[0] + '</h4>'
            + '</div>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + dataInfo[1] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + dataInfo[2] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + dataInfo[3] + '</h4>'
            + '</div>'
        for (var i = 0; i < data.length; i++) {
            var newLine = '<div class="import_container__line" identifier="' + data[i][dataFields[0]] + '">'
            + '<div class="import_container_line__checkbox_container">'
            + '<input type="checkbox" class="import_container__element_checkbox">'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[1]] + '</h4>'
            + '</div>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[2]] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[3]] + '</h4>'
            + '<h4 class="import_container_line_column_value import_container_line__title">' + data[i][dataFields[4]] + '</h4>'
            + '</div>'
            importContainer.innerHTML = importContainer.innerHTML + newLine;
        }
        checkBoxes = importContainer.querySelectorAll('.import_container__element_checkbox');
        for (var i = 0; i < checkBoxes.length; i++) {
            checkBoxes[i].setAttribute('index', i);
            checkBoxes[i].addEventListener('change', function() {
                var atLeastOneIsChecked = false;
                for (var j = 0; j < checkBoxes.length; j++) {
                    // Check only one for organization and publication
                    if ((dataType == 'organization' || dataType == 'publication') && j != this.getAttribute('index') && this.checked ) {
                        checkBoxes[j].checked = false;
                    }
                    if (checkBoxes[j].checked) {
                        atLeastOneIsChecked = true;
                    }
                }
                if (atLeastOneIsChecked)
                    document.querySelector('.next_button_container_next').classList.remove('oak_hidden');
                else
                    document.querySelector('.next_button_container_next').classList.add('oak_hidden');
            });
        }

        // Handle all checkboxes selection: 
        importContainer.querySelector('.import_container__element_checkbox').addEventListener('change', function() {
            if (this.checked) {
                var allCheckBoxes = importContainer.querySelectorAll('.import_container__element_checkbox');
                for (var i = 0; i < allCheckBoxes.length; i++) {
                    allCheckBoxes[i].checked = true;
                }
            }
        });

        step = nextStep;
    }

    (function() {
        var nextButton = document.querySelector('.next_button_container_next');
        nextButton.addEventListener('click', function() {
            switch(step) {
                case 'organization':
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var foundAChecked = false;
                    var i = 0;
                    var organizationName = ''
                    var organizationIdentifier = '';
                    do {
                        if (checkBoxes[i].checked) {
                            foundAChecked = true;
                            organizationName = checkBoxes[i].parentNode.querySelector('.import_container_line__title').innerHTML;
                            organizationIdentifier = checkBoxes[i].parentNode.parentNode.getAttribute('identifier');
                        }
                        i++;
                    } while (i < checkBoxes.length && !foundAChecked);
                    var publicationsToShow = [];
                    for (var i = 0; i < allData.publicationsWithoutRedundancy.length; i++) {
                        if (allData.publicationsWithoutRedundancy[i].publication_organization == organizationIdentifier) {
                            publicationsToShow.push(allData.publicationsWithoutRedundancy[i]);
                        }
                    }
                    for (var i = 0; i < allData.organizationsWithoutRedundancy.length; i++) {
                        if (allData.organizationsWithoutRedundancy[i].organization_identifier == organizationIdentifier) {
                            selectedData.organization = allData.organizationsWithoutRedundancy[i];
                        }
                    }
                    populateImportContainer(
                        'Publications - ' + organizationName,
                        publicationsToShow, 
                        ['Titre de la publication', 'Pays', 'Type', 'Année'],
                        ['publication_identifier', 'publication_designation', 'publication_country', 'publication_format', 'publication_year'],
                        'publication',
                        'publication'
                    );

                break;
                case 'publication':
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var foundAChecked = false;
                    var i = 0;
                    var publicationName = ''
                    var publicationIdentfier = '';
                    do {
                        if (checkBoxes[i].checked) {
                            foundAChecked = true;
                            publicationName = checkBoxes[i].parentNode.querySelector('.import_container_line__title').innerHTML;
                            publicationIdentfier = checkBoxes[i].parentNode.parentNode.getAttribute('identifier');
                        }
                        i++;
                    } while (i < checkBoxes.length && !foundAChecked);
                    for (var i = 0; i < allData.publicationsWithoutRedundancy.length; i++) {
                        if (allData.publicationsWithoutRedundancy[i].publication_identifier == publicationIdentfier) {
                            selectedData.publication = allData.publicationsWithoutRedundancy[i];
                        }
                    }
                    var taxonomiesToShow = [];
                    for (var i = 0; i < allData.taxonomiesWithoutRedundancy.length; i++) {
                        if (allData.taxonomiesWithoutRedundancy[i].taxonomy_publication == publicationIdentfier) {
                            taxonomiesToShow.push(allData.taxonomiesWithoutRedundancy[i]);
                        }
                    }
                    populateImportContainer(
                        'Taxonomies - ' + publicationName,
                        taxonomiesToShow, 
                        ['Designation', 'Structure', 'Description', 'Dérnière modification'],
                        ['taxonomy_identifier', 'taxonomy_designation', 'taxonomy_structure', 'taxonomy_description', 'taxonomy_modification_time'],
                        'taxonomy',
                        'taxonomy'
                    );
                break;
                case 'taxonomy':
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var taxonomiesIdentifiers = [];
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            taxonomiesIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    var termsToPush = [];
                    for (var i = 0; i < allData.taxonomiesWithoutRedundancy.length; i++) {
                        if (taxonomiesIdentifiers.indexOf(allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier) != -1 ) {
                            selectedData.taxonomies.push(allData.taxonomiesWithoutRedundancy[i]);
                            for (var j = 0; j < allData.allTerms.length; j++) {
                                if (allData.allTerms[j].taxonomy_identifier == allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier) {
                                    for (var n = 0; n < allData.allTerms[j].terms.length; n++) {
                                        var term = allData.allTerms[j].terms[n];
                                        term.term_taxonomy_designation = allData.taxonomiesWithoutRedundancy[i].taxonomy_designation;
                                        term.term_taxonomy_identifier = allData.taxonomiesWithoutRedundancy[i].taxonomy_identifier;
                                        termsToPush.push(term);
                                    }
                                }
                            }
                        }
                    }
                    populateImportContainer(
                        'Termes',
                        termsToPush,
                        ['Designation', 'Taxonomie', 'Description', 'Dérnière modification'],
                        ['term_identifier', 'term_designation', 'term_taxonomy_designation', 'term_description', 'term_modification_time'],
                        'term',
                        'term'
                    );
                    document.querySelector('.next_button_container_next').innerHTML = 'Sauvegarder';
                break;
                case 'term':
                    setLoading();
                    checkBoxes = document.querySelector('.import_container').querySelectorAll('.import_container__element_checkbox');
                    var termIdentifiers = [];
                    for (var i = 0; i < checkBoxes.length; i++) {
                        if (checkBoxes[i].checked) {
                            termIdentifiers.push(checkBoxes[i].parentNode.parentNode.getAttribute('identifier'));
                        }
                    }
                    for (var i = 0; i < termIdentifiers.length; i++) {
                        for (var j = 0; j < allData.allTerms.length; j++) {
                            for (var m = 0; m < allData.allTerms[j].terms.length; m++) {
                                if (termIdentifiers.indexOf(allData.allTerms[j].terms[m].term_identifier) != -1) {
                                    if (allData.allTerms[i].terms[m]) {
                                        selectedData.terms.push(allData.allTerms[j].terms[m]);
                                        // Lets get the objects associated to these terms:
                                         for(var n = 0; n < allData.termsAndObjects.length; n++) {
                                             if (allData.termsAndObjects[n].term_identifier == allData.allTerms[i].terms[m].term_identifier) {
                                                 var objectIdentifier = allData.termsAndObjects[n].object_identifier;
                                                //  Lets add that object to our list of objects
                                                 for (var k = 0; k < allData.allObjects.length; k++) {
                                                     for (var l = 0; l < allData.allObjects[k].objects.length; l++) {
                                                         if (allData.allObjects[k].objects[l].object_identifier == objectIdentifier) {
                                                            allData.allObjects[k].objects[l].model = allData.allObjects[k].model_identifier;
                                                            var exists = false;
                                                            for (var p = 0; p < selectedData.objects.length; p++) {
                                                                if (selectedData.objects[p].object_identifier == allData.allObjects[k].objects[l].object_identifier )
                                                                    exists = true;
                                                            }
                                                            if (!exists) {
                                                                selectedData.objects.push(allData.allObjects[k].objects[l]);
                                                                // if the object is added, then we are gonna add its model here: 
                                                                for (var q = 0; q < allData.modelsWihoutRedundancy.length; q++) {
                                                                    if (allData.allObjects[k].objects[l].model == allData.modelsWihoutRedundancy[q].model_identifier) {
                                                                        var exists = false;
                                                                        for (var r = 0; r < selectedData.models.length; r++) {
                                                                            if (selectedData.models[r].model_identifier == allData.modelsWihoutRedundancy[q].model_identifier) {
                                                                                exists = true;
                                                                            }
                                                                        }
                                                                        if (!exists) {
                                                                            selectedData.models.push(allData.modelsWihoutRedundancy[q]);
                                                                            var model = allData.modelsWihoutRedundancy[q];
                                                                            var forms = model.model_forms.split('|');
                                                                            for (var e = 0; e < forms.length; e++) {
                                                                                var formIdentifier = forms[e].split(':')[0];
                                                                                var exists = false;
                                                                                for (var f = 0; f < selectedData.forms.length; f++) {
                                                                                    if (selectedData.forms[f].form_identifier == formIdentifier) {
                                                                                        exists = true;
                                                                                    }
                                                                                }
                                                                                if (!exists) {
                                                                                    // Lets get the form data by form identifier
                                                                                    for (var g = 0; g < allData.formsWithoutRedundancy.length; g++) {
                                                                                        if (allData.formsWithoutRedundancy[g].form_identifier == formIdentifier) {
                                                                                            selectedData.forms.push(allData.formsWithoutRedundancy[g]);
                                                                                            // Now lets get the fields in this form: 
                                                                                            var fields = allData.formsWithoutRedundancy[g].form_fields.split('|');
                                                                                            for (var h = 0; h < fields.length; h++) {
                                                                                                var fieldIdentifier = fields[h].split(':')[0];
                                                                                                var exists = false;
                                                                                                for (var s = 0; s < selectedData.fields.length; s++) {
                                                                                                    if (selectedData.fields[s].field_identifier == fieldIdentifier) {
                                                                                                        exists = false;
                                                                                                    }
                                                                                                }
                                                                                                if (!exists) {
                                                                                                    // Lets look for the field based on its identififer:
                                                                                                    for (var t = 0; t < allData.fieldsWithoutRedundancy.length; t++) {
                                                                                                        if (allData.fieldsWithoutRedundancy[t].field_identifier == fieldIdentifier) {
                                                                                                            var theField = allData.fieldsWithoutRedundancy[t];
                                                                                                            selectedData.fields.push(theField);
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            } 
                                                         }
                                                     }
                                                 }
                                             }
                                         }
                                    }
                                }
                            }
                        }
                    }
                    // Lets get the glossaries: 
                    var publicationIdentifier = selectedData.publication.publication_identifier;
                    for (var i = 0; i < allData.glossariesWithoutRedundancy.length; i++) {
                        identifiers = allData.glossariesWithoutRedundancy[i].glossary_publication.split('|');
                        if (identifiers.indexOf(publicationIdentifier) != -1) {
                            selectedData.glossaries.push(allData.glossariesWithoutRedundancy[i]);
                        } 
                    }

                    for (var i = 0; i < allData.qualisWithoutRedundancy.length; i++) {
                        identifiers = allData.qualisWithoutRedundancy[i].quali_publication.split('|');
                        if (identifiers.indexOf(publicationIdentifier) != -1) {
                            selectedData.qualis.push(allData.qualisWithoutRedundancy[i]);
                        } 
                    }

                    for (var i = 0; i < allData.quantisWithoutRedundancy.length; i++) {
                        identifiers = allData.quantisWithoutRedundancy[i].quanti_publication.split('|');
                        if (identifiers.indexOf(publicationIdentifier) != -1) {
                            selectedData.quantis.push(allData.quantisWithoutRedundancy[i]);
                        }
                    }

                    selectedData.termsAndObjects = allData.termsAndObjects;

                    console.log('Selected data', selectedData);
                    jQuery(document).ready(function() {
                        jQuery.ajax({
                            type: 'POST',
                            url: DATA.ajaxUrl,
                            data: {
                                'selectedData': selectedData,
                                'action': 'corn_save_data'
                            },
                            success: function(data) {
                                console.log(data);
                                doneLoading();
                                // window.location.reload();
                            },
                            error: function(error) {
                                console.log(error);
                                doneLoading();
                            }
                        });
                    });
                break;
            }
        });
    })()
})();

function openModal(title, twoButtons) {
    var confirmButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__add_button_container');
    var cancelButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__cancel_button_container');
    var okButtonContainer = document.querySelector('.oak_add_element_modal_container_modal_buttons_container__ok_button_container');

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.add('oak_object_model_add_formula_modal_container__activated');

    var modalTitle = document.querySelector('.oak_add_element_modal_container_modal_title_container__title');
    modalTitle.innerHTML = title;

    if ( twoButtons) {
        confirmButtonContainer.style.display = 'flex';
        cancelButtonContainer.style.display = 'flex';
        okButtonContainer.style.display = 'none';
    } else {
        confirmButtonContainer.style.display = 'none';
        cancelButtonContainer.style.display = 'none';
        okButtonContainer.style.display = 'flex';
    }
}

function closeModals() {
    setTimeout(function() {
        document.querySelector('.oak_add_element_modal_container__modal').classList.remove('oak_object_model_add_formula_modal_container_modal__big_modal');
    }, 500);

    var modalsContainer = document.querySelector('.oak_add_element_modal_container');
    modalsContainer.classList.remove('oak_object_model_add_formula_modal_container__activated');
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