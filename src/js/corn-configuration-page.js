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
        })
    }
}