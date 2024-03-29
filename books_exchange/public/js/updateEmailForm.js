window.onload = () => {
    email.addEventListener('input', checkInputEmail);
    email2.addEventListener('input', checkInputEmail2);
}

let form = document.querySelector('#update_email_form');
const email = document.querySelector('#update_email_form_email_first');
const email2 = document.querySelector('#update_email_form_email_second');

function checkInputEmail() {
    // trim to remove the whitespaces
    const emailValue = email.value.trim();

    if (emailValue === '') {
        setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
    } else if (!isEmail(emailValue)) {
        setErrorFor(email, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else {
        setSuccessFor(email);
    }
}

function checkInputEmail2() {
    // trim to remove the whitespaces
    const emailValue = email.value.trim();
    const email2Value = email2.value.trim();

    if (email2Value === '') {
        setErrorFor(email2, 'L\'adresse e-mail répétée ne peut pas être vide');
    } else if (emailValue !== email2Value) {
        setErrorFor(email2, 'Les adresses e-mail ne correspondent pas');
    } else {
        setSuccessFor(email2);
    }
}

form.addEventListener('submit', event => {
    checkInputs(event);
});

function checkInputs(event) {
    // trim to remove the whitespaces
    const emailValue = email.value.trim();
    const email2Value = email2.value.trim();

    // We initialize the score
    let score = 0;

    if (emailValue === '') {
        setErrorFor(email, 'L\'adresse e-mail ne peut pas être vide');
    } else if (!isEmail(emailValue)) {
        setErrorFor(email, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else {
        score++;
        setSuccessFor(email);
    }

    if (email2Value === '') {
        setErrorFor(email2, 'L\'adresse e-mail répétée ne peut pas être vide');
    } else if (emailValue !== email2Value) {
        setErrorFor(email2, 'Les adresses e-mail ne correspondent pas');
    } else {
        score++;
        setSuccessFor(email2);
    }

    if (score === 2) {
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

function isEmail(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}