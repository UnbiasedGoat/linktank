function verifyLogin(username, password){
	var dataString = username+"&&"+password;
		alert(dataString);
		$.ajax({
			type	: "POST",
			url		: "verifyLogin.php",
			data	: dataString,
			cache	: false,
			success: function(result){
				var result=trim(result);
				if(result=='correct'){
					alert("Correct");
				}else{
					alert("Wrong");
					$("#errorMessage").html(result);
				}
			}
		});
		return false;
}


function validateFormOnSubmit(theForm) {
	var reason = "";
		reason += validatePassword(theForm.password);
		reason += validateEmail(theForm.username);

		if (reason != "") {
			alert("Some fields need correction:\n" + reason);
			var display = reason;
			document.getElementById("display").innerHTML = display;
			return false;
		}
		verifyLogin(theForm.username, theForm.password);
		return false;
}

function trim(s){
	return s.replace(/^\s+|\s+$/, '');
}

function validateEmail(fld) {
	var error="";
	var tfld 			= trim(fld.value);                        // value of field with whitespace trimmed off
	var emailFilter 	= /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
	var illegalChars	= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
	var pass1 			= document.getElementById('email');

	if (fld.value == "") {
		fld.style.background = 'Yellow';
		error = "You didn't enter an email address.\n";
	} else if (!emailFilter.test(tfld)) {              //test email for illegal characters
		fld.style.background = 'Yellow';
		error = "Please enter a valid email address.\n";
	} else if (fld.value.match(illegalChars)) {
	fld.style.background = 'Yellow';
	error = "The email address contains illegal characters.\n";
	} else {
		fld.style.background = 'White';	
	}
	return error;
}

function validatePassword(fld) {
var error = "";
var illegalChars = /[\W_]/; // allow only letters and numbers 

if (fld.value == "") {
fld.style.background = 'Yellow';
error = "You didn't enter a password.\n";
} else if ((fld.value.length < 7) || (fld.value.length > 15)) {
error = "The password is the wrong length. \n";
fld.style.background = 'Yellow';
} else if (illegalChars.test(fld.value)) {
error = "The password contains illegal characters.\n";
fld.style.background = 'Yellow';
} 
else if ((fld.value.search(/[a-zA-Z]+/)==-1) || (fld.value.search(/[0-9]+/)==-1)){
error = "The password must contain at least one numeral.\n";
fld.style.background = 'Yellow';
} 
else {
fld.style.background = 'White';
}
return error;
}   