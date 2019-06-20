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
            character.classList.remove('oak_loading_game_object_changed_direction');
        else if (keyName == 'ArrowLeft')
            character.classList.add('oak_loading_game_object_changed_direction');

        console.log(keyName);
        if ( keyName == 'Shift' ) {
            fireBeam();
        }

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

function fireBeam() {
    var character = document.querySelector('.oak_loading_game_character');
    
    var characterPosition = getObjectPosition(character);
    var beam = document.createElement('img');
    beam.setAttribute('src', LOADING_GAME_DATA.fireBeamImage);
    var beamDirection = classExists(character, 'oak_loading_game_object_changed_direction') ? -1 : 1;
    if (beamDirection == -1) {
        beam.classList.add('oak_loading_game_object_changed_direction');
    }
    beam.style.top = characterPosition.top + 50;
    beam.style.left = characterPosition.left + 60;
    beam.classList.add('oak_loading_game_firebeam');

    document.querySelector('.oak_loaging_game_container').append(beam);
    console.log('beam', beam);
    setInterval(function() {
        beam.style.left = parseInt(beam.style.left) + 7 * beamDirection;
    }, 0.01);
    setTimeout(() => {
        beam.remove();
    }, 4000);
    
}

function getObjectPosition(object) {
    return {
        top: parseInt(getComputedStyle(object).getPropertyValue('top')),
        left: parseInt(getComputedStyle(object).getPropertyValue('left'))
    }
}

function classExists(element, className) {
    for (var i = 0; i < element.classList.length; i++) {
        if (element.classList[i] == className) 
            return true
    }

    return false;
}