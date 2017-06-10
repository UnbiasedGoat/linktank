/*Login Function*/
function login() {
	var un=$("#user_login").val();
	var pw=$("#password_login").val(); 
	if(un=='' && pw==''){ 
		$("#error-m").html("Please enter email and password"); 
	} else { 
			$("#error-m").html("Please wait...");
			$.ajax({
				url: 'ajax.php?typ=logi&uname='+un+'&pass='+pw,
				success: function(data) { 
					var result 		= $.parseJSON( data );
					var pic_folder 	= "images/";
					if(result.error == ''){  
						var res = data.split(":");
						$(".ct-mn").hide(); 
						$(".ct-pr").show(); 
						$("#content2").css('top','90px'); 
						$("#content2").css('left','90px');
						$("#sq-name").html(result.first_name);						
						$("#sq-pic").attr('src',pic_folder +''+result.pic); 
						$("#sq-uname").html(result.user_login); 
						$("#sq-abt").html(result.bio);
						$("#sts").val('1'); 
						$("#cont-dis").html(''); 
						$("#user_login").val(''); 
						$("#password_login").val(''); 
						$("#error-m").html("");
						$("#ad-port").css('top','0px');
						window.location.href= 'index.php';
					} else { 
						$("#error-m").html(result.error);
					}
				}
			});
		}
}
/*Login Function*/



/*Logout Function*/
function logout() {
	$.ajax({
		url: 'ajax.php?typ=logout',
		success: function(data) { 
			var result 		= $.parseJSON( data );
			if(result.error == ''){ 
				$(".ct-mn").show(); $(".ct-pr").hide(); $("#content2").css('top','290px'); $("#content2").css('left','-48px');
				$("#sq-name").html(''); $("#sq-pic").attr('src',''); $("#sq-uname").html(''); $("#sq-abt").html('');
				$("#sts").val('0'); $("#cont-dis").html(''); $("#ad-port").css('top','-170px');
				window.location.href= 'index.php';
			}
		}
	});
}
/*Logout Function*/


/*Post Function*/

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
/*Post Function*/

function loadpost(){
		$('.ajaxDiv').html('');
		var loader = 'images/loader.gif';
		$('.ajaxDiv').html('<img src="'+loader+'">');
		$.ajax({
			url: 'ajax.php?typ=refresh',
			success: function(data) { 
				$('.ajaxDiv').html('');
				var result 		= data;
				$('.ajaxDiv').html(result);

			}
		});
}
loadpost();
setInterval(function(){
    loadpost();
}, 10000);	
	
	
	
	
	





