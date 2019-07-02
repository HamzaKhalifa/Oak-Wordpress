(function() {
    var authentificationForm = document.querySelector('.oak_chat_menu__authentication');
    var loaderContainer = document.querySelector('.oak_chat_loader_container');
    var authenticatedView = document.querySelector('.oak_chat_authenticated');
    var loadingMessage = document.querySelector('.oak_chat_loader_container__loading_message');

    // Check if authenticated: 
    handleAuthentificationView();
    function handleAuthentificationView() {
            var alreadyAuthenticatedView = document.querySelector('.oak_chat_authenticated');
        if ( OAK_MAIN_CHAT_DATA.authenticated == 'false' ) {
            authentificationForm.classList.remove('oak_hidden');
            alreadyAuthenticatedView.classList.add('oak_hidden');
        } else {
            authentificationForm.classList.add('oak_hidden');
            alreadyAuthenticatedView.classList.remove('oak_hidden');
        }
    }

    handleAuthentificationFormListener();
    function handleAuthentificationFormListener() {
        var errorMessageSpan = document.querySelector('.oak_chat_authentication__error_message');

        authentificationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var email = document.querySelector('.oak_chat_email').value;
            var password = document.querySelector('.oak_chat_password').value;
            var username = document.querySelector('.oak_chat_username').value;
            if (email == '') {
                errorMessageSpan.innerHTML = 'Le nom d\'utilisateur ne doit pas être vide';
                return
            } else if(password == '' ) {
                errorMessageSpan.innerHTML = 'Le mot de passe ne doit pas être vide';
                return;
            } else if(username == '' ) {
                errorMessageSpan.innerHTML = 'Le nom d\'utilisateur ne doit pas être vide';
                return;
            } else {
                errorMessageSpan.innerHTML = '';
            }

            authentificationForm.classList.add('oak_hidden');
            loaderContainer.classList.remove('oak_hidden');
            loadingMessage.innerHTML = 'Authentification en cours...'

            firebase.auth().createUserWithEmailAndPassword(email, password).catch(function(error) {
                var errorCode = error.code;
                var errorMessage = error.message;

                if (errorCode == 'auth/email-already-in-use') {
                    firebase.auth().signInWithEmailAndPassword(email, password).catch(function(error) {
                        var errorCode = error.code;
                        var errorMessage = error.message;

                        loaderContainer.classList.add('oak_hidden');
                        authentificationForm.classList.remove('oak_hidden');
                        errorMessageSpan.innerHTML = errorMessage
                    }).then(function(data) {
                        if (data) {
                            console.log(data.user);
                            writeUserData(data.user.uid, username, email)
                        }
                    });
                } else {
                    loaderContainer.classList.add('oak_hidden');
                    authentificationForm.classList.remove('oak_hidden');
                    errorMessageSpan.innerHTML = errorMessage
                }
            }).then(function(data) {
                if (data) {
                    console.log(data.user);
                    writeUserData(data.user.uid, username, email)
                }
            });
            // Here we try to authenticate using firebase: 
        })
    }

    handleOnAuthStateChanged()
    function handleOnAuthStateChanged() {
        firebase.auth().onAuthStateChanged(function(user) {
            if (user) {
                // User is signed in.
                var displayName = user.displayName;
                var email = user.email;
                var emailVerified = user.emailVerified;
                var photoURL = user.photoURL;
                var isAnonymous = user.isAnonymous;
                var uid = user.uid;
                var providerData = user.providerData;
                sendAjaxRequest('true', 'modify_authenticated', function(data) {
                    console.log('User signed in, display name: ', displayName  + ', email: ' + email + ', email verified: ' + emailVerified);
                    loaderContainer.classList.add('oak_hidden');
                    authenticatedView.classList.remove('oak_hidden');
                    authentificationForm.classList.add('oak_hidden');
                    loadingMessage.innerHTML = 'Authentification en cours...';
                })
            } else {
                // User is signed out.
                console.log('disconnected');
                sendAjaxRequest('false', 'modify_authenticated', function(data) {
                    loaderContainer.classList.add('oak_hidden');
                    authenticatedView.classList.add('oak_hidden');
                    authentificationForm.classList.remove('oak_hidden');
                })
            }
        });
    }

    handleSignOutButton();
    function handleSignOutButton() {
        var signOutButton = document.querySelector('.oak_chat_sign_out_button');
        signOutButton.addEventListener('click', function() {
            loaderContainer.classList.remove('oak_hidden');
            authenticatedView.classList.add('oak_hidden');
            firebase.auth().signOut();
        })
    }

    function writeUserData(userId, name, email) {
        firebase.database().ref('users/' + userId).set({
            username: name,
            email: email,
        });
    }

    handleUsersList();
    function handleUsersList() {
        // firebase.auth().listUsers(1000, 'f').then(function(listUsersResult) {
        //     listUsersResult.users.forEach(function(userRecord) {
        //         console.log('user', userRecord.toJSON());
        //     });
        // })
        // .catch(function(error) {
        //     console.log('Error listing users:', error);
        // });
    }

    function sendAjaxRequest(data, functionName, callback) {
        jQuery(document).ready(function() {
            jQuery.ajax({
                type: 'POST',
                url: OAK_MAIN_CHAT_DATA.ajaxUrl,
                data: {
                    'data': data,
                    'action': functionName
                },
                success: function(data) {
                    // console.log(data);
                    callback(data);
                },
                error: function(error) {
                    // console.log(error);
                    callback(error);
                }
            });
        });
    }
})();