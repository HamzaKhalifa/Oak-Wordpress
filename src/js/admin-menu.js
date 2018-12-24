
manageSubMenus();
function manageSubMenus() {
    var allSubMenus = document.querySelectorAll('.wp-submenu');
    for (var i = 0; i < allSubMenus.length; i++) {
        if (allSubMenus[i].parentNode.id == 'toplevel_page_dawn_materiality_reporting') {
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