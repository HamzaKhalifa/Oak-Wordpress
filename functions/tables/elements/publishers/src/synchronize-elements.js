handleSyncButton();
function handleSyncButton() {
    var synchButton = document.querySelector('.oak_add_element_ivwp__synchronise_button');
    synchButton.addEventListener('click', function() {
        openModal('Êtes vous sûr de vouloir synchroniser?', true, function() {
            setLoading();
            var ivwpAjaxUrl = SYNCHRONIZE_DATA.publishers[SYNCHRONIZE_DATA.publishers.length - 1].publisher_url;
            jQuery(document).ready(function() {
                jQuery.ajax({
                    type: 'POST',
                    url: ivwpAjaxUrl,
                    data: {
                        'action': 'send_sync_data',
                        'data': {}
                    },
                    success: function(data) {
                        console.log(data.data);
                        jQuery.ajax({
                            type: 'POST', 
                            url: DATA.ajaxUrl,
                            data: {
                                'action': 'save_sync_data',
                                'objectsToSave': data.data.objects,
                                'termsAndObjects': data.data.terms_and_objects
                            },
                            success: function(response) {
                                console.log(response);
                                jQuery.ajax({
                                    type: 'POST', 
                                    url: ivwpAjaxUrl,
                                    data: {
                                        'action': 'all_objects_synchronized',
                                        'data': {}
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        doneLoading();
                                    },
                                    error: function(error) {
                                        console.log(error);
                                        doneLoading();
                                    }
                                });
                            },
                            error: function(error) {
                                console.log(error);
                                doneLoading();
                            }
                        });
                        // doneLoading();
                    },
                    error: function(error) {
                        console.log(error);
                        doneLoading();
                    }
                });
            });
        });
    })
}