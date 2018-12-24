
manageSubMenus();
function manageSubMenus() {
    var allSubMenus = document.querySelectorAll('.wp-submenu');
    for (var i = 0; i < allSubMenus.length; i++) {
        if (allSubMenus[i].parentNode.id == 'toplevel_page_dawn_materiality_reporting') {
            // allSubMenus[i].style.minWidth = '200px';
            var items = allSubMenus[i].querySelectorAll('li');
            for (var j = 0; j < items.length; j++) {
                if (items[j].querySelector('a') != null) {
                    if (items[j].querySelector('a').getAttribute('href').indexOf('taxonomy') != -1 || items[j].querySelector('a').getAttribute('href').indexOf('post-new.php') != -1 || items[j].querySelector('a').getAttribute('href').indexOf('dawn_critical_analysis_configuration') != -1) {
                        items[j].style.marginLeft = '10px';
                    } else {
                        items[j].querySelector('a').style.color = '#FCB214';
                    }
                }
            }
        }
    }
}


jQuery(document).ready(function() {
    jQuery.ajax({
        url: DATA.ajaxUrl,
        headers: { 'Access-Control-Allow-Origin': '*' },
        type: 'POST',
        data: {
            'action': 'dawn_get_posts',
            'data': {}
        },
        // beforeSend: function (xhr) {
        //     xhr.setRequestHeader ('Authorization', 'Basic ' + btoa(username + ':' + password));
        // },
        success: function(data) {
            console.log(data);
        },
        error: function(error) {
            console.log(error);
        }
    });
})