window.onload = () => {
    document.querySelector("#registration_form_pseudo").addEventListener('input', checkInputs);
    document.querySelector("#registration_form_lastname").addEventListener('input', checkInputs);
    document.querySelector("#registration_form_firstname").addEventListener('input', checkInputs);
    document.querySelector("#registration_form_email").addEventListener('input', checkInputs);
    document.querySelector("#registration_form_plainPassword").addEventListener('input', checkInputs);
    document.querySelector("#registration_form_zipCode").addEventListener('input', checkInputs);
    document.querySelector("#registration_form_city").addEventListener('input', checkInputs);
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
	//console.log('submit');
	checkInputs();
});

function checkInputs(){
	// trim to remove the whitespaces
	const pseudoValue = pseudo.value.trim();
    const lastnameValue = lastname.value.trim();
    const firstnameValue = firstname.value.trim();
	const emailValue = email.value.trim();
	const passwordValue = password.value.trim();
    const zipcodeValue = zipcode.value.trim();
    const cityValue = city.value.trim();
    
    //console.log(pseudoValue);

	if(pseudoValue === '') {
		setErrorFor(pseudo, 'Le pseudo ne peut pas être vide');
	} else if (!isPseudoNumberMin(pseudoValue)) {
        setErrorFor(pseudo, 'Le pseudo doit comporter au moins 7 caractères');
    } else if (isPseudoNumberMax(pseudoValue)) {
        setErrorFor(pseudo, 'Le pseudo ne peut pas comporter plus de 15 caractères');
    } else if (!isPseudoNoSpace(pseudoValue)) {
		setErrorFor(pseudo, 'Le pseudo ne peut pas contenir le caractère espace (les caractères - et _ sont autorisés)');
    } else {
		setSuccessFor(pseudo);
	}
	
    if(lastnameValue === '') {
		setErrorFor(lastname, 'Le nom ne peut pas être vide');
	} else if (isLastNameNumber(lastname)) {
        setErrorFor(lastname, 'Le nom ne peut pas contenir un nombre');
    } else if (!isLastName(lastnameValue)) {
		setErrorFor(lastname, 'La première lettre du nom doit être en majuscule');
	} else {
		setSuccessFor(lastname);
	}

    if(firstnameValue === '') {
		setErrorFor(firstname, 'Le prénom ne peut pas être vide');
	} else if (isFirstNameNumber(firstname)) {
        setErrorFor(firstname, 'Le prénom ne peut pas contenir un nombre ');
    } else if (!isFirstName(firstnameValue)) {
		setErrorFor(firstname, 'La première lettre du prénom doit être en majuscule');
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

function isPseudoNumberMin(pseudo) {
    if(pseudo.length > 6) {
        return true;
    }
}

function isPseudoNumberMax(pseudo) {
    if(pseudo.length > 15) {
        return true;
    }
}

function isPseudoNoSpace(pseudo) {
    return /^([-\S\w]{7,15})$/.test(pseudo);
}

function isLastNameNumber(lastname) {
	return /\d/.test(lastname);
}

function isLastName(lastname) {
	//return /^[A-ZÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]'?[- a-zA-ZéèàêâùïüëçÂÊÎÔÛÄËÏÖÜÀÆæÇÉÈŒœÙ]+$/.test(lastname);
	//return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒa-zàâäçéèêëîïôöùûüÿæœ])*[-'’\s]{0,1}[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}(([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒa-zàâäçéèêëîïôöùûüÿæœ]*)[-'’\s]{0,1})*[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}(([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒa-zàâäçéèêëîïôöùûüÿæœ]*)[-'’\s]{0,1})*$/.test(lastname);
	//return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœ])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœ]*)[-'’\s]{0,1})*[^\s]$/.test(lastname);
	// no space or dash character at the end of the Name
	return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*[^-\s]$/.test(lastname);
	/*
	1) John Smith 
	2) John D’Largy 
	3) John Doe-Smith 
	4) John Doe Smith 
	5) Hector Sausage-Hausen 
	6) Mathias d’Arras 
	7) Martin Luther King  | Martin Luther King jr.
	8) Ai Wong 
	9) Chao Chang 
	10) Alzbeta Bara
	11) O'Brien-O'Malley
	12) Van der Humpton | Downtown-James Brown | Jozef-Schmozev Hiemdel | George De FunkMaster
	13) Jérémie O'Co-nor | O'Hara | McNamara | McIntosh | Kurtis B-Ball Basketball | Ahmad el Jeffe | Mike O'Neal
	14) John D’Largy O'Brien-O'Malley
	15) Van der Humpton John D’Largy O'Brien-O'Malley
	16) Balaÿ, Baÿ, Boulennoÿ, Croÿ, Delannoÿ, Demenÿ, Du Faÿ, Faÿ, Fuÿe, Ghÿs, Lannoÿe, Linÿer, Nicolaÿ, Nouÿ, Ysaÿe
	17) John Mc'Kenzie | John-Doe Jane-Doe
	18) Randrianampoinimeria | Andrianirinaharivelo | Nadjar Ben Embarek Ben Chagra
	19) Tram Vihn Tan Tan Gapregassam | Pourroy de L'Auberivière de Quinsonas-Oudinot de Reggio
	20) Keihanaikukauakahihuliheekahaunaele
	21) Michael Jordan O'Reilly Jr. | Österreicher 
	22) No match for the name => Guðmundsdóttir
	*/
}

function isFirstNameNumber(lastname) {
	return /\d/.test(lastname);
}

function isFirstName(firstname) {
    //return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœ])*[-'\s]{0,1}(([a-zàâäçéèêëîïôöùûüÿæœ]+)[-'\s]{0,1})*$/.test(firstname);
	// update of the pattern for compound firstnames 
	return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*[^-\s]$/.test(firstname);
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
