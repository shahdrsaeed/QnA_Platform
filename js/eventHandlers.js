/* sign up + login */
function validateEmail(email) {
    // regex for basic email validation: Checks presence of @ and .
    let emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegEx.test(email);
}

function validatePWD(password) {
    // Password must be 6 characters long and contain at least one non-letter character
    return password.length >= 6 && /[a-zA-Z].*[0-9]|[0-9].*[a-zA-Z]/.test(password);
}

function passwordsMatch(password, cpassword) {
    //checking if password matches
    return password === cpassword;
}

function validateUsername(uname) {
    let unameRegEx = /^[a-zA-Z0-9_]+$/;
    //no space or non characters
	if (unameRegEx.test(uname))
		return true;
	else
		return false;
}

function validateAvatar(avatarInput) {
    // Check if the input is empty by looking at its files length
    //return avatarInput.files.length !== 0;
  let avatarRegEx = /^[^\n]+.[a-zA-Z]{3,4}$/;

  if (avatarRegEx.test(avatarInput))
    return true;
  else
    return false;
}

function validateDOB(dob) {
	// yyyy-mm-dd
	let dobRegEx = /^\d{4}[-]\d{2}[-]\d{2}$/;

	if (dobRegEx.test(dob))
		return true;
	else
		return false;
}

/* Qcreation */
function validateQuestionInput(inputValue) {
    // Count the number of characters in the input
    var charCount = inputValue.length;
    
    // Check if the input is not empty and does not exceed 1500 characters
    return charCount > 0 && charCount <= 1500;
}
/*---------------*/


/* handler functions */

function emailHandler(event){
    let emailInput = event.target;

    if (!validateEmail(emailInput.value)) {
        emailInput.classList.add("input-error");
        document.getElementById("error-text-email").classList.remove("hidden");
    } else {
        emailInput.classList.remove("input-error");
        document.getElementById("error-text-email").classList.add("hidden");
    }
}

function passwordHandler(event){
    let password = event.target;

    if (!validatePWD(password.value)) {
        password.classList.add("input-error");
        document.getElementById("error-text-password").classList.remove("hidden");
    } else {
        password.classList.remove("input-error");
        document.getElementById("error-text-password").classList.add("hidden");
    }
}

function cpasswordHandler(event) {
    let password = document.getElementById("password");
    let cpassword = event.target;

    if (!passwordsMatch(password.value, cpassword.value)) {
        cpassword.classList.add("input-error");
        document.getElementById("error-text-cpassword").classList.remove("hidden");
    } else {
        cpassword.classList.remove("input-error");
        document.getElementById("error-text-cpassword").classList.add("hidden");
    }
}

function usernameHandler(event){
	let uname = event.target;
	if (!validateUsername(uname.value)) {
		uname.classList.add("input-error");
		document.getElementById("error-text-username").classList.remove("hidden");
	} 
	else {
		uname.classList.remove("input-error");
		document.getElementById("error-text-username").classList.add("hidden");
	}
}

function avatarHandler(event) {
    let avatarInput = event.target;

    // Check if the input is empty
    if (!validateAvatar(avatarInput)) {
        avatarInput.classList.add("input-error");
        document.getElementById("error-text-profilephoto").classList.remove("hidden");
    } else {
        avatarInput.classList.remove("input-error");
        document.getElementById("error-text-profilephoto").classList.add("hidden");
    }
}

function dobHandler(event){
	let dob = event.target;

	if (!validateDOB(dob.value)) {
		dob.classList.add("input-error");
		document.getElementById("error-text-dob").classList.remove("hidden");
	}
	else {
		dob.classList.remove("input-error");
		document.getElementById("error-text-dob").classList.add("hidden");
	}
}

function validateQCreationInput(create) {
  if (create.length > 0)
    return true;
  else
    return false;
}

function validateQDetailsInput(answer) {
  if (answer.length > 0)
    return true;
  else
    return false;
}

function validateQcreation(event) {
  let create = document.getElementById("Qcreation");
  let isFormValid = true;
  let qCreation_error_text = document.getElementById("error-text-qCreation");
  if (!validateQCreationInput(create.value)) {
    create.classList.add("input-error");
    qCreation_error_text.classList.remove("hidden");
    isFormValid = false;
  }
  else {
    create.classList.remove("input-error");
    qCreation_error_text.classList.add("hidden");
  }

  if (!isFormValid) {
    event.preventDefault();
  }
  else {
    console.log("Form is valid");
  }
}

//validate QDetails
function validateQdetails(event) {
  let answer = document.getElementById("Qdetails");
  let isFormValid = true;
  let qDetails_error_text = document.getElementById("error-text-qDetails");
  if (!validateQDetailsInput(answer.value)) {
    answer.classList.add("input-error");
    qDetails_error_text.classList.remove("hidden");
    isFormValid = false;
  }
  else {
    answer.classList.remove("input-error");
    qDetails_error_text.classList.add("hidden");
  }

  if (!isFormValid) {
    event.preventDefault();
  }
  else {
    console.log("Form is valid");
  }
}

// Dynamic Character Counter
function count(obj){
    var maxAmount = 1500;
    var strLength = obj.value.length;
    var charRemaining = (maxAmount - strLength);

    if(charRemaining < 0){
        document.getElementById("charNum").innerHTML = '<span style="color: red;">Exceeded the limit of '+maxAmount+' characters</span>';
    }else{
        document.getElementById("charNum").innerHTML = charRemaining+' characters remaining';
    }
}

function validateLogin(event) {
  let email = document.getElementById("email");
  let password = document.getElementById("password");
  let isFormValid = true;

  if(!validateEmail(email.value)) {
    email.classList.add("input-error");
    document.getElementById("error-text-email").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    email.classList.remove("input-error");
    document.getElementById("error-text-email").classList.add("hidden");
  }
  if(!validatePWD(password.value)) {
    password.classList.add("input-error");
    document.getElementById("error-text-password").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    password.classList.remove("input-error");
    document.getElementById("error-text-password").classList.add("hidden");
  }

  if(!isFormValid) {
    event.preventDefault();
  }
}

function validateSignup(event) {
  let email = document.getElementById("email");
  let uname = document.getElementById("username");
  let password = document.getElementById("password");
  let cpassword = document.getElementById("cpassword");
  let dob = document.getElementById("dob");
  let avatar = document.getElementById("profilephoto");
  let isFormValid = true;
  
  if(!validateEmail(email.value)) {
      email.classList.add("input-error");
      document.getElementById("error-text-email").classList.remove("hidden");
       isFormValid = false;
    }
    else {
      email.classList.remove("input-error");
      document.getElementById("error-text-email").classList.add("hidden");
    }
  

  if(!validateUsername(uname.value)) {
    uname.classList.add("input-error");
    document.getElementById("error-text-username").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    uname.classlist.remove("input-error");
    document.getElementById("error-text-username").classList.add("hidden");
  }

  if(!validatePWD(password.value)) {
    password.classList.add("input-error");
    document.getElementById("error-text-password").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    password.classList.remove("input-error");
    document.getElementById("error-text-password").classList.add("hidden");
  }

  if(!passwordsMatch(password.value, cpassword.value)) {
    password.classList.add("input-error");
    document.getElementById("error-text-cpassword").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    password.classList.remove("input-error");
    document.getElementById("error-text-cpassword").classList.add("hidden");
  }

  if(!validateDOB(dob.value)) {
    dob.classList.add("input-error");
    document.getElementById("error-text-dob").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    dob.classList.remove("input-error");
    document.getElementById("error-text-dob").classList.add("hidden");
  }

  if(!validateAvatar(avatar.value)) {
    avatar.classList.add("input-error");
    document.getElementById("error-text-profilephoto").classList.remove("hidden");
    isFormValid = false;
  }
  else {
    avatar.classList.remove("input-error");
    document.getElementById("error-text-profilephoto").classList.add("hidden");
  }
  
  if(!isFormValid) {
    event.preventDefault();
  }
}