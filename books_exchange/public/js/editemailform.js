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

function setErrorFor(input, message) {
	const formControl = input.parentElement;
	formControl.className = 'form-control error';
    const inputLabel = document.querySelector('label[for="edit_email_form_email_first"]');
    const inputLabel2 = document.querySelector('label[for="edit_email_form_email_second"]');
    const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
    
    if(input === email) {
        if (inputLi === null) {
            let newUL = document.createElement('ul');
            inputLabel.insertAdjacentElement('afterend', newUL);
            const inputUl = document.querySelector('div#edit_email_form_email>div>ul');
            let newLi = document.createElement('li');
            inputUl.insertAdjacentElement('afterbegin', newLi);
            const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
            inputLi.textContent = message;
        } else {
            inputLi.textContent = message;
        }
    } else {
        if (inputLi === null) {
            let newUL = document.createElement('ul');
            inputLabel2.insertAdjacentElement('afterend', newUL);
            const inputUl = document.querySelector('div#edit_email_form_email>div>ul');
            let newLi = document.createElement('li');
            inputUl.insertAdjacentElement('afterbegin', newLi);
            const inputLi = document.querySelector('div#edit_email_form_email>div>ul>li');
            inputLi.textContent = message;
        }
        else {
            inputLi.textContent = message;
        }
    }
}

function setSuccessFor(input) {
	const formControl = input.parentElement;
	formControl.className = 'form-control success';
}

function isEmail(email) {
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}

/*
Test of Regex Email

https://www.regular-expressions.info/email.html

\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b.

^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$

^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,63}$ 

^[A-Z0-9._%+-]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$ 

^(?=[A-Z0-9@._%+-]{6,254}$)[A-Z0-9._%+-]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,8}[A-Z]{2,63}$ 

^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$

^(?=[A-Z0-9][A-Z0-9@._%+-]{5,253}$)
[A-Z0-9._%+-]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,8}[A-Z]{2,63}$ 

^[A-Z0-9][A-Z0-9._%+-]{0,63}@
(?:[A-Z0-9](?:[A-Z0-9-]{0,62}[A-Z0-9])?\.){1,8}[A-Z]{2,63}$ 

^[A-Z0-9][A-Z0-9._%+-]{0,63}@
(?:(?=[A-Z0-9-]{1,63}\.)[A-Z0-9]+(?:-[A-Z0-9]+)*\.){1,8}[A-Z]{2,63}$

^(?=[A-Z0-9][A-Z0-9@._%+-]{5,253}$)[A-Z0-9._%+-]{1,64}@
(?:(?=[A-Z0-9-]{1,63}\.)[A-Z0-9]+(?:-[A-Z0-9]+)*\.){1,8}[A-Z]{2,63}$

^(?=[A-Z0-9][A-Z0-9@._%+-]{5,253}+$)[A-Z0-9._%+-]{1,64}+@
(?:(?=[A-Z0-9-]{1,63}+\.)[A-Z0-9]++(?:-[A-Z0-9]++)*+\.){1,8}+[A-Z]{2,63}+$



\A(?:[a-z0-9!#$%&'*+/=?^_‘{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_‘{|}~-]+)*
 |  "(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]
      |  \\[\x01-\x09\x0b\x0c\x0e-\x7f])*")
@ (?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?
  |  \[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}
       (?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:
          (?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]
          |  \\[\x01-\x09\x0b\x0c\x0e-\x7f])+)
     \])\z


\A[a-z0-9!#$%&'*+/=?^_‘{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_‘{|}~-]+)*@
(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\z

\A(?=[a-z0-9@.!#$%&'*+/=?^_‘{|}~-]{6,254}\z)
 (?=[a-z0-9.!#$%&'*+/=?^_‘{|}~-]{1,64}@)
 [a-z0-9!#$%&'*+/=?^_‘{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_‘{|}~-]+)*
@ (?:(?=[a-z0-9-]{1,63}\.)[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+
  (?=[a-z0-9-]{1,63}\z)[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\z


*/
