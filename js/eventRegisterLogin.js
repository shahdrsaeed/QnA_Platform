
var email = document.getElementById("email");
var pwd = document.getElementById("password");

email.addEventListener("blur", emailHandler);
password.addEventListener("blur", passwordHandler);

var form = document.getElementById("login-form");
form.addEventListener("submit", validateLogin);
