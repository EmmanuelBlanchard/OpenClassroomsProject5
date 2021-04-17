window.onload = () => {
    email.addEventListener('input', checkInputEmail);
}

let form = document.querySelector('#request_form');
const email = document.querySelector('#reset_password_request_form_email');

function checkInputEmail() {
    // trim to remove the whitespaces
    const emailValue = email.value.trim();

    if (emailValue === '') {
        setErrorFor(email, 'Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.');
    } else if (!isEmail(emailValue)) {
        setErrorFor(email, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else {
        setSuccessFor(email);
    }
}

form.addEventListener('submit', event => {
    checkInputs(event);
});

function checkInputs(event) {
    // trim to remove the whitespaces
    const emailValue = email.value.trim();
    // We initialize the score
    let score = 0;

    if (emailValue === '') {
        setErrorFor(email, 'Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.');
    } else if (!isEmail(emailValue)) {
        setErrorFor(email, 'L\'adresse e-mail n\'est pas valide, elle doit comporter au moins une arobase, un caractère point puis au minimun deux caractères');
    } else {
        score++;
        setSuccessFor(email);
    }

    if (score === 1) {
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