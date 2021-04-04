window.onload = () => {
    email.addEventListener('input', checkInputEmail);
    email2.addEventListener('input', checkInputEmail2);
}

let form = document.querySelector('#editemail_form');
const email = document.querySelector('#edit_email_form_email_first');
const email2 = document.querySelector('#edit_email_form_email_second');

function checkInputEmail(){
	// trim to remove the whitespaces
	const emailValue = email.value.trim();

    if(emailValue === '') {
		setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
	} else if (!isEmail(emailValue)) {
		setErrorFor(email, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else {
		setSuccessFor(email);
	}
}

function checkInputEmail2(){
	// trim to remove the whitespaces
	const emailValue = email.value.trim();
    const email2Value = email2.value.trim();

    if(email2Value === '') {
		setErrorFor(email2, 'L\'adresse e-mail répétée ne peut pas être vide');
	} else if (!isEmail(email2Value)) {
		setErrorFor(email2, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else if(emailValue !== email2Value) {
		setErrorFor(email2, 'Les adresses e-mail ne correspondent pas');
	} else {
		setSuccessFor(email2);
	}
}

form.addEventListener('submit', event => {
	checkInputs(event);
});

function checkInputs(event){
	// trim to remove the whitespaces
	const emailValue = email.value.trim();
    const email2Value = email2.value.trim();

	// We initialize the score
	let score = 0;
	
	if(emailValue === '') {
		setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
	} else if (!isEmail(emailValue)) {
		setErrorFor(email, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else {
		score++;
		setSuccessFor(email);
	}

    if(email2Value === '') {
		setErrorFor(email2, 'L\'adresse e-mail répétée ne peut pas être vide');
	} else if (!isEmail(email2Value)) {
		setErrorFor(email2, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else if(emailValue !== email2Value) {
		setErrorFor(email2, 'Les adresses e-mail ne correspondent pas');
	} else {
		score++;
		setSuccessFor(email2);
	}

	if(score === 2) {
		return true;
	} else {
		event.preventDefault();
		return false;
	}
}
/*
const inputLabel = document.querySelector('label[for="edit_email_form_email_first"]');
let newUL = document.createElement('ul');
inputLabel.insertAdjacentElement('afterend', newUL);
console.log(inputLabel, 'inpuLabel : ');
//const inputUl = document.querySelector('form#editemail_form>div.form-control>div#edit_email_form_email>div>ul');
const inputUl = document.querySelector('div#edit_email_form_email>div>ul');
console.log(inputUl);
let newLi = document.createElement('li');
console.log(newLi);
inputUl.insertAdjacentElement('afterbegin', newLi);
const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
inputLi.textContent = "L\'adresse e-mail ne peut pas être vide";
*/
/*
const inputLabel2 = document.querySelector('label[for="edit_email_form_email_second"]');
let newUL = document.createElement('ul');
inputLabel2.insertAdjacentElement('afterend', newUL);
console.log(inputLabel2, 'inpuLabel : ');
//const inputUl = document.querySelector('form#editemail_form>div.form-control>div#edit_email_form_email>div>ul');
const inputUl = document.querySelector('div#edit_email_form_email>div>ul');
console.log(inputUl);
let newLi = document.createElement('li');
console.log(newLi);
inputUl.insertAdjacentElement('afterbegin', newLi);
const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
inputLi.textContent = "L\'adresse e-mail repetée ne peut pas être vide";
*/

function setErrorFor(input, message) {
	const formControl = input.parentElement;
	//const small = formControl.querySelector('small');
    //const small = document.querySelector('#editpassword_form>div.form-control>small');
	formControl.className = 'form-control error';
	//small.innerText = message;
    
    // Test
    const inputLabel = document.querySelector('label[for="edit_email_form_email_first"]');
    const inputLabel2 = document.querySelector('label[for="edit_email_form_email_second"]');
    
    //console.log(input,'Input dans setErrorFor');

    const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
    
    if(input === email) {
        console.log('Dans input === email !');
        if (inputLi === null) {
            let newUL = document.createElement('ul');
            console.log(newUL);
            inputLabel.insertAdjacentElement('afterend', newUL);
            console.log(inputLabel);
            console.log(input, 'Dans input === email et inpuLi === null !');
            const inputUl = document.querySelector('div#edit_email_form_email>div>ul');
            console.log(inputUl , 'InputUl crée : ?');
            let newLi = document.createElement('li');
            inputUl.insertAdjacentElement('afterbegin', newLi);
            const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
            //inputLi.innerTexT = message;
            inputLi.textContent = message;
        } else {
            console.log('Dans input === email et inpuLi !== null');
            //inputLi.innerTexT = message;
            inputLi.textContent = message;
        }
        
    } else if(input === email2) {
        //console.log('Dans input === email2');
        if (inputLi === null) {
            console.log(input, 'Dans input === email2 et inpuLi === null !');
            let newUL = document.createElement('ul');
            inputLabel2.insertAdjacentElement('afterend', newUL);
            const inputUl = document.querySelector('div#edit_email_form_email>div>ul');
            let newLi = document.createElement('li');
            inputUl.insertAdjacentElement('afterbegin', newLi);
            const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
            //inputLi.innerTexT = message;
            inputLi.textContent = message;
        }
        else {
            //console.log('Dans input === email2 et inpuLi !== null');
            //inputLi.innerTexT = message;
            inputLi.textContent = message;
        }
    } else {
        console.log('dans else');
    }
}

function setSuccessFor(input) {
	const formControl = input.parentElement;
	formControl.className = 'form-control success';
}

function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}