
var uname = document.getElementById("username");
var pwd = document.getElementById("password");
var cpwd = document.getElementById("cpassword");
var dob = document.getElementById("dob");
var avatar = document.getElementById("profilephoto");
var email = document.getElementById("email");
var form = document.getElementById("signup-form");

email.addEventListener("blur", emailHandler);
uname.addEventListener("blur", usernameHandler);
password.addEventListener("blur", passwordHandler);
cpassword.addEventListener("blur", cpasswordHandler);
dob.addEventListener("blur", dobHandler);
avatar.addEventListener("blur", avatarHandler);
form.addEventListener("submit", validateSignup);
