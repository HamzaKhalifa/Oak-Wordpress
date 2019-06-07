
console.log('Im here');
setLoading();
jQuery(document).ready(function() {
    jQuery.ajax({
        url: REPORTING_SAFETY_DATA.ajaxUrl,
        type: 'GET', 
        data: {
            'action': 'oak_get_everything',
            'data': {

            }
        },
        success: function(data) {
            console.log(data);
            doneLoading();
        },
        error: function(error) {
            console.log(error);
            doneLoading;
        }
    });
});