


function validateFormOnSubmit(theForm) {
var reason = "";
  reason += validateEmpty(theForm.fname);
  reason += validateEmpty2(theForm.lname);
  reason += validateUsername(theForm.username);
  reason += validateEmail(theForm.email);
  reason += validateEmail(theForm.email2);
  reason += validatePassword(theForm.password);
  reason += validatePassword(theForm.password2);
  reason += validateDate2(theForm.month);
  reason += validateDate(theForm.day);
  reason += validateDate3(theForm.year);
      
  if (reason != "") {
    alert("Some fields need correction:\n" + reason);
    var display = reason;
    document.getElementById("display").innerHTML = display;
    return false;
  }

  return true;
}

function trim(s)
{
  return s.replace(/^\s+|\s+$/, '');
}

function validateEmail(fld) {
    var error="";
    var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
    var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
    var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
    var pass1 = document.getElementById('email');
    var pass2 = document.getElementById('email2');
   
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "You didn't enter an email address.\n";
    } else if (!emailFilter.test(tfld)) {              //test email for illegal characters
        fld.style.background = 'Yellow';
        error = "Please enter a valid email address.\n";
    } else if (fld.value.match(illegalChars)) {
        fld.style.background = 'Yellow';
        error = "The email address contains illegal characters.\n";
    }     else if ((email.value != email2.value)) {
        error = "The emails must be equal.\n";
        fld.style.background = 'Yellow';
    } else {
        fld.style.background = 'White';
    }
    return error;
}

function validatePassword(fld) {
    var error = "";
    var illegalChars = /[\W_]/; // allow only letters and numbers 
    var pass1 = document.getElementById('password');
    var pass2 = document.getElementById('password2');
    
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "You didn't enter a password.\n";
    } else if ((fld.value.length < 8) || (fld.value.length > 15)) {
        error = "The password is the wrong length. Must be more than 7 characters but less than 15. \n";
        fld.style.background = 'Yellow';
    } else if (illegalChars.test(fld.value)) {
        error = "The password contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
        error = "The password must contain at least one numeral.\n";
        fld.style.background = 'Yellow';
    } 
    else if ((fld.value.search(/[a-zA-Z]+/)==-1) || (fld.value.search(/[0-9]+/)==-1)){
        error = "The password must contain at least one numeral.\n";
        fld.style.background = 'Yellow';
    }
    else if ((password.value != password2.value)) {
        error = "The passwords must be equal.\n";
        fld.style.background = 'Yellow';
    }
    else {
        fld.style.background = 'White';
    }
   return error;
}   

function validateEmpty(fld) {
	 var error = "";
	    var illegalChars = /\W/;
	 
	    if (fld.value == "") {
	        fld.style.background = 'Yellow'; 
	        error = "You didn't enter a first name.\n";
	    } else if (fld.value.length < 1) {
	        fld.style.background = 'Yellow'; 
	        error = "The first name is the wrong length.\n";
	    } else if (illegalChars.test(fld.value)) {
	        fld.style.background = 'Yellow'; 
	        error = "The first name contains illegal characters.\n";
	    } else {
	        fld.style.background = 'White';
	    }
	    return error;
	}

function validateEmpty2(fld) {
	 var error = "";
	    var illegalChars = /\W/;
	 
	    if (fld.value == "") {
	        fld.style.background = 'Yellow'; 
	        error = "You didn't enter a last name.\n";
	    } 
	    else if (fld.value.length < 1) {
	        fld.style.background = 'Yellow'; 
	        error = "The last name is the wrong length.\n";
	    } 
	    else if (illegalChars.test(fld.value)) {
	        fld.style.background = 'Yellow'; 
	        error = "The last name contains illegal characters.\n";
	    } else {
	        fld.style.background = 'White';
	    }
	    return error;
	}




function validateDate(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    
    var month1 = document.getElementById('month');
    var year1 = document.getElementById('year');


   if (fld.value == "") {
        error = "You didn't enter a day.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The day contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!(stripped.length == 2)) {
        error = "The day is the wrong length.\n";
        fld.style.background = 'Yellow';
    }
    else if (((fld.value < 1) || (fld.value > 30)) && (month1.value == 09)) {
        fld.style.background = 'Yellow'; 
        error = "Incorrect number of days. \n";
    }
    else if (((fld.value < 1) || (fld.value > 30)) && (month1.value == 11)) {
        fld.style.background = 'Yellow'; 
        error = "Incorrect number of days. \n";
    }
    else if (((fld.value < 1) || (fld.value > 30)) && (month1.value == 06)) {
        fld.style.background = 'Yellow'; 
        error = "Incorrect number of days. \n";
    }
    else if (((fld.value < 1) || (fld.value > 30)) && (month1.value == 04)) {
        fld.style.background = 'Yellow'; 
        error = "Incorrect number of days. \n";
    }
    else if ((((fld.value == 29)) && (month1.value == 02)) && (year1.value % 4 == 0)) {
    	fld.style.background = 'White';
    }
    else if (((fld.value < 1) || (fld.value > 28)) && (month1.value == 02)) {
        fld.style.background = 'Yellow'; 
        error = "Incorrect number of days. \n";
    }
    else if ((fld.value < 1) || (fld.value > 31)) {
        fld.style.background = 'Yellow'; 
        error = "Incorrect number of days. \n";
    }
   
    else {
        fld.style.background = 'White';
    }
    return error;
}

function validateDate2(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (fld.value == "") {
        error = "You didn't enter a month.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The month contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!(stripped.length == 2)) {
        error = "The month is the wrong length.\n";
        fld.style.background = 'Yellow';
    }
    else if ((fld.value < 0) || (fld.value > 12)) {
        fld.style.background = 'Yellow'; 
        error = "This is not a real month. Please enter a correct one. \n";
    }
    else {
        fld.style.background = 'White';
    }
    return error;
}

function validateDate3(fld) {
    var error = "";
    var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, '');    

   if (fld.value == "") {
        error = "You didn't enter a year.\n";
        fld.style.background = 'Yellow';
    } else if (isNaN(parseInt(stripped))) {
        error = "The year contains illegal characters.\n";
        fld.style.background = 'Yellow';
    } else if (!(stripped.length == 4)) {
        error = "The year is the wrong length.\n";
        fld.style.background = 'Yellow';
    }
    else if (fld.value > 2000) {
        fld.style.background = 'Yellow'; 
        error = "You are too young to register. \n";
    }
    else {
        fld.style.background = 'White';
    }
    return error;
}

function validateUsername(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter a username.\n";
    } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow'; 
        error = "The username is the wrong length. Must be at least 5 characters and no greater than 15. \n";
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow'; 
        error = "The username contains illegal characters.\n";
    } else {
        fld.style.background = 'White';
    }
    return error;
}