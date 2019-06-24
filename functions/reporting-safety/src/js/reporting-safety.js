// For the configuration button
handleConfigurationButton();
function handleConfigurationButton() {
    var configurationButton = document.querySelector('.oak_reporting_safety__configuration_save_button');
    configurationButton.addEventListener('click', function() {
        jQuery(document).ready(function() {
            setLoading();
            backupAjaxUrl = document.querySelector('.oak_reporting_safety__backup_instance_ajax_url').value;
            jQuery.ajax({
                url: REPORTING_SAFETY_DATA.ajaxUrl,
                type: 'POST',
                data: {
                    'action': 'oak_save_reporting_safety_configuration',
                    'backup_ajax_url': backupAjaxUrl
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    openModal('Sauvergarde effectuée avec succès.');
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        }); 
    });
}


// To generate SQL file: 
handleGenerateSqlFileButton();
function handleGenerateSqlFileButton() {
    var generateSqlFileButton = document.querySelector('.reporting_safety__generate_sql_file_button');
    generateSqlFileButton.addEventListener('click', function() {
        setLoading();
        jQuery(document).ready(function() {
            jQuery.ajax({
                url: document.querySelector('.oak_reporting_safety__backup_instance_ajax_url').value,
                type: 'POST',
                data: {
                    'action': 'oak_generate_sql_file',
                    'data': {}
                },
                success: function(data) {
                    console.log(data);
                    doneLoading();
                    openModal('Fichier généré avec succès');
                },
                error: function(error) {
                    console.log(error);
                    doneLoading();
                }
            });
        });
    });
}