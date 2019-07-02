(function() {
    console.log('for system bar');

    handleChatMenuButton();
    function handleChatMenuButton() {
        var chatMenuButton = document.querySelector('.oak_chat_menu_button');
        chatMenuButton.addEventListener('click', function() {
            var chatMenu = document.querySelector('.oak_chat_menu');
            console.log(chatMenu);
            var chatMenuWidth = parseInt(window.getComputedStyle(chatMenu).getPropertyValue('width')) + parseInt(window.getComputedStyle(chatMenu).getPropertyValue('padding')) * 2;
            console.log(chatMenuWidth);
            var body = document.querySelector('body');
            if (classExists(chatMenu, 'oak_chat_menu_hidden')) {
                chatMenu.classList.remove('oak_chat_menu_hidden');
                body.style.width = parseInt(window.getComputedStyle(body).getPropertyValue('width')) - chatMenuWidth + 'px';
                // body.style.right = chatMenuWidth + 'px';
            } else {
                chatMenu.classList.add('oak_chat_menu_hidden');
                body.style.width = parseInt(window.getComputedStyle(body).getPropertyValue('width')) + chatMenuWidth + 'px';
                // body.style.right = '0px';
            }
        })
    }

    function classExists(element, className) {
    for (var i = 0; i < element.classList.length; i++) {
        if (element.classList[i] == className) 
            return true
    }

    return false;
}
})();