window.onload = () => {
	pseudo.addEventListener('input', checkInputPseudo);
	lastname.addEventListener('input', checkInputLastName);
    firstname.addEventListener('input', checkInputFirstName);
    email.addEventListener('input', checkInputEmail);
    password.addEventListener('input', checkInputPassword);
    zipcode.addEventListener('input', checkInputZipCode);
    city.addEventListener('input', checkInputCity);
	agreeterms.addEventListener('input', checkInputAgreeTerms);
}

let form = document.querySelector('#registration_form');
const pseudo = document.querySelector('#registration_form_pseudo');
const lastname = document.querySelector('#registration_form_lastname');
const firstname = document.querySelector('#registration_form_firstname');
const email = document.querySelector('#registration_form_email');
const password = document.querySelector('#registration_form_plainPassword');
const zipcode = document.querySelector('#registration_form_zipCode');
const city = document.querySelector('#registration_form_city');
const agreeterms = document.querySelector('#registration_form_agreeTerms');

function checkInputPseudo(){
	// trim to remove the whitespaces
	const pseudoValue = pseudo.value.trim();

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
}
function checkInputLastName(){
	// trim to remove the whitespaces
	const lastnameValue = lastname.value.trim();

	if(lastnameValue === '') {
		setErrorFor(lastname, 'Le nom ne peut pas être vide');
	} else if (isLastNameNumber(lastnameValue)) {
        setErrorFor(lastname, 'Le nom ne peut pas contenir un nombre');
    } else if (!isLastName(lastnameValue)) {
		setErrorFor(lastname, 'La première lettre du nom doit être en majuscule');
	} else {
		setSuccessFor(lastname);
	}
}
function checkInputFirstName(){
	// trim to remove the whitespaces
	const firstnameValue = firstname.value.trim();

	if(firstnameValue === '') {
		setErrorFor(firstname, 'Le prénom ne peut pas être vide');
	} else if (isFirstNameNumber(firstnameValue)) {
        setErrorFor(firstname, 'Le prénom ne peut pas contenir un nombre ');
    } else if (!isFirstName(firstnameValue)) {
		setErrorFor(firstname, 'La première lettre du prénom doit être en majuscule');
	} else {
		setSuccessFor(firstname);
	}
}
function checkInputEmail(){
	// trim to remove the whitespaces
	const emailValue = email.value.trim();

	if(emailValue === '') {
		setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
	} else if (!isEmail(emailValue)) {
		setErrorFor(email, 'L\'adresse e-mail n\'est pas valide');
	} else {
		setSuccessFor(email);
	}
}
function checkInputPassword(){
	// trim to remove the whitespaces
	const passwordValue = password.value.trim();

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
}
function checkInputZipCode(){
	// trim to remove the whitespaces
	const zipcodeValue = zipcode.value.trim();

	if(zipcodeValue === '') {
		setErrorFor(zipcode, 'Le code postal ne peut pas être vide');
	} else if (!isZipCode(zipcodeValue)) {
		setErrorFor(zipcode, 'Le code postal doit comporter 5 chiffres');
	} else {
		setSuccessFor(zipcode);
	}
}
function checkInputCity(){
	// trim to remove the whitespaces
	const cityValue = city.value.trim();

	if(cityValue === '') {
		setErrorFor(city, 'Le nom de la ville ne peut pas être vide');
	} else if (isCityNumber(cityValue)) {
		setErrorFor(city, 'Le nom de la ville ne peut pas comporter des chiffres');
	} else if (!isCityLengthMin(cityValue)) {
        setErrorFor(city, 'Le nom de la ville doit comporter au minimun 1 caractère');
    } else if (!isCityLengthMax(cityValue)) {
        setErrorFor(city, 'Le nom de la ville doit comporter au maximun 50 caractères');
	} else if (!isCity(cityValue)) {
		setErrorFor(city, 'Le nom de la ville n\'est pas valide');
	} else {
		setSuccessFor(city);
	}
}

function checkInputAgreeTerms(){
	const agreetermsValue = agreeterms.checked;
	if(agreetermsValue === false) {
		console.log('CGU Désactivés !');
		setErrorFor(agreeterms, 'La case doit être coché pour s\'inscrire.');
	} else {
		setSuccessFor(agreeterms);
	}
}

form.addEventListener('submit', e => {
	//e.preventDefault();
	console.log('submit');
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
	const agreetermsValue = agreeterms.checked;
    
    //console.log(pseudoValue);

	// We initialize the score
	let score = 0;

	if(pseudoValue === '') {
		setErrorFor(pseudo, 'Le pseudo ne peut pas être vide');
	} else if (!isPseudoNumberMin(pseudoValue)) {
        setErrorFor(pseudo, 'Le pseudo doit comporter au moins 7 caractères');
    } else if (isPseudoNumberMax(pseudoValue)) {
        setErrorFor(pseudo, 'Le pseudo ne peut pas comporter plus de 15 caractères');
    } else if (!isPseudoNoSpace(pseudoValue)) {
		setErrorFor(pseudo, 'Le pseudo ne peut pas contenir le caractère espace (les caractères - et _ sont autorisés)');
    } else {
		score++;
		setSuccessFor(pseudo);
	}
	
    if(lastnameValue === '') {
		setErrorFor(lastname, 'Le nom ne peut pas être vide');
	} else if (isLastNameNumber(lastnameValue)) {
        setErrorFor(lastname, 'Le nom ne peut pas contenir un nombre');
    } else if (!isLastName(lastnameValue)) {
		setErrorFor(lastname, 'La première lettre du nom doit être en majuscule');
	} else {
		score++;
		setSuccessFor(lastname);
	}

    if(firstnameValue === '') {
		setErrorFor(firstname, 'Le prénom ne peut pas être vide');
	} else if (isFirstNameNumber(firstnameValue)) {
        setErrorFor(firstname, 'Le prénom ne peut pas contenir un nombre ');
    } else if (!isFirstName(firstnameValue)) {
		setErrorFor(firstname, 'La première lettre du prénom doit être en majuscule');
	} else {
		score++;
		setSuccessFor(firstname);
	}

	if(emailValue === '') {
		setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
	} else if (!isEmail(emailValue)) {
		setErrorFor(email, 'L\'adresse e-mail n\'est pas valide');
	} else {
		score++;
		setSuccessFor(email);
	}
	
	if(passwordValue === '') {
		setErrorFor(password, 'Le mot de passe ne peut pas être vide');
	} else if (!isPasswordTiny(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins une lettre minuscule');
    } else if (!isPasswordUppercase(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins une une lettre majuscule');
    } else if (!isPasswordNumber(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins un chiffre');
    } else if (!isPasswordSpecial(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins un caractère spécial');
    } else if (!isPasswordLength(passwordValue)) {
		setErrorFor(password, 'Le mot de passe doit comporter au moins 12 caractères');
    } else if (!isPassword(passwordValue)) {
		setErrorFor(password, 'Le mot de passe n\'est pas valide, il doit comporter au moins une lettre minuscule, une lettre majuscule, un chiffre, un caractère spécial et 12 caractères minimun');
    } else {
		score++;
		setSuccessFor(password);
	}
	
    if(zipcodeValue === '') {
		setErrorFor(zipcode, 'Le code postal ne peut pas être vide');
	} else if (!isZipCode(zipcodeValue)) {
		setErrorFor(zipcode, 'Le code postal doit comporter 5 chiffres');
	} else {
		score++;
		setSuccessFor(zipcode);
	}
    
    if(cityValue === '') {
		setErrorFor(city, 'Le nom de la ville ne peut pas être vide');
	} else if (isCityNumber(cityValue)) {
		setErrorFor(city, 'Le nom de la ville ne peut pas comporter des chiffres');
	} else if (!isCityLengthMin(cityValue)) {
        setErrorFor(city, 'Le nom de la ville doit comporter au minimun 1 caractère');
    } else if (!isCityLengthMax(cityValue)) {
        setErrorFor(city, 'Le nom de la ville doit comporter au maximun 50 caractères');
	} else if (!isCity(cityValue)) {
		setErrorFor(city, 'Le nom de la ville n\'est pas valide');
	} else {
		score++;
		setSuccessFor(city);
	}

	// Add registration_form_agreeTerms
	// Add below the verification if checked or not for the score
	//document.getElementById("registration_form_agreeTerms").checked;
	if(agreetermsValue === false) {
		console.log('CGU Désactivés !');
		setErrorFor(agreeterms, 'La case doit être coché pour s\'inscrire.');
	} else {
		score++;
		setSuccessFor(agreeterms);
	}

	if(score === 8) {
		console.log(score);
		//document.querySelector('[type="submit"]').style.display = "initial";
		document.querySelector('#registration_form_save').style.display = "initial";
		return true;
	} else {
		console.log(score);
		//document.querySelector('[type="submit"]').style.display = "none";
		document.querySelector('#registration_form_save').style.display = "none";
		console.log('Faux Champ(s) avec erreur !');
		return false;
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
	// no space or dash character at the end of the Name - Problem with the name O
	//return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*[^-\s]$/.test(lastname);
	return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*$/.test(lastname);
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
	return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*$/.test(firstname);
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

function isPasswordNumber(password) {
	return /\d/.test(password);
}

function isPasswordSpecial(password) {
    return /[-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰]/.test(password);
}

function isPasswordLength(password) {
    if(password.length >= 12) {
        return true;
    } else {
        return false;
    }
}

function isPassword(password) {
    return /^(?=.+[A-Z])(?=.+[a-z])(?=.+\d)(?=.+[-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰])([-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰\w]{12,})$/.test(password);
}

function isZipCode(zipcode) {
    return /^[0-9]{5}$/.test(zipcode);
}

function isCityLengthMin(city)  {
    if(city.length >= 1) {
        return true;
    }
}

function isCityLengthMax(city)  {
    if(city.length <= 50) {
        return true;
    }
}

function isCityNumber(city) {
    return /^[0-9]$/.test(city);
}

function isCity(city) {
    return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒa-zàâäçéèêëîïôöùûüÿæœðó]+(?:[-'\s][a-zàâäçéèêëîïôöùûüÿæœðóA-ZZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]+)*$/.test(city);
	// L'Abergement-Clémenciat | L'Abergement-de-Varey | Saint-Denis-lès-Bourg | Saint-Étienne-sur-Reyssouze | Boyeux-Saint-Jérôme | Cormoranche-sur-Saône | Cruzilles-lès-Mépillat
}
