var code ; //在全局定义验证码 
var codeObj;
//产生验证码
window.onload = createCode;
function createCode(){
	code = new Array();
	var codeLength = 4;//验证码的长度
	var checkCode = document.getElementById("checkCode");
	var selectChar = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        var bg = new Array(0,1,2,3,4,5,6,7,8,9);
       	for(var i=0;i<codeLength;i++) {
		var charIndex = Math.floor(Math.random()*62);
        	code +=selectChar[charIndex];
		codeObj = code;
 	}
	if(code.length != codeLength){
		createCode();
   	}
	code = _setStyle(code);
	checkCode.innerHTML = code;
	var src = "url(image/codeImg/"+bg[Math.floor(Math.random()*10)]+".jpg)";
        checkCode.style.backgroundImage=src;
}


//判断输入密码的类型  
function CharMode(iN){  
	if (iN>=48 && iN <=57) //数字  
		return 1;  
	if (iN>=65 && iN <=90) //大写  
		return 2;  
	if (iN>=97 && iN <=122) //小写  
		return 4;  
	else  
		return 8;   
}  
//bitTotal函数  
//计算密码模式  
function bitTotal(num){  
	modes=0;  
	for (i=0;i<6;i++){  
		if (num & 1) modes++;  
		num>>>=1;  
	}  
	return modes;  
}  
//返回强度级别  
function checkStrong(sPW){  
	if (sPW.length<=6)  
		return 0; //密码太短  
		Modes=0;  
		for (i=0;i<sPW.length;i++){  
		//密码模式  
			Modes|=CharMode(sPW.charCodeAt(i));  
		}  
	return bitTotal(Modes);  
}  
  
//显示颜色  
function pwStrength(pwd){  
	O_color="#eeeeee";  
	L_color="#FF0000";  
	M_color="#FF9900";  
	H_color="#33CC00";  
	if (pwd==null||pwd==''){  
		Lcolor=Mcolor=Hcolor=O_color;  
	}  
else{  
	S_level=checkStrong(pwd);  
	switch(S_level) {  
		case 0:  
			Lcolor=Mcolor=Hcolor=O_color;  
		case 1:  
			Lcolor=L_color;  
			Mcolor=Hcolor=O_color;  
			break;  
		case 2:  
			Lcolor=Mcolor=M_color;  
			Hcolor=O_color;  
			break;  
	default:  
			Lcolor=Mcolor=Hcolor=H_color;  
	}  
}  
document.getElementById("strength_L").style.background=Lcolor;  
document.getElementById("strength_M").style.background=Mcolor;  
document.getElementById("strength_H").style.background=Hcolor;  
return;  
}  

var validate={
	firstname:false,
	email:false,
	password:false,
	pwded:false,
	code:false
}
var bj_validate={
		bl_email:false,
		bl_pass:false
};
var msg='';
$(function(){
	var form=$('#bj_reg_from');
	
	
	form.submit(function(){
		var isOk=validate.firstname && validate.email && validate.password && validate.pwded && validate.code;
		if(isOk){
		
			return true;
		}
		$('input[name=email]',form).trigger('blur');
		$('input[name=firstname]',form).trigger('blur');
		$('input[name=password]',form).trigger('keyup');
		$('input[name=confirm]',form).trigger('keyup');
		$('#input',form).trigger('blur');
			return false;
	});
	
	$('#login_btn').click(function(){
			var isOk= bj_validate.bl_email && bj_validate.bl_pass ;
			if(isOk){
				runUrl=window.location.href;
				var data={email:$('input[name=login_email]').val(),password:$('input[name=login_password]').val(),isAjax:1,redirect:runUrl}
				var error_msg=$('.error_msg');
				$.ajax({
							type: "POST",
							url:'/index.php?route=account/login',
							data: data,
							success: function(msg){  
								if(msg) {
									error_msg.show();
									error_msg.html(msg).addClass('redcolor');
								}else{
									error_msg.hide();
									window.location.href=runUrl;
								}
							}
				});
			}else{
					$('input[name=login_email]').trigger('blur');
					$('input[name=login_password]').trigger('blur');
					return false;
			}	
	})
	
	$('input[name=login_email]').blur(function(){
		var email=$.trim($(this).val());
		var span=$(this).next();
		if(email==''){
			msg='邮箱/用户名不能为空';
			span.html(msg).addClass('redcolor');
			bj_validate.bl_email=false;
			return;
		}else{
		
			if(email.indexOf("@") > 0 ){

				 var pe=/^[^\@]+@.*\.[a-z]{2,6}$/;
				if(!email || !pe.test(email) ) {
					msg='请输入符合规范的邮箱地址';
					span.removeClass('greencolor');span.html(msg).addClass('redcolor');
					bj_validate.bl_email=false;
					return false;
				} else {
					span.removeClass('redcolor');span.html('').addClass('greencolor');
					bj_validate.bl_email=true;
				}
			
			}else{
					span.removeClass('redcolor');span.html('').addClass('greencolor');
					bj_validate.bl_email=true;
			}
			
		}
	})	
	
	
	
	$('input[name=login_password]').blur(function(){
		var password=$.trim($(this).val());
		var span=$(this).next();
		if(password.length <6){
				msg='请输入6位以上密码';
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				bj_validate.bl_pass=false;
				return;
			}else{
				span.html('').removeClass('redcolor');
				bj_validate.bl_pass=true;
			}
	})
	
	
	
	
	
	$('input[name=email]',form).blur(function(){
		var email=$.trim($(this).val());
		var span=$('#errorMessage_email');
		if(email==''){
			msg='邮箱不能为空';
			span.html(msg).addClass('redcolor');
			validate.email=false;
			return;
		}else{
			 var pe=/^[^\@]+@.*\.[a-z]{2,6}$/;
			if(!email || !pe.test(email) ) {
				msg='请输入符合规范的邮箱地址';
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				validate.email=false;
				return false;
			} else {
				$.ajax({
					type: "POST",
					url: "index.php?route=account/register/checkemail",
					data: "email=" + email ,
					success: function(flag) {  
						if(flag) {
							msg="该邮箱已经存在";
							span.removeClass('greencolor');span.html(msg).addClass('redcolor');
							validate.email=false;
							return false;
						}else{
							msg="邮箱可以使用";
							span.html(msg).removeClass('redcolor').addClass('greencolor');
							validate.email=true;
						}
					}
				});
			   
			}
		}
	})	
	
	$('input[name=firstname]',form).blur(function(){
		var firstname=$.trim($(this).val());
		var span=$('#errorMessage_name');
		if(firstname==''){
			msg='昵称不能为空';
			span.removeClass('greencolor');
			span.html(msg).addClass('redcolor');
			validate.firstname=false;
			return;
		}else{
			
			 var fe=/^[0-9a-zA-Z\u4e00-\u9fa5]*$/;
			if(!firstname || !fe.test(firstname) ) {
				msg="请输入符合规范的昵称!";
				span.removeClass('greencolor');
				span.html(msg).addClass('redcolor');
				validate.firstname=false;
				return false;
			} else {
				$.ajax({
					type: "POST",
					url: "index.php?route=account/register/checkfirstname",
					data: "firstname=" + firstname ,
					success: function(flag) {  
						if(flag) {
							msg="该用户昵称已经存在";
							span.removeClass('greencolor');
							span.html(msg).addClass('redcolor');
							
							validate.firstname=false;
							return false;
						}else{
							msg="用户昵称可以使用";
							span.html(msg).removeClass('redcolor').addClass('greencolor');
							validate.firstname=true;
						}
					}
				});
			   
			}
			
		}
	})
	$('input[name=password]',form).blur(function(){
		var password=$.trim($(this).val());
		var span=$('#errorMessage_pwd');
		if(password.length <6){
				msg='请输入6位以上密码';
				
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				validate.password=false;
				return;
			}else{
				span.removeClass('redcolor');
				validate.password=true;
			}
	})
	
	$('input[name=confirm]',form).blur(function(){
		var confirm=$.trim($(this).val());
		var span=$('#errorMessage_pwded');
		if(confirm.length<6){
				msg='请输入6位以上确认密码';
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				validate.pwded=false;
				return;
			}
	})
	
	$('input[name=password]',form).keyup(function(){
		var password=$.trim($(this).val());
		var span=$('#errorMessage_pwd');
		if(password.length <6){
				msg='请输入6位以上密码';
				
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				validate.password=false;
				return;
			}else{
			
				//pwStrength(password);
				//$('.qd_pwd').show();
				span.html('').removeClass('redcolor');
				validate.password=true;
		}
	});
	
	$('input[name=confirm]',form).keyup(function(){
		var confirm=$.trim($(this).val());
		var span=$('#errorMessage_pwded');
		var password=$('input[name=password]',form).val();
		if(confirm.length<6){
				msg='请输入6位以上确认密码';
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				validate.pwded=false;
				return;
			}else{
				if(confirm != password){
					msg='两次密码不一致';
					span.removeClass('greencolor');span.html(msg).addClass('redcolor');
					validate.pwded=false;
					return false;
				}else{
					//$('.qd_confirm').show();
				//	pwStrength(confirm);
					span.removeClass('redcolor');span.html('').addClass('greencolor');
					validate.pwded=true;
			}
		}
	});
	
	$('#input',form).blur(function(){
		var inputCode=$.trim($(this).val()).toUpperCase();//取得输入的验证码并转化为大写 
		var span=$('#errorMessage_code');
		indexCode = codeObj.toUpperCase();//默认选出的验证码

		if(inputCode.length <4){
				msg='请输入4位验证码';
				
				span.removeClass('greencolor');span.html(msg).addClass('redcolor');
				validate.code=false;
				return;
			}else{
			  if(inputCode != indexCode ) { //若输入的验证码与产生的验证码不一致时
					msg="验证码输入错误";
					
					span.removeClass('greencolor');span.html(msg).addClass('redcolor');//验证码输入错误
					createCode();//刷新验证码
					document.getElementById("input").focus();				        		   	  
					return false;
				}else { //输入正确时	   			   			
				    	span.html('').removeClass('redcolor');
					   validate.code=true;
					}  
		}
	});
	
})


//登陆验证码
function validate_login(){
	var inputCode = document.getElementById("input").value.toUpperCase(); //取得输入的验证码并转化为大写   
	code = codeObj.toUpperCase();
	if(inputCode.length <= 0) { //若输入的验证码长度为0
		alert("请输入验证码！"); //则弹出请输入验证码
		document.getElementById("input").focus();
		return false;
       	}else if(inputCode != code ) { //若输入的验证码与产生的验证码不一致时
		alert("验证码输入错误！@_@"); //则弹出验证码输入错误
		createCode();//刷新验证码
		document.getElementById("input").value = "";//清空文本框
		document.getElementById("input").focus();				        		   	  
                return false;
   	}else { //输入正确时	   			   			
                return true;
       	}           
}
function _setStyle(codeObj){
	var fnCodeObj = new Array();
	var col = new Array('#BF0C43', '#E69A2A','#707F02','#18975F','#BC3087','#73C841','#780320','#90719B','#1F72D8','#D6A03C','#6B486E','#243F5F','#16BDB5');
	var charIndex;
	for(var i=0;i<codeObj.length;i++){		
		charIndex = Math.floor(Math.random()*col.length);
		fnCodeObj.push('<font color="' + col[charIndex] + '">' + codeObj.charAt(i) + '</font>');
	}
	return fnCodeObj.join('');		
}

