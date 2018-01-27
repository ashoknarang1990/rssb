$(document).ready(function(e) { //alert(_default_enq_path);
    checkvalid();
	var enq_opt = { 
		url:($('#login_form').attr('action')),
		type:"post",
		dataType:  'json',
		beforeSubmit: validateLogin,
		success: responseLogin
		 }; 
	$("#login_form").ajaxForm(enq_opt);
	
	var enq_opt = { 
		url:($('#signup_form').attr('action')),
		type:"post",
		dataType:  'json',
		beforeSubmit: validateSignup,
		success: responseSignup
		 }; 
	$("#signup_form").ajaxForm(enq_opt);
});
function validateLogin(formData, jqForm, options) { 
	var ov=$("input[type=submit]",jqForm).val();
	$("input[type=submit]",jqForm).attr("disabled",true).attr("ov",ov).val("Please Wait...");
}

function responseLogin(data, statusText, xhr, form) { //alert(data);
	var ov=$("input[type=submit]",form).attr("ov");
	$("input[type=submit]",form).attr("disabled",false).val(ov);
	var stat=data.stat;
	var mess=data.message;
	var path=data.path;
	if(stat=='1' || stat==1) {
		$("._form_err_msg_div",form).html(mess); 
		window.location.href = path;
	}
	else {
		$("._form_err_msg_div",form).html(mess); 
	}
}

function validateSignup(formData, jqForm, options) { 
	var ov=$("input[type=submit]",jqForm).val();
	$("input[type=submit]",jqForm).attr("disabled",true).attr("ov",ov).val("Please Wait...");
}

function responseSignup(data, statusText, xhr, form) { //alert(data);
	var ov=$("input[type=submit]",form).attr("ov");
	$("input[type=submit]",form).attr("disabled",false).val(ov);
	var stat=data.stat;
	var mess=data.message;
	var path=data.path;
	if(stat=='1' || stat==1) {
		$(form).html('<h3 style="line-height: 150%;">'+mess+'</h3>');
	}
	else {
		$("._form_err_msg_div",form).html(mess); 
	}
}

function checkvalid(frm_obj) {
	var spid = $('#sponser_id').val();
	//var plid = $('#placement_id').val();
	//var pos = $('#position').val();
	var jqForm = $('#signup_form');
	
	var jqForm = (frm_obj == 'undefind' || frm_obj=='') ? $('#signup_form') : $('#'+frm_obj);
	
	//if(spid > 0 && plid > 0 && pos!='') {
	if(spid > 0) {
		if(frm_obj == 'edit-profile') {
			$("button[type=submit]",jqForm).attr("disabled",false);
		}
		else {
			$("input[type=submit]",jqForm).attr("disabled",false);
		}
		
	}
	else {
		if(frm_obj == 'edit-profile') {
			$("button[type=submit]",jqForm).attr("disabled",true);
		}
		else {
			$("input[type=submit]",jqForm).attr("disabled",true);
		}
		
	}
}

function check_sponser(obj,frm_obj) {
	var spid = $('#sponser_id').val();
	
	var obj_val = $(obj).val();
	var jqForm = (frm_obj == 'undefind' || frm_obj=='') ? $('#signup_form') : $('#'+frm_obj);
	
	var spid_text = $('#sponser_id_text').val();
	
	
	if(spid > 0 && spid_text == obj_val) {
		// DO NOTHING
	}
	else if(obj_val != '') {
		$('#sponser_id_text').val(obj_val);
		var enq_opt = { 
			url:($('#ajaxurl').val()+'/checksponserid'),
			type:"post",
			data:"sponser_id="+obj_val,
			dataType:  'json',
			success: function(data){
				var stat=data.stat;
				var mess=data.message;
				if(stat=='1' || stat==1) {
					var nspid = data.sponser_id;
					$('#sponser_id').val(nspid);
					if(frm_obj == 'edit-profile') {
						$('.sponnamebox').html(mess).show();
					}
					else {
						$('.sponnamebox').html('<b style="color:#02b706">'+mess+'</b>').show();;
					}
					checkvalid(frm_obj);
				}
				else {
					$('#sponser_id').val('');
					$('.sponnamebox').html('<b style="color:#ff0000">'+mess+'</b>').show();;
					checkvalid(frm_obj);
				}
				
			}
		}; 
		$.ajax(enq_opt);
	}
}


function check_placement(obj) {
	var spid = $('#placement_id').val();
	var spid_text = $('#placement_id_text').val();
	var obj_val = $(obj).val();
	var jqForm = $('#signup_form');
	if(spid > 0 && spid_text == obj_val) {
		// DO NOTHING
	}
	else if(obj_val != '') {
		$('#placement_id_text').val(obj_val);
		var enq_opt = { 
			url:($('#ajaxurl').val()+'/checkplacementid'),
			type:"post",
			data:"placement_id="+obj_val,
			dataType:  'json',
			success: function(data){
				var stat=data.stat;
				var mess=data.message;
				if(stat=='1' || stat==1) {
					var nspid = data.placement_id;
					var posid = data.position;
					$('#placement_id').val(nspid);
					$('#position').val(posid);
					$('.placenamebox').html('<b style="color:#02b706">'+mess+'</b>');
					checkvalid();
				}
				else {
					$('#placement_id').val('');
					$('#position').val('');
					$('.placenamebox').html('<b style="color:#ff0000">'+mess+'</b>');
					checkvalid();
				}
				
			}
		}; 
		$.ajax(enq_opt);
	}
}