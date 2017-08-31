
//simple way of doing getElement
function get(element){
	return document.getElementById(element);
}

$( document ).ready(function() {
		
	var trustFormRcvd = $("#trustFormRcvd").val();	
	if(trustFormRcvd=='N')
		$('.trust-input').find('input').prop('checked', false);
	else if(trustFormRcvd=='Y')
		$('.trust-input').find('input').prop('checked', true);
		
	var lifeOne = $("#lifedecisionOne").val();	
	if(lifeOne=='N')
	$('#rejectOne').prop('checked', true);
	else if(lifeOne=='Y')
	$('#acceptOne').prop('checked', true);
		
	var lifeTwo = $("#lifedecisionTwo").val();	
	if(lifeTwo=='N')
		$('#rejectTwo').prop('checked', true);
	else if(lifeTwo=='Y')
		$('#acceptTwo').prop('checked', true);
	
	$('.trust-input').click(function(){		
		if($('.trust-input').find('input').is(':checked')){
			$('.trust-input').find('input').prop('checked', false);
		}else{
			$('.trust-input').find('input').prop('checked', true);
		}		
		$('.trust-input').find('input').click(function(){		
			if($('.trust-input').find('input').is(':checked')){
				$('.trust-input').find('input').prop('checked', false);
			}else{
				$('.trust-input').find('input').prop('checked', true);
			}
		});		
	});
		
	$("span[role='radio']").bind("click", function(event){
		var self = this, inputList = $("div[role='radiogroup']").find("input"),
			spanList = $("div[role='radiogroup']").find("span[role='radio']");
		setTimeout(function(){
				if($($(self).find('input')).is(':checked')){
					$($(self).find('input')).attr("aria-selected", true);
					$($(self).find('input')).attr("checked", true);
				} else {
					$($(self).find('input')).attr("aria-selected", false);
					$($(self).find('input')).attr("checked", false);
				}
				
				for(var index = 0; index < inputList.length; index++){
					if($(inputList[index]).attr("checked") === "checked"){
						$(inputList[index]).attr("aria-selected", true);
						$(spanList[index]).attr("aria-selected", true);
					}else {
						$(inputList[index]).attr("aria-selected", false);
						$(spanList[index]).attr("aria-selected", false);
					}
				}
			}, 5);
	 });

	$("#tab-nav").bind("click", function(event){
		if($("#sidebar").hasClass('hidden-sm')){
			$("#sidebar").removeClass('hidden-sm hidden-xs');
		}
		else{
			$("#sidebar").addClass('hidden-sm hidden-xs');
		}
		
		
	});	
	
	$(".showModal").click(function(){
        $("#indexationModal").modal('show');
    });	  
		
	if ($('p').hasClass("pcsUserIncrForm")) {
		$('html, body').animate({
        scrollTop: $('#submitError').offset().top}, 'slow');
	}
	
	var groupButtons = $('.btn-group[data-toggle=buttons] .btn');
    groupButtons.keydown(function(e) {
      if (e.which == 13 || e.which == 32) {
        $(this).click();
        return false;
      }
      if(e.which == 37 || e.which == 38) {
    	  $(this).prev().attr('tabindex', 0);
    	  $(this).prev().focus();
    	  $(this).prev().click();
    	  if(!$(this).hasClass('active')) {
      		// Do not focus 
      		$(this).attr('tabindex', -1);
    	  }
    	  return false;
      }
      if(e.which == 39 || e.which == 40) {
    	  $(this).next().attr('tabindex', 0);
    	  $(this).next().focus();
    	  $(this).next().click();
    	  if(!$(this).hasClass('active')) {
        		// Do not focus 
        		$(this).attr('tabindex', -1);
    	  }
    	  return false;
      }
    });
    
    // workaround for bootstrap button issue - disable click event for disabled radio button clicks
    $('.btn-group[data-toggle=buttons] .btn.disabled, .btn-group[data-toggle=buttons] .btn[disabled=disabled]').click(function(event) {
    	event.stopPropagation();
    	return false;
    });
    
    
    $('input[type=text], input[type=tel], input[type=email], input[type=password]').keyup(function(){
    	if(document.getElementById(this.id + "_div_err") != null){
        	document.getElementById(this.id + "_div_err").style.display = 'none';
        	$(this).removeClass('alert');
        	$(this).removeClass('alert-danger');
        	$(this).removeAttr('aria-invalid');
    	}
    });

    $('select, input[type=radio]').change(function(){
    	
    	if(document.getElementById(this.id).disabled){
   		 var $label = $("label[for='"+this.id+"']")
   		 $label.addClass("noCursor");
   		return;
    	}
    	
    	/* added as part of DDA decect 10014 */
    	var radioElements = $("input[name='"+this.name+"']");
    	for(var index = 0; index < radioElements.length; index++){
    		 if($(radioElements[index]).parents("span:first").hasClass("active")){
    			 $(radioElements[index]).parents("span:first").attr("tabindex", "0");
    		 } else {
    			 $(radioElements[index]).parents("span:first").attr("tabindex", "-1");
    		 }
    	};
    	
    	var allElements = $("div[class='"+this.name+"_radiolabel']");
    	for (var i=0; i < allElements.length; i++) {
    		var divField = allElements[i].id;
    		if(divField.lastIndexOf("_selected") > -1){
    			document.getElementById(divField).style.display = 'none';
    			//document.getElementById(divField).setAttribute("aria-selected","false");	
    		}
    		if(divField.lastIndexOf("_unselected") > -1){
    			document.getElementById(divField).style.display = 'block';
    		}
    	}
    	
    	$("input[name='"+this.name+"']").attr("checked",false);
    	var jQueryableFieldName = (this.id).replace(/[^a-zA-Z0-9_\s]/g, "");
    	if(document.getElementById(jQueryableFieldName + "_selected")!=null) {
    		document.getElementById(jQueryableFieldName + "_selected").style.display = 'block';
    		//$("#" + jQueryableFieldName + "_selected").attr("aria-selected","true");
    	} else if(document.getElementById(this.id + "_selected")!=null) {
    		document.getElementById(this.id + "_selected").style.display = 'block';
    		//document.getElementById(this.id + "_selected").setAttribute("aria-selected","true");
    	}
    	
    	if(document.getElementById(jQueryableFieldName + "_unselected")!=null) {
    		document.getElementById(jQueryableFieldName + "_unselected").style.display = 'none';
    		//$("#" + jQueryableFieldName + "_unselected").attr("aria-selected","false");
    	} else if(document.getElementById(this.id + "_unselected")!=null) {
        	document.getElementById(this.id + "_unselected").style.display = 'none';
        	//document.getElementById(this.id + "_unselected").setAttribute("aria-selected","false");
        }
    	document.getElementById(this.id).checked = true;
    	
    	if(document.getElementById(this.name + "_div_err") != null){
    		document.getElementById(this.name + "_div_err").style.display = 'none';	
        	$(this).removeClass('alert');
        	$(this).removeClass('alert-danger'); 
        	$(this).removeAttr('aria-invalid');
    	}
    }); 
    
    // Ensure focus is on the active radio button option on tab key press
    $.each($('.btn-group[data-toggle=buttons][role=radiogroup]'), function(groupIndex, groupObj){
    	var preselected = $(this).children('span.active');
    	if(preselected.length > 0) {
    		// Apply tabIndex if a preselected option exists
    		$.each($(groupObj).children(), function(btnIndex, btnObj){
    			if(!$(btnObj).hasClass('active')) {
    	    		// Do not focus 
    	    		$(btnObj).attr('tabindex', -1);
    	    	}
        	});
    	}
    });
    
    $('input[type=checkbox]').change(function(){
    	
    	if(document.getElementById(this.id).disabled){
      		return;
       	}
    	var jQueryableFieldName = (this.id).replace(/[^a-zA-Z0-9_]/g, "");
    	var labelClassName = null;
    	
    	if(document.getElementById(jQueryableFieldName + "_chkboxlabel") != null){
    		labelClassName = document.getElementById(jQueryableFieldName + "_chkboxlabel").className;
    	}
    	
    	if(labelClassName !=null && 
    			labelClassName.lastIndexOf("active") > -1){
        	document.getElementById(jQueryableFieldName + "_checked").style.display = 'block';
        	document.getElementById(jQueryableFieldName + "_unchecked").style.display = 'none';
        	$( "#"+(this.id) ).prop( "checked", true );
        	//$( "#"+(this.id) ).prop( "value", true );
    	}else{
    		if(document.getElementById(jQueryableFieldName + "_checked") != null){
    		document.getElementById(jQueryableFieldName + "_checked").style.display = 'none';
        	document.getElementById(jQueryableFieldName + "_unchecked").style.display = 'block';
        	$( "#"+(this.id) ).prop( "checked", false );
        	}
        	//$( "#"+(this.id) ).prop( "value", false );
    	}
    	
    });
   
	$("section").css("margin-top", 20);
	
	$(".contact-us").click(function(){
		$(".contact-us").toggleClass("selected");
		$(".openContactUs").toggle();
		$(".closeContactUs").toggle();
		$(".contact-wrp").toggle();
		$(".toggle-arrow").attr('aria-expanded', function (i, attr) {
		    return attr == 'true' ? 'false' : 'true'
		});
	});	
	
	/* handling mouseover/mouseout/onfocus for menu bar */
	$(".dropdown-container").mouseover(function(){
		$(".menu-title").css({"background-color" : "#666666", "color" : "#fff"});
		$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-touch.png");
		$('.dropdown').addClass('open');
	});

	$(".dropdown-container").mouseout(function(){
		$(".menu-title").css({"background-color" : "#DDDDDD", "color" : "#4C4C4C"});
		$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-default.png");
		$('.dropdown').removeClass('open');
	});
	
	
	
	
	$(".menu-label, .menu-focus").keydown(function(e){
		if(e.shiftKey && e.which === 9){
			$(".menu-title").css({"background-color" : "#DDDDDD", "color" : "#4C4C4C"});
			$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-default.png");
			$('.dropdown').removeClass('open');
			return;
		};
		if(e.shiftKey || e.which === 9){
			return;
		};
		if(e.which == 38 || e.which == 40){
			$(".menu-title").css({"background-color" : "#666666", "color" : "#fff"});
			$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-touch.png");
			$('.dropdown').addClass('open');
		};
		
		if(e.which == 13 && $('.dropdown').hasClass('open')){
			$(".menu-title").css({"background-color" : "#DDDDDD", "color" : "#4C4C4C"});
			$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-default.png");
			$('.dropdown').removeClass('open');
		} else {
			$(".menu-title").css({"background-color" : "#666666", "color" : "#fff"});
			$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-touch.png");
			$('.dropdown').addClass('open');
		}
	});

	$(".dropdown-container .dropdown-menu li:last-child").bind("focusout keydown", function(e){
		if(e.which === 9 && !e.shiftKey){
			$(".menu-title").css({"background-color" : "#DDDDDD", "color" : "#4C4C4C"});
			$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-default.png");
			$('.dropdown').removeClass('open');
		}
	});
	
	$(".arrow-image-container").click(function(event){
		if(event.target.className === "mobile-nav"){
			if($('.dropdown').hasClass('open')){
				$(".arrow-image-container img").attr("src" , "/PAR/images/nav-mobile-default.png");
			}else{
				$(".arrow-image-container img").attr("src" , "/PAR/images/nav-mobile-touch.png");
			}
		};
		if(event.target.className === "desktop-nav"){
			if($('.dropdown').hasClass('open')){
				$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-default.png");
				$('.dropdown').removeClass('open');
			}else{
				$(".arrow-image-container img").attr("src" , "/PAR/images/nav-desktop-v-touch.png");
				$('.dropdown').addClass('open');
			}
		};
		
		
	});
	
	if (!("ontouchstart" in document.documentElement)) {
		$('[id$=_elementDiv]').each(function(index) {
			var currElementDivID = $(this).attr("id");
			if(currElementDivID != null){
				var currElementDivHelpID = currElementDivID.replace("_elementDiv","_bigScreenHelp");
				if(currElementDivHelpID != null){
					$(this).hover(function(e) {				
						$('[id$=_elementDiv]').each(function(index) {
							var eachElementDivID = $(this).attr("id");
							//$(this).removeClass('elementDivHover');					
							var eachElementDivHelpID = eachElementDivID.replace("_elementDiv","_bigScreenHelp");					
							$("[id$=" + eachElementDivHelpID + "]").hide();								
						});
						//$("[id$=" + currElementDivID + "]").addClass('elementDivHover');				
						$("[id$=" + currElementDivHelpID + "]").show();				
					});						
				}			
			}			
		});
		$('[id$=_noHelpExists_div]').each(function(index) {
			$(this).hover(function(e) {			
				$('[id$=_elementDiv]').each(function(index) {
					var eachElementDivID = $(this).attr("id");

					//$(this).removeClass('elementDivHover');					
					var eachElementDivHelpID = eachElementDivID.replace("_elementDiv","_bigScreenHelp");				
					$("[id$=" + eachElementDivHelpID + "]").hide();
				});
			});
		});
	} else {
		$('[id$=_elementDiv]').each(function(index) {
			var currElementDivID = $(this).attr("id");
			if(currElementDivID != null){
				var currElementDivHelpID = currElementDivID.replace("_elementDiv","_bigScreenHelp");
				if(currElementDivHelpID != null){
					$(this).click(function(e) {				
						$('[id$=_elementDiv]').each(function(index) {
							var eachElementDivID = $(this).attr("id");
							//$(this).removeClass('elementDivHover');					
							var eachElementDivHelpID = eachElementDivID.replace("_elementDiv","_bigScreenHelp");					
							$("[id$=" + eachElementDivHelpID + "]").hide();								
						});
						//$("[id$=" + currElementDivID + "]").addClass('elementDivHover');				
						$("[id$=" + currElementDivHelpID + "]").show();				
					});						
				}			
			}			
		});
		$('[id$=_noHelpExists_div]').each(function(index) {
			$(this).click(function(e) {			
				$('[id$=_elementDiv]').each(function(index) {
					var eachElementDivID = $(this).attr("id");
					//$(this).removeClass('elementDivHover');					
					var eachElementDivHelpID = eachElementDivID.replace("_elementDiv","_bigScreenHelp");				
					$("[id$=" + eachElementDivHelpID + "]").hide();
				});
			});
		});
	}
	
	//date picker implementation
	// Attach event to all input fields requiring datepicker
	$(".date-picker").each(function(){
		$(this).datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true
		});
	});
	
	// Focus on corresponding input field on image click
	$(".date-picker-icon").each(function(){
		$(this).click(function(){
			$(this).prev().focus();
		});
	});
	
	// Hack for HTML input number fields maxlength issue
	$("input[type=number]").on("focus", function (e) {
		this.textfocus = true;
	});
	$("input[type=number]").on("keydown", function (e) {
		// Tab and Backspace
		if(e.which == 8 || e.which == 9) {
  		  	return;
  	  	}
		// First time visit to the field
		if(this.textfocus) {
			this.textfocus = false;
			return;
		}
		// Restrict entry
		if (this.value.length >= Number($(this).attr("maxlength"))) {
			return false;
		}
	});
	
	$('.trust-mouse').on('click',function(){ 
	if($('#trustForm').prop('checked')){
		$('.trust-mouse').css({'background-color':'#006c90!important', 'color':'white'});
	}else{
		$('.trust-mouse').css({'background-color':'#ccebf5!important', 'color':''});
	}
	
  });
});

//only allow numbers
function isNumberKey(evt) {
 var charCode = (evt.which) ? evt.which : evt.keyCode;
 if (charCode != 46 && charCode > 31 
   && (charCode < 48 || charCode > 57))
    return false;

 return true;
}

function DateFormat(vDateName, vDateValue, e, dateCheck, dateType) {
		vDateType = dateType;
		// vDateName = object name
		// vDateValue = value in the field being checked
		// e = event
		// dateCheck 
		// True  = Verify that the vDateValue is a valid date
		// False = Format values being entered into vDateValue only
		// vDateType
		// 3 = dd/mm/yyyy

		// IE8 did not like the below line of code so amended to use getKey method in
		// application.js which works for all other supported browsers.
		//var whichCode = (window.Event) ? e.which : e.keyCode;
		var whichCode = getKey( e );
		
		if(whichCode == 0) {
			// Incase whichcode is still not set and is a gecko browser, use the one supported by all browsers except IE :)
			whichCode = (window.Event) ? e.which : e.keyCode;
		}
		
		// Check to see if a seperator is already present.
		// bypass the date if a seperator is present and the length greater than 8
		if (vDateValue.length > 8) {
		if ((vDateValue.indexOf("-") >= 1) || (vDateValue.indexOf("/") >= 1))
		return true;
		}
			//Create numeric string values for 0123456789/
			//The codes provided include both keyboard and keypad values
			var strCheck = '47,48,49,50,51,52,53,54,55,56,57,58,59,95,96,97,98,99,100,101,102,103,104,105,191';
			
			if (strCheck.indexOf(whichCode) != -1 && whichCode != 8) 
			{
				if (vDateType == 1) 
				{
					if (vDateValue.length == 2) 
					{
						vDateName.value = vDateValue+strSeperator;
					}
					if (vDateValue.length == 5) 
					{
						vDateName.value = vDateValue+strSeperator;
					}
				}
			}
		
}

var browserType;

if (document.layers) {browserType = "nn4"};
if (document.all) {browserType = "ie"};
if (window.navigator.userAgent.toLowerCase().match("gecko")) {browserType= "gecko"};
var strSeperator = "/"; 

function getKey( event ) {
    if( !event ) {
        event = window.event;
    }

    var key;
    if( browserType == "gecko" ) {
        key = event.charCode;
    }
    else if( event.keyCode ) {
        key = event.keyCode;
    }
    else if( event.which ) {
        key = event.which;
    }

    return key;
}

//highlight the element green
function highlightElement(field){
	//remove all element highlights
	var allElements = $(".elementDiv");
	for (var i=0; i < allElements.length; i++) {
		var divField = allElements[i].id;
		divField = divField.replace("_elementDiv", "");
		if(document.getElementById(divField + "_bigScreenHelp") != null){
			document.getElementById(divField + "_bigScreenHelp").style.display = 'none';
		}		
		var attr = "#" + divField + "_elementDiv";
		//$(attr).removeClass('elementDivHover');		
	}
	if('none' != field){
		//then show this one
		if(document.getElementById(field + "_bigScreenHelp") != null){
			document.getElementById(field + "_bigScreenHelp").style.display = 'block';
		}
		var attr = "#" + field + "_elementDiv"; 
		//$(attr).addClass('elementDivHover');		
	}	
}

//submit to specific screen
function submit(screen){
	document.forms[0].action=screen;
	document.forms[0].submit()
}

function showHideZipContent(divId){
	if(document.getElementById(divId).style.display == "inline-block" || $("#" + divId).css('display') == 'block') {
		document.getElementById(divId).style.display = "none";
		document.getElementById(divId + "_zipped").style.display = "block";
		document.getElementById(divId + "_zipDown").style.display = "inline-block";
		document.getElementById(divId + "_zipUp").style.display = "none";
		document.getElementById(divId + "_seeMore").style.display = "inline-block";		
		document.getElementById(divId + "_seeLess").style.display = "none";
		$("#" + divId + "_zipDown").parent().parent().attr("aria-expanded","false");
	} else {
		document.getElementById(divId).style.display = "block";
		document.getElementById(divId + "_zipped").style.display = "none";
		document.getElementById(divId + "_zipDown").style.display = "none";
		document.getElementById(divId + "_zipUp").style.display = "inline-block";
		document.getElementById(divId + "_seeMore").style.display = "none";
		document.getElementById(divId + "_seeLess").style.display = "inline-block";		
		$("#" + divId + "_zipUp").parent().parent().attr("aria-expanded","true");
	}
}