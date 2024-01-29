const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const confirmedPasswordInput = form.querySelector('input[name="password2"]');
const emailMessage = document.querySelector('.email-message');
const passwordMessage = document.querySelector('.password-message');
const passwordMessage2 = document.querySelector('.password-message2');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function isStrongPassword(password) {
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
    return passwordRegex.test(password);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

function markValidation(element, condition, messageElement, message) {
    if (condition) {
        element.classList.remove('no-valid');
        messageElement.textContent = '';
    } else {
        element.classList.add('no-valid');
        messageElement.textContent = message;
    }
}

function validateEmail() {
    markValidation(emailInput, isEmail(emailInput.value), emailMessage, 'Invalid email address');
}

function validatePassword() {
    const passwordValue = passwordInput.value;
    const confirmedPasswordValue = confirmedPasswordInput.value;

    const isStrong = isStrongPassword(passwordValue);
    const areSame = arePasswordsSame(passwordValue, confirmedPasswordValue);

    markValidation(passwordInput, isStrong, passwordMessage, 'Password must be at least 8 characters long, and include lowercase, uppercase, and a number');
    markValidation(confirmedPasswordInput, areSame, passwordMessage2, 'Passwords are not the same');
}

emailInput.addEventListener('keyup', validateEmail);
passwordInput.addEventListener('keyup', validatePassword);
confirmedPasswordInput.addEventListener('keyup', validatePassword);
