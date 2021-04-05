window.onload = () => {
  password.addEventListener('input', checkInputPassword);
  password2.addEventListener('input', checkInputPassword2);
}

let form = document.querySelector('#editpassword_form');
const password = document.querySelector('#change_password_form_plainPassword_first');
const password2 = document.querySelector('#change_password_form_plainPassword_second');

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
  } else if (!isPasswordLength(passwordValue)) {
    setErrorFor(password, 'Le mot de passe doit comporter au moins 12 caractères');
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
  } else if (!isPasswordLength(passwordValue)) {
    setErrorFor(password, 'Le mot de passe doit comporter au moins 12 caractères');
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
  formControl.className = 'form-control error';

  const inputLabel = document.querySelector('label[for="change_password_form_plainPassword_first"]');
  const inputLabel2 = document.querySelector('label[for="change_password_form_plainPassword_second"]');
  const inputLi = document.querySelector('div#change_password_form_plainPassword>div>ul>li');

  if (input === password) {
    if (inputLi === null) {
      let newUL = document.createElement('ul');
      inputLabel.insertAdjacentElement('afterend', newUL);
      const inputUl = document.querySelector('div#change_password_form_plainPassword>div>ul');
      let newLi = document.createElement('li');
      inputUl.insertAdjacentElement('afterbegin', newLi);
      const inputLi = document.querySelector('div#change_password_form_plainPassword>div>ul>li');
      inputLi.textContent = message;
    } else {
      inputLi.textContent = message;
    }
  } else {
    if (inputLi === null) {
      let newUL = document.createElement('ul');
      inputLabel2.insertAdjacentElement('afterend', newUL);
      const inputUl = document.querySelector('div#change_password_form_plainPassword>div>ul');
      let newLi = document.createElement('li');
      inputUl.insertAdjacentElement('afterbegin', newLi);
      const inputLi = document.querySelector('div#change_password_form_plainPassword>div>ul>li');
      inputLi.textContent = message;
    } else {
      inputLi.textContent = message;
    }
  }
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

function isPasswordLength(password) {
  if (password.length >= 12) {
    return true;
  } else {
    return false;
  }
}

function isPassword(password) {
  return /^(?=.+[A-Z])(?=.+[a-z])(?=.+\d)(?=.+[-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰])([-_?+!*$@%_&~`\/\\^\|\#{}()\[\]#£ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠþÙÚÛÜÝŸàáâãäåæçèéêëìíîïðñòóôõöøœšÞùúûüýÿ¢ß¥£™©®ª×÷±²³¼½¾µ¿¶·¸º°¯§…¤¦≠¬ˆ¨‰\w]{12,})$/.test(password);
}