handleCharacterMovement();
function handleCharacterMovement() {
    var character = document.querySelector('.oak_loading_game_character');
    var stepPerFrame = 1;
    var keysValues = [
        {
            name: 'ArrowRight',
            pressed: false,
            stylePropertyName: 'left',
            changeValue: stepPerFrame, 
            add: true,
            movement: true,
        },
        {
            name: 'ArrowLeft',
            pressed: false,
            stylePropertyName: 'left',
            changeValue: stepPerFrame, 
            add: false,
            movement: true,
        },
        {
            name: 'ArrowDown',
            pressed: false,
            stylePropertyName: 'top',
            changeValue: stepPerFrame, 
            add: true,
            movement: true,
        },
        {
            name: 'ArrowUp',
            pressed: false,
            stylePropertyName: 'top',
            changeValue: stepPerFrame, 
            add: false,
            movement: true,
        },
    ]

    document.addEventListener('keydown', function(e) {
        const keyName = event.key;
        
        if ( keyName == 'ArrowRight' ) 
            character.classList.remove('oak_loading_game_character_changed_direction');
        else if (keyName == 'ArrowLeft')
            character.classList.add('oak_loading_game_character_changed_direction');

        for (var i = 0; i < keysValues.length; i++) {
            if (keysValues[i].name == keyName) {
                keysValues[i].pressed = true;
            }
        }
    });
    document.addEventListener('keyup', function(e) {
        const keyName = event.key;
        
        for (var i = 0; i < keysValues.length; i++) {
            if (keysValues[i].name == keyName) {
                keysValues[i].pressed = false;
            }
        }
    });

    (function() {
        setInterval(function() {
            for(var i = 0; i < keysValues.length; i++) {
                if (keysValues[i].pressed) {
                    var styleValue = parseInt(getComputedStyle(character).getPropertyValue(keysValues[i]['stylePropertyName']));
                    if (keysValues[i]['add'] == true) {
                        styleValue += keysValues[i]['changeValue']
                    } else {
                        styleValue -= keysValues[i]['changeValue']
                    }
    
                    character.style[keysValues[i]['stylePropertyName']] = styleValue + 'px';
                }
            }
        }, .0000001);
    })();
}

handleIdleAnimation();
function handleIdleAnimation() {
    var character = document.querySelector('.oak_loading_game_character');
    var currentImage = 0;
    setInterval(function() {
        currentImage++;
        if (currentImage == LOADING_GAME_DATA.characterIdlAnimationImage.length )
            currentImage = 0;
        character.setAttribute('src', LOADING_GAME_DATA.characterIdlAnimationImage[currentImage]);
    }, 50);
}

fireBeam() {

}