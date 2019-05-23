handleTabsClick();
function handleTabsClick() {
    var tabs = document.querySelectorAll('.nav-tab');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].setAttribute('index', i);
        tabs[i].addEventListener('click', function(e) {
            e.preventDefault();
            var index = this.getAttribute('index');
            for (var j = 0; j < tabs.length; j++) {
                tabs[j].classList.remove('nav-tab-active');
            }
            this.classList.add('nav-tab-active');

            var tabsContainers = document.querySelectorAll('.oak_tab');
            for (var i = 0; i < tabsContainers.length; i++) {
                if (containsClass(tabsContainers[i], 'oak_tab_' + index)) {
                    tabsContainers[i].classList.remove('oak_hidden');
                } else {
                    tabsContainers[i].classList.add('oak_hidden');
                }
            }
        })

        
    }
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
        
        var callingSelector = '.' + allCallingSelectors[i].getAttribute('property-name');
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

$(function() {

    var lastClickedImageButton = null; 
    function oak_calculateImageSelectOptions(attachment, controller) {
    
        var control = controller.get( 'control' );
    
        var flexWidth = !! parseInt( control.params.flex_width, 10 );
        var flexHeight = !! parseInt( control.params.flex_height, 10 );
    
        var realWidth = attachment.get( 'width' );
        var realHeight = attachment.get( 'height' );
    
        var xInit = parseInt(control.params.width, 10);
        var yInit = parseInt(control.params.height, 10);
    
        var ratio = xInit / yInit;
    
        controller.set( 'canSkipCrop', ! control.mustBeCropped( flexWidth, flexHeight, xInit, yInit, realWidth, realHeight ) );
    
        var xImg = xInit;
        var yImg = yInit;
    
        if ( realWidth / realHeight > ratio ) {
            yInit = realHeight;
            xInit = yInit * ratio;
        } else {
            xInit = realWidth;
            yInit = xInit / ratio;
        }        
    
        var x1 = ( realWidth - xInit ) / 2;
        var y1 = ( realHeight - yInit ) / 2;        
    
        var imgSelectOptions = {
            handles: true,
            keys: true,
            instance: true,
            persistent: true,
            imageWidth: realWidth,
            imageHeight: realHeight,
            minWidth: xImg > xInit ? xInit : xImg,
            minHeight: yImg > yInit ? yInit : yImg,            
            x1: x1,
            y1: y1,
            x2: xInit + x1,
            y2: yInit + y1
        };
    
        return imgSelectOptions;
    }  
    
    function oak_setImageFromURL(url, attachmentId, width, height) {
        var choice, data = {};
    
        data.url = url;
        data.thumbnail_url = url;
        data.timestamp = _.now();
    
        if (attachmentId) {
            data.attachment_id = attachmentId;
        }
    
        if (width) {
            data.width = width;
        }
    
        if (height) {
            data.height = height;
        }
    
        lastClickedImageButton.parentNode.querySelector('.oak_configuration_image_input').value = url;
        lastClickedImageButton.parentNode.querySelector('img').setAttribute('src', url);
        // $(".oak_configuration_site_logo__input").val( url );
        // $(".oak_configuration_site_logo").prop("src", url);        
    
    }
    
    function oak_setImageFromAttachment(attachment) {
    
        lastClickedImageButton.parentNode.querySelector('.oak_configuration_image_input').value = attachment.url;
        lastClickedImageButton.parentNode.querySelector('img').setAttribute('src', attachment.url);

        // $(".oak_configuration_site_logo__input").val( attachment.url );
        // $(".oak_configuration_site_logo").prop("src", attachment.url);             
    }
    
    var mediaUploader;

    function changeImageButtonListener(e, imageButton) {
        lastClickedImageButton = imageButton;
        e.preventDefault(); 
    
        /* We need to setup a Crop control that contains a few parameters
           and a method to indicate if the CropController can skip cropping the image.
           In this example I am just creating a control on the fly with the expected properties.
           However, the controls used by WordPress Admin are api.CroppedImageControl and api.SiteIconControl
        */
    
       var cropControl = {
           id: "control-id",
           params : {
             flex_width : true,  // set to true if the width of the cropped image can be different to the width defined here
             flex_height : true, // set to true if the height of the cropped image can be different to the height defined here
             width : 300,  // set the desired width of the destination image here
             height : 200, // set the desired height of the destination image here
           }
       };
    
       cropControl.mustBeCropped = function(flexW, flexH, dstW, dstH, imgW, imgH) {
    
        // If the width and height are both flexible
        // then the user does not need to crop the image.
    
        if ( true === flexW && true === flexH ) {
            return false;
        }
    
        // If the width is flexible and the cropped image height matches the current image height, 
        // then the user does not need to crop the image.
        if ( true === flexW && dstH === imgH ) {
            return false;
        }
    
        // If the height is flexible and the cropped image width matches the current image width, 
        // then the user does not need to crop the image.        
        if ( true === flexH && dstW === imgW ) {
            return false;
        }
    
        // If the cropped image width matches the current image width, 
        // and the cropped image height matches the current image height
        // then the user does not need to crop the image.               
        if ( dstW === imgW && dstH === imgH ) {
            return false;
        }
    
        // If the destination width is equal to or greater than the cropped image width
        // then the user does not need to crop the image...
        if ( imgW <= dstW ) {
            return false;
        }
    
        return true;        
    
       };      
    
        /* NOTE: Need to set this up every time instead of reusing if already there
                 as the toolbar button does not get reset when doing the following:
    
                mediaUploader.setState('library');
                mediaUploader.open();
    
        */       
    
        mediaUploader = wp.media({
            button: {
                text: 'Sélectionnez et recadrez', // l10n.selectAndCrop,
                close: false
            },
            states: [
                new wp.media.controller.Library({
                    title:     'Sélectionnez et recadrez', // l10n.chooseImage,
                    library:   wp.media.query({ type: 'image' }),
                    multiple:  false,
                    date:      false,
                    priority:  20,
                    suggestedWidth: 300,
                    suggestedHeight: 200
                }),
                new wp.media.controller.CustomizeImageCropper({ 
                    imgSelectOptions: oak_calculateImageSelectOptions,
                    control: cropControl
                })
            ]
        });
    
        mediaUploader.on('cropped', function(croppedImage) {
    
            var url = croppedImage.url,
                attachmentId = croppedImage.attachment_id,
                w = croppedImage.width,
                h = croppedImage.height;
    
                oak_setImageFromURL(url, attachmentId, w, h);            
    
        });
    
        mediaUploader.on('skippedcrop', function(selection) {
    
            var url = selection.get('url'),
                w = selection.get('width'),
                h = selection.get('height');
    
                oak_setImageFromURL(url, selection.id, w, h);            
    
        });        
    
        mediaUploader.on("select", function() {
    
            var attachment = mediaUploader.state().get( 'selection' ).first().toJSON();
    
            if (     cropControl.params.width  === attachment.width 
                &&   cropControl.params.height === attachment.height 
                && ! cropControl.params.flex_width 
                && ! cropControl.params.flex_height ) {
                    oak_setImageFromAttachment( attachment );
                mediaUploader.close();
            } else {
                mediaUploader.setState( 'cropper' );
            }
    
        });
    
        mediaUploader.open();
    }

    $("#oak_site_change_icon_button").on('click', function(e) {
        changeImageButtonListener(e, this);
    })
    
    $("#oak_site_change_logo_button").on("click", function(e) {
        changeImageButtonListener(e, this);
    });
    
});



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

handleGeneralSettingsSaveButton();
function handleGeneralSettingsSaveButton() {
    var generalSettingsSaveButton = document.querySelector('.oak_configuration_page__save_general_settings_button');
    generalSettingsSaveButton.addEventListener('click', function() {
        var siteLogo = document.querySelector('.oak_configuration_site_logo').getAttribute('src');
        var tagline = document.querySelector('.oak_configuration_page__tagline').value;
        var siteTitle = document.querySelector('.oak_configuration_page__site_title').value;
        var organizationName = document.querySelector('.oak_configuration_page__organization_name').value;
        var siteIcon = document.querySelector('.oak_configuration_site_icon').getAttribute('src');

        var generalSettings = {
            siteLogo,
            tagline,
            siteTitle,
            organizationName,
            siteIcon
        }

        setLoading();
        // $(document).ready(function() {
            $.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_corn_save_general_configuration',
                    'generalSettings': JSON.stringify(generalSettings)
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    window.location.reload()
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        // });
    });
}

// To regenerate indexes: 
handleRegenerateIndexesButton();
function handleRegenerateIndexesButton() {
    var regenerateIndexesButton = document.querySelector('#oak_regenerate_indexes_button');
    regenerateIndexesButton.addEventListener('click', function() {
        setLoading();
        jQuery.ajax({
            url: DATA.ajaxUrl,
            type: 'POST', 
            data: {
                'action': 'oak_regenerate_indexes',
                'data': {}
            },
            success: function(data) {
                console.log(data);
                doneLoading();
            },
            error: function(error) {
                console.log(error);
                doneLoading();
            }
        });
    });
}


handleSystemBarSettingsSaveButton();
function handleSystemBarSettingsSaveButton() {
    var systemBarSaveButton = document.querySelector('.oak_configuration_page__save_system_bar_settings_button');
    systemBarSaveButton.addEventListener('click', function() {
        var socialMediaData = [];
        for(var i = 0; i < DATA.socialMedias.length; i++) {
            socialMediaData.push({
                checked: document.querySelector('.social_media_' + DATA.socialMedias[i].name + '_checkbox' ).checked,
                value: document.querySelector('.social_media_' + DATA.socialMedias[i].name).value
            });
        }

        var systemBarBackgroundColor = document.querySelector('.oak_social_media_background_color_configuration').value

        console.log(socialMediaData);
        console.log(systemBarBackgroundColor);

        setLoading();
        // $(document).ready(function() {
            $.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_corn_save_social_media_configuration',
                    'socialMediaData': socialMediaData,
                    'socialMediaBackgroundColor': systemBarBackgroundColor
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    // window.location.reload()
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        // });
    });
}

handleAppBarSettingsSaveButton();
function handleAppBarSettingsSaveButton() {
    var saveButton = document.querySelector('.oak_configuration_page__save_app_bar_settings_button');
    saveButton.addEventListener('click', function() {
        var checkboxes = document.querySelector('.oak_tab_2').querySelectorAll('.oak_app_bar_configuration_checkbox');
        var appBarSettings = [];
        for (var i = 0; i < checkboxes.length; i++) {
            appBarSettings.push({
                name: checkboxes[i].getAttribute('id'),
                value: checkboxes[i].checked
            });
        }
        console.log('app bar settings', appBarSettings);
        var appBarBackgroundColor = document.querySelector('.oak_app_bar_background_color').value;

        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_corn_save_app_bar_settings',
                    'appBarSettings': appBarSettings,
                    'appBarBackgroundColor': appBarBackgroundColor
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
        })
    });
}

// To initialize the color select: 
jQuery(document).ready(function($){
    jQuery('.oak_social_media_background_color_configuration').wpColorPicker();
    jQuery('.oak_app_bar_background_color').wpColorPicker();
    jQuery('.oak_tab_3').find('.color_input').wpColorPicker();
    initializeNavBarData();
});

// Initialize Nav bar data: 
function initializeNavBarData() {
    var singleMenusContainers = document.querySelectorAll('.oak_configuration_page__single_menu_container');
    for (var i = 0; i < singleMenusContainers.length; i++) {
        var colorButtons = singleMenusContainers[i].querySelectorAll('.wp-color-result');
        var colorInputs = singleMenusContainers[i].querySelectorAll('.color_input');

        colorButtons[0].style.backgroundColor = DATA.oakNavBarData[i].backgroundColor;
        colorInputs[0].style.backgroundColor = DATA.oakNavBarData[i].backgroundColor;

        colorButtons[1].style.backgroundColor = DATA.oakNavBarData[i].fontColor;
        colorInputs[0].style.backgroundColor = DATA.oakNavBarData[i].fontColor;
    }
}

handleSaveNavBarSettingsButton();
function handleSaveNavBarSettingsButton() {
    var saveButton = document.querySelector('.oak_configuration_page__save_nav_bar_settings_button');
    saveButton.addEventListener('click', function() {
        var navBarData = [];
        var menusContainer = document.querySelectorAll('.oak_configuration_page__single_menu_container');
        for (var i = 0; i < menusContainer.length; i++) {
            var menuSlug = menusContainer[i].getAttribute('menu-slug');
            var colorsInputs = menusContainer[i].querySelectorAll('.color_input');
            navBarData.push({
                menuSlug,
                backgroundColor: colorsInputs[0].value,
                fontColor: colorsInputs[1].value
            });
        }

        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_corn_save_nav_bar_settings', 
                    'navBarData': JSON.stringify(navBarData)
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        })
    });
}

function containsClass(element, className) {
    if (element) {
        for (var i = 0; i < element.classList.length; i++) {
            if (className == element.classList[i]) 
                return true;
        }
    }
    return false;
}

// Initialize the color container: 
var singleColorContainer;
initializeSingleColorContainer();
function initializeSingleColorContainer() {
    singleColorContainer = document.querySelector('.oak_configuration_page__single_color_container').innerHTML;
    document.querySelector('.oak_configuration_page__colors_container').innerHTML = '';
}

// For the add color button
handleAddColorButton();
function handleAddColorButton() {
    var addButton = document.querySelector('.oak_configuration_page__add_style_button');
    addButton.addEventListener('click', function() {
        handleAddNewColorContainer();
    });
}

function handleAddNewColorContainer(colorData) {
    var colorsContainer = document.querySelector('.oak_configuration_page__colors_container');

    var newColorContainer = document.createElement('div');
    newColorContainer.className = 'oak_configuration_page__single_color_container';
    newColorContainer.innerHTML = singleColorContainer;

    colorsContainer.append(newColorContainer);
    jQuery('.oak_configuration_page__style_config').find('.color_input').wpColorPicker({
        change: function(event, ui) {
            console.log('changed');
        }
    });

    if (colorData) {
        console.log('Entered the if colordata');
        for (var i = 0; i < colorData.secondary.length; i++) {
            colorData.primary.push(colorData.secondary[i]);
        }

        var colorInputs = newColorContainer.querySelectorAll('.color_input');
        var colorButtons = newColorContainer.querySelectorAll('button');
        for (var i = 0; i < colorData.primary.length; i++) {
            colorInputs[i].value = colorData.primary[i];
            colorButtons[i].style.backgroundColor = colorData.primary[i];
        }
    }
} 

// Handle save styles button
handleSaveStylesButton();
function handleSaveStylesButton() {
    var saveStyleButton = document.querySelector('.oak_configuration_page__save_styles');
    saveStyleButton.addEventListener('click', function() {
        var colors = [];
        var colorsContainers = document.querySelectorAll('.oak_configuration_page__single_color_container');
        for (var i = 0; i < colorsContainers.length; i++) {
            var primaryContainer = colorsContainers[i].querySelector('.oak_configuration_page_single_color_container__primary_container');
            var primaryColors = [];
            var primaryContainers = primaryContainer.querySelectorAll('.oak_color_container');
            for (var j = 0; j < primaryContainers.length; j++) {
                primaryColors.push(primaryContainers[j].querySelector('.color_input').value);
            }

            var secondaryContainer = colorsContainers[i].querySelector('.oak_configuration_page_single_color_container__secondary_container');
            var secondaryColors = [];
            var secondaryContainers = secondaryContainer.querySelectorAll('.oak_color_container');
            for (var j = 0; j < secondaryContainers.length; j++) {
                secondaryColors.push(secondaryContainers[j].querySelector('.color_input').value);
            }

            colors.push({
                primary: primaryColors,
                secondary: secondaryColors
            });
        }

        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_corn_save_styles_settings',
                    'colors': JSON.stringify(colors)
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    window.location.reload();
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        }); 
    });
}

initializeColors();
function initializeColors() {
    for (var i = 0; i < DATA.oakColors.length; i++) {
        console.log('euh');
        handleAddNewColorContainer(DATA.oakColors[i]);
    }
}

// Everything related to our modal
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
// Done with the modal