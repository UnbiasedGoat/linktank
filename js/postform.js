
function validateFormOnSubmit(theForm) {
var reason = "";

reason += validateEmpty(theForm.limitedtextarea);
      
  if (reason != "") {
    alert("Some fields need correction:\n" + reason);
    var display = reason;
    document.getElementById("display").innerHTML = display;
    return false;
  }

  return true;
}

function validateEmpty(fld) {
    var error = "";
 
    if (fld.value.length == 0) {
        fld.style.background = 'Yellow'; 
        error = "You didn't enter any text.\n"
    }
    else if (fld.value.length > 500) {
        error = "The text is too long. \n";
        fld.style.background = 'Yellow';
    }
    else {
        fld.style.background = 'White';
    }
    
    return error;  
}

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		/*limitField.value = limitField.value.substring(0, limitNum);*/
		limitField.style.background = 'Yellow';
		document.getElementById('hideaway').style.display='block';
		
	} else {
		limitCount.value = limitNum - limitField.value.length;
		countit(limitField);
		limitField.style.background = 'White';
		document.getElementById('hideaway').style.display='none';
	}
}

function countit(what){

	formcontent=what.form.limitedtextarea.value;
	what.form.displaycount.value=formcontent.length;
	}

