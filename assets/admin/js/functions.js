function show_global_loader(){
	jQuery('#div_global_loader').css("top", ((jQuery(window).height() - jQuery('#div_global_loader').outerHeight()) / 2) + jQuery(window).scrollTop() + "px");
    jQuery('#div_global_loader').css("left", ((jQuery(window).width() - jQuery('#div_global_loader').outerWidth()) / 2) + jQuery(window).scrollLeft() + "px");
	jQuery('#div_global_loader').show();
}
function hide_global_loader(){
	jQuery('#div_global_loader').hide();
}
function validNumber(field)
{
	var v = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var w = ""; 
	$str=field.value.toUpperCase();
	for (i=0; i < field.value.length; i++) {
	x = $str.charAt(i);
	 if ((v.indexOf(x,0) != -1))
	 w += x; 
	
	}
		if(field.value != w)
		field.value = w;
}

function IsNumeric(sText)
{
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
}

/*************************** VALIDATION RULE *****************/
var regObjName = new RegExp();
var nameRegExp = '^([ \t\n\r]?)([a-zA-Z]{1})[a-zA-Z0-9._%-]{1,59}([ \t\n\r]?)$';
regObjName.compile(nameRegExp);

var regObjPass = new RegExp();
//var passRegExp = '(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{6,12})$';
var passRegExp = '^[ \t\r\n]?[0-9]{1,10}[ \t\r\n]?$';
	regObjPass.compile(passRegExp);

var regObjText = new RegExp();
var TextRegExp = '^([ \t\n\r]?)([a-zA-Z0-9._ -]{2,59})([ \t\n\r]?)$';
regObjText.compile(TextRegExp);



var regObjEmail = new RegExp();
var emailRegExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
regObjEmail.compile(emailRegExp);

var regObjPostCode = new RegExp();
var postExp = '^[ \t\r\n]?[A-Z0-9]{2,4}[ \t\r\n]?$';
regObjPostCode.compile(postExp);

var regObjNumber = new RegExp();
var numExp = '^[ \t\r\n]?[0-9]{1,10}[ \t\r\n]?$';
regObjNumber.compile(numExp);

var regObjFloatNumber = new RegExp(); 
var numFExp = /^(((\+|-)?\d+(\.\d*)?)|((\+|-)?(\d*\.)?\d+))$/;
regObjFloatNumber.compile(numFExp);

/*var regObjPhone = new RegExp();
var PhoneRegExp = '^[ \t\r\n]?[0-9]{7,16}[ \t\r\n]?$';
regObjPhone.compile(PhoneRegExp);
*/
var regObjAdress = new RegExp();
var addressRegExp = '^[ \t\r\n]?[ \t\r\n0-9a-zA-Z._%,-/]+[ \t\r\n]?$'; 
regObjAdress.compile(addressRegExp);

function textValidation(text)
	{
	var text = text.replace(/^\s+|\s+$/g,"");
	if(regObjText.test(text) )
		{
		return true;	
		}
	else{
		return false;	
		}
	}

function addressValidation(text)
	{
	var text = text.replace(/^\s+|\s+$/g,"");
	if(regObjAdress.test(text) )
		{
		return true;	
		}
	else{
		return false;	
		}
	}

function isUrl(s) {
	var regObjURL = new RegExp();
	var URLRegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/	
	regObjURL.compile(URLRegExp); alert('s->'+s);
	return regObjURL.test(s);
}

function popUpLocation(URL, width, height){
	var day = new Date();
    var id = day.getTime();
eval("page" + id + " = window.open('"+URL+"', '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width="+width+",height="+height+",left = 390,top = 160');");
}


