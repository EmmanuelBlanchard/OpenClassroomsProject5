window.onload = () => {
    document.querySelector("#registration_form_plainPassword").addEventListener('input', checkPassword);
}

let form = document.querySelector('#registration_form');
const pseudo = document.querySelector('#registration_form_pseudo');
const lastname = document.querySelector('#registration_form_lastname');
const firstname = document.querySelector('#registration_form_firstname');
const email = document.querySelector('#registration_form_email');
const password = document.querySelector('#registration_form_plainPassword');
const zipcode = document.querySelector('#registration_form_zipCode');
const city = document.querySelector('#registration_form_city');

form.addEventListener('submit', e => {
	e.preventDefault();
	
	checkInputs();
});

function checkInputs() {
	// trim to remove the whitespaces
	const pseudoValue = pseudo.value.trim();
    const lastnameValue = lastname.value.trim();
    const firstnameValue = firstname.value.trim();
	const emailValue = email.value.trim();
	const passwordValue = password.value.trim();
    const zipcodeValue = zipcode.value.trim();
    const cityValue = city.value.trim();

	if(pseudoValue === '') {
		setErrorFor(pseudo, 'Le pseudo ne peut pas être vide');
	} else {
		setSuccessFor(pseudo);
	}
	
    if(lastnameValue === '') {
		setErrorFor(lastname, 'Le nom ne peut pas être vide');
	} else if (!isLastNameNumber(lastname)) {
        setErrorFor(lastname, 'Le nom ne peut pas contenir un nombre ');
    } else if (!isLastName(lastnameValue)) {
		setErrorFor(lastname, 'Le nom n\'est pas valide');
	} else {
		setSuccessFor(lastname);
	}

    if(firstnameValue === '') {
		setErrorFor(firstname, 'Le prénom ne peut pas être vide');
	} else if (!isFirstNameNumber(firstname)) {
        setErrorFor(firstname, 'Le prénom ne peut pas contenir un nombre ');
    } else if (!isFirstName(firstnameValue)) {
		setErrorFor(firstname, 'Le prénom n\'est pas valide');
	} else {
		setSuccessFor(firstname);
	}

	if(emailValue === '') {
		setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
	} else if (!isEmail(emailValue)) {
		setErrorFor(email, 'L\'adresse e-mail n\'est pas valide');
	} else {
		setSuccessFor(email);
	}
	
	if(passwordValue === '') {
		setErrorFor(password, 'Le mot de passe ne peut pas être vide');
	} else if (!isPasswordTiny(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins une lettre minuscule');
    } else if (!isPasswordUppercase(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins une une lettre majuscule');
    }
    else if (!isPasswordNumber(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins un chiffre');
    }
    else if (!isPasswordSpecial(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins un caractère spécial');
    }
    else if (!isPasswordLength(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins 12 caractères');
    } else if (!isPassword(passwordValue)) {
		setErrorFor(password, 'Le mot de passe n\'est pas valide, il doit comporter au moins une lettre minuscule, une lettre majuscule, un chiffre, un caractère spécial et 12 caractères minimun');
    } else {
		setSuccessFor(password);
	}
	
    if(zipcodeValue === '') {
		setErrorFor(zipcode, 'Le code postal ne peut pas être vide');
	} else if (!isZipCode(zipcodeValue)) {
		setErrorFor(zipcode, 'Le code postal n\'est pas valide');
	} else {
		setSuccessFor(zipcode);
	}
    
    if(cityValue === '') {
		setErrorFor(city, 'Le nom de la ville ne peut pas être vide');
	} else if (!isCityLength(cityValue)) {
        setErrorFor(city, 'Le nom de la ville doit comporter entre 1 et 50 caractères');
    } else if (!isCity(cityValue)) {
		setErrorFor(city, 'Le nom de la ville n\'est pas valide');
	} else {
		setSuccessFor(city);
	}
}

function setErrorFor(input, message) {
	const formControl = input.parentElement;
	const small = formControl.querySelector('small');
	formControl.className = 'form-control error';
	small.innerText = message;
}

function setSuccessFor(input) {
	const formControl = input.parentElement;
	formControl.className = 'form-control success';
}

function isLastNameNumber(lastname) {
	return /\d/.test(lastname);
}

function isLastName(lastname) {
	return /^[A-ZÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]'?[- a-zA-ZéèàêâùïüëçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]+$/.test(lastname);
}

function isFirstNameNumber(lastname) {
	return /\d/.test(lastname);
}

function isFirstName(firstname) {
    return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœ])*[-'\s]{0,1}(([a-zàâäçéèêëîïôöùûüÿæœ]+)[-'\s]{0,1})*$/.test(firstname);
}

function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

function isPasswordTiny(password) {
    return /[a-z]/.test(password);
}

function isPasswordUppercase(password) {
    return /[A-Z]/.test(password);
}

function isPasswordSpecial(password) {
    return /[-_$@!/\\%*#&£~ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰]/.test(password);
}

function isPasswordLength(password) {
    if(password.length >= 12) {
        return true;
    } else {
        return false;
    }
}

function isPassword(password) {
    return /^(?=.+[A-Z])(?=.+[a-z])(?=.+\d)(?=.+[-?+!*$@%_&~`\\^\|\#{}()\[\]])([-?+!*$@%_&~`\\\|\#{}()\[\]\w]{12,})$/.test(password);
}

function isZipCode(zipcode) {
    return /^[0-9]{5}$/.test(zipcode);
}

function isCityLength(city)  {
    if(city.length < 1 && city.length > 50) {
        return false;
    }
}
function isCity(city) {
    return /^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/.test(city);
}

/*
let email = document.querySelector("#registration_form_email");

// Listen to the email modification
email.addEventListener('change', function() {
    validEmail(this);
});

const validEmail = function(inputEmail) {
    let emailRegExp = new RegExp(
        '^[a-zA-Z0-9.-_]+[@]{1}[a-zA-Z0-9.-_]+[.]{1}[a-z]{2,10}$', 'g'
        );

    let testEmail = emailRegExp.test(inputEmail.value);
    let small = inputEmail.nextElementSibling;
    //let small = document.querySelector("#registration_form_email_small");
    if(testEmail) {
        small.innerHTML = 'L\'adresse e-mail est valide';
    } else {
        small.innerHTML = 'L\'adresse e-mail est non valide';
    }
};
*/

/**
 * This function checks the password
 */
function checkPassword(){
    // We initialize the score 
    let score = 0;
    // We recover what has been entered
    let password = this.value;

    // We get the elements we need
    let tiny = document.querySelector("#tiny");
    let uppercase = document.querySelector("#uppercase");
    let number = document.querySelector("#number");
    let special = document.querySelector("#special");
    let length = document.querySelector("#length");

    let min = document.querySelector("#min-mdp");

    // We check that we have a tiny
    if(/[a-z]/.test(password)) {
        tiny.classList.replace("invalid", "valid");
        score++;
    } else {
        tiny.classList.replace("valid", "invalid");
    }
    // We check that we have a uppercase
    if(/[A-Z]/.test(password)) {
        uppercase.classList.replace("invalid", "valid");
        score++;
    } else {
        uppercase.classList.replace("valid", "invalid");
    }
    // We check that we have a number
    if(/[0-9]/.test(password)) {
        number.classList.replace("invalid", "valid");
        score++;
    } else {
        number.classList.replace("valid", "invalid");
    }
    // We check that we have a special character
    /* ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸ àáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰  */
    if(/[-_$@!/\\%*#&£~ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰]/.test(password)){
        special.classList.replace("invalid", "valid");
        score++;
    } else {
        special.classList.replace("valid", "invalid");
    }
    // We check that we have the length of the password
    if(password.length >= 12) {
        length.classList.replace("invalid", "valid");
        score++;
    } else {
        length.classList.replace("valid", "invalid");
    }

    if(score === 5) {
        document.getElementById('submitRegistrationFormButton').style.display = "initial";
    } else {
        document.getElementById('submitRegistrationFormButton').style.display = "none";
    }
}