

function validateForm()
{

var warn="The following area must be filled out: \n";
var rt=true;
var str_user_inputs = "";

// ------------------------------------------------------------
var txt_fn=document.forms["myForm"]["fname"].value;

if (txt_fn==null || txt_fn==""){
    
    warn +="First name \n";
    rt=false;
  
}else{ 
   
    str_user_inputs +="First name: "+txt_fn+"\n";

}


// ------------------------------------------------------------
var txt_ln = document.forms.myForm.lname.value;


if (txt_ln==null || txt_ln==""){
    
   warn +="Last name \n";
   rt=false;
  
}else{ 
    
   str_user_inputs +="Last name: "+txt_ln+"\n";

}
//----------------------------
var txt_jn = document.forms.myForm.details.value;


if (txt_jn==null || txt_jn==""){
    
   warn +="Address \n";
   rt=false;
  
}else{ 
    
   str_user_inputs +="Address: "+txt_jn+"\n";

}
//----------------------------

var txt_mn = document.forms.myForm.det.value;


if (txt_mn==null || txt_mn==""){
    
   warn +="Medication \n";
   rt=false;
   
  
}else{
    
   str_user_inputs +="Medication: "+txt_mn+"\n";

}
//----------------------------

var chkbox_med =document.getElementsByName('med_chk[]');;


for (var i=0;i < chkbox_med.length;i++){
  if (chkbox_med[i].checked){
    
    break;
  
  }
}

if(i>=chkbox_med.length){

   warn += "Medical History \n";
   rt = false;
  
}else{ 
   
   str_user_inputs +="Medical History: ";
   for (var j=0;j < chkbox_med.length;j++){
     
	if (chkbox_med[j].checked){
        	
		str_user_inputs +=chkbox_med[j].value+" ";
    
   	}
   
   }
   str_user_inputs +="\n";
}





var choice = document.forms.myForm.choice;

for (var a=0;a < choice.length;a++){
if (choice[a].checked){
 
 break;

}
}

if(a>=choice.length){

warn += "Gender \n";
rt = false;

}else{ 

str_user_inputs +="Gender: ";
for (var b=0;b < choice.length;b++){
  
	if (choice[b].checked){
     	
		str_user_inputs +=choice[b].value+" ";
 
	}

}
str_user_inputs +="\n";
}




var med = document.forms.myForm.med;


for (var d=0;d < med.length;d++){
if (med[d].checked){
 
 break;

}
}

if(d>=med.length){

warn += "Taking Medication \n";
rt = false;


}else{ 

str_user_inputs +="Taking Medication: ";
for (var f=0;f < med.length;f++){
  
	if (med[f].checked){
     	
		str_user_inputs +=med[f].value+" ";
 
	}

}
str_user_inputs +="\n";
}



var dplst_e = document.forms.myForm.ddlView;

var s_index = dplst_e.selectedIndex;


var strUser = dplst_e.options[s_index].value;


if(strUser==0){ 

  warn+="Nationality \n";
  rt= false;

}else{

    str_user_inputs +="Nationality: "+strUser+"\n";

}

if(rt==false){

	alert(warn);
	return false;

	}
	else{


	alert(str_user_inputs);




	return true;

	}
	}

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
		
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}


