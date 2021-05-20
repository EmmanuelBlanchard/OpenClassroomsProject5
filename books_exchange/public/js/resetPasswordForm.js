window.onload = () => {
    password.addEventListener('input', checkInputPassword);
    password2.addEventListener('input', checkInputPassword2);
}

let form = document.querySelector('#reset_password_form');
const password = document.querySelector('#update_password_form_plainPassword_first');
const password2 = document.querySelector('#update_password_form_plainPassword_second');

function checkInputPassword() {
    // trim to remove the whitespaces
    const passwordValue = password.value.trim();

    if (passwordValue === '') {
        setErrorFor(password, 'Le mot de passe ne peut pas être vide');
    } else if (!isPasswordTiny(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins une lettre minuscule');
    } else if (!isPasswordUppercase(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins une une lettre majuscule');
    } else if (!isPasswordNumber(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins un chiffre');
    } else if (!isPasswordSpecial(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins un caractère spécial');
    } else if (!isPasswordLengthMin(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins 12 caractères');
    } else if (!isPasswordLengthMax(passwordValue)) {
        setErrorFor(password, 'Le mot de passe ne peut pas comporter plus de 4096 caractères');
    } else if (!isPassword(passwordValue)) {
        setErrorFor(password, 'Le mot de passe n\'est pas valide, il doit comporter au moins une lettre minuscule, une lettre majuscule, un chiffre, un caractère spécial et 12 caractères minimun');
    } else {
        setSuccessFor(password);
    }
}

function checkInputPassword2() {
    // trim to remove the whitespaces
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    if (password2Value === '') {
        setErrorFor(password2, 'Le mot de passe répété ne peut pas être vide');
    } else if (passwordValue !== password2Value) {
        setErrorFor(password2, 'Les mots de passe ne correspondent pas');
    } else {
        setSuccessFor(password2);
    }
}

form.addEventListener('submit', event => {
    checkInputs(event);
});

function checkInputs(event) {
    // trim to remove the whitespaces
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    // We initialize the score
    let score = 0;

    if (passwordValue === '') {
        setErrorFor(password, 'Le mot de passe ne peut pas être vide');
    } else if (!isPasswordTiny(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins une lettre minuscule');
    } else if (!isPasswordUppercase(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins une une lettre majuscule');
    } else if (!isPasswordNumber(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins un chiffre');
    } else if (!isPasswordSpecial(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins un caractère spécial');
    } else if (!isPasswordLengthMin(passwordValue)) {
        setErrorFor(password, 'Le mot de passe doit comporter au moins 12 caractères');
    } else if (!isPasswordLengthMax(passwordValue)) {
        setErrorFor(password, 'Le mot de passe ne peut pas comporter plus de 4096 caractères');
    } else if (!isPassword(passwordValue)) {
        setErrorFor(password, 'Le mot de passe n\'est pas valide, il doit comporter au moins une lettre minuscule, une lettre majuscule, un chiffre, un caractère spécial et 12 caractères minimun');
    } else {
        score++;
        setSuccessFor(password);
    }

    if (password2Value === '') {
        setErrorFor(password2, 'Le mot de passe répété ne peut pas être vide');
    } else if (passwordValue !== password2Value) {
        setErrorFor(password2, 'Les mots de passe ne correspondent pas');
    } else {
        score++;
        setSuccessFor(password2);
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

function isPasswordLengthMin(password) {
    if (password.length >= 12) {
        return true;
    }
}

function isPasswordLengthMax(password) {
    if (password.length <= 4096) {
        return true;
    }
}

function isPassword(password) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰])[-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰\w]{12,4096}$/.test(password);
}