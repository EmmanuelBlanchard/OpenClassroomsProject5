window.onload = () => {
	pseudo.addEventListener('input', checkInputPseudo);
	lastname.addEventListener('input', checkInputLastName);
    firstname.addEventListener('input', checkInputFirstName);
    zipcode.addEventListener('input', checkInputZipCode);
    city.addEventListener('input', checkInputCity);
}

let form = document.querySelector('#edit_profile_form');
const pseudo = document.querySelector('#edit_profile_form_pseudo');
const lastname = document.querySelector('#edit_profile_form_lastname');
const firstname = document.querySelector('#edit_profile_form_firstname');
const zipcode = document.querySelector('#edit_profile_form_zipCode');
const city = document.querySelector('#edit_profile_form_city');

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

form.addEventListener('submit', event => {
	//e.preventDefault();
	//console.log('submit');
	checkInputs(event);
});

function checkInputs(event){
	// trim to remove the whitespaces
	const pseudoValue = pseudo.value.trim();
    const lastnameValue = lastname.value.trim();
    const firstnameValue = firstname.value.trim();
    const zipcodeValue = zipcode.value.trim();
    const cityValue = city.value.trim();

    //console.log(pseudoValue, lastnameValue, firstnameValue, zipcodeValue, cityValue);

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

	if(score === 5) {
		return true;
	} else {
		event.preventDefault();
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
	return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*$/.test(lastname);
}

function isFirstNameNumber(lastname) {
	return /\d/.test(lastname);
}

function isFirstName(firstname) {
	return /^[A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{1}([a-zàâäçéèêëîïôöùûüÿæœðó])*[-'’\s]{0,1}([A-ZÀÂÄÇÉÈÊËÎÏÔÖÙÛÜŸÆŒ]{0,1}([a-zàâäçéèêëîïôöùûüÿæœðó]*)[-'’\s]{0,1})*$/.test(firstname);
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
}
