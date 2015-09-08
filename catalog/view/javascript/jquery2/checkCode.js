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


var validate={
	firstname:false,
	email:false,
	password:false,
	pwded:false,
	code:false
}

var validate1={
	oldpwd:false,
	newpwd:false,
	newpwded:false,
	code1:false
}

var msg='';
$(function(){
	var form=$('#reg');
	var regPwdForm=$('#regPwdForm');
	form.submit(function(){
		var isOk=validate.firstname && validate.email && validate.password && validate.pwded && validate.code;
	
		if(isOk){
			return true;
		}
		$('input[name=email]',form).trigger('blur');
		
		$('input[name=password]',form).trigger('blur');
		$('input[name=confirm]',form).trigger('blur');
		$('#input',form).trigger('blur');
			return false;
	});
	
	regPwdForm.submit(function(){
	
		var isOk=validate1.oldpwd && validate1.newpwd && validate1.newpwded && validate1.code1;
		if(isOk){
			return true;
		}
		$('input[name=oldpassword]',regPwdForm).trigger('blur');
		$('input[name=password]',regPwdForm).trigger('blur');
		$('input[name=confirm]',regPwdForm).trigger('blur');
		$('input[name=code1]',regPwdForm).trigger('blur');
		$('#input',regPwdForm).trigger('blur');
			return false;
		
	});
	
	$('input[name=oldpassword]',regPwdForm).blur(function(){
		var oldpwd=$.trim($(this).val());
		var span=$('#errorMessage_oldpwd');
		if(oldpwd.length <6){
				msg='请输入6位以上密码';
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate1.oldpwd=false;
				return;
			}else{
			
			$.ajax({
				url: "index.php?route=account/register/checkpwd",
				data:'oldpwd='+oldpwd,
				type:'post',
				success:function(data){
					if(data==1){
						span.html('').removeClass('redcolor').addClass('gree');
						validate1.oldpwd=true;
					}else{
							msg='原密码不相符';
							span.removeClass('gree');span.html(msg).addClass('redcolor');
							validate1.oldpwd=false;
							return;
					}
				}
			})
		}
	});
	
		$('input[name=password]',regPwdForm).blur(function(){
		var password=$.trim($(this).val());
		var span=$('#errorMessage_newpwd');
		if(password.length <6){
				msg='请输入6位以上密码';
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate1.newpwd=false;
				return;
			}else{
			span.html('').removeClass('redcolor').addClass('gree');
			validate1.newpwd=true;
		}
	});
	
		$('input[name=confirm]',regPwdForm).blur(function(){
		var newpwded=$.trim($(this).val());
		var span=$('#errorMessage_newpwded');
		if(newpwded.length<6){
				msg='请输入6位以上确认密码';
				
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate1.newpwded=false;
				return;
			}else{
				if(newpwded != $('input[name=password]').val()){
					msg='两次密码不一致';
					
					span.removeClass('gree');span.html(msg).addClass('redcolor');
					validate1.newpwded=false;
					return false;
				}else{
				span.html('').removeClass('redcolor').addClass('gree');
				validate1.newpwded=true;
			}
		}
	});
	
	
	$('.pfsInput2').blur(function(){
		var inputCode=$.trim($(this).val()).toUpperCase();//取得输入的验证码并转化为大写 
		var span=$('#errorMessage_code');
		indexCode = codeObj.toUpperCase();//默认选出的验证码
		if(inputCode.length <4){
				msg='请输入4位验证码';
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate1.code1=false;
				return;
			}else{
			  if(inputCode != indexCode ) { //若输入的验证码与产生的验证码不一致时
					msg="验证码输入错误";
					span.removeClass('gree');span.html(msg).addClass('redcolor');//验证码输入错误
					createCode();//刷新验证码
					document.getElementById("input").focus();				        		   	  
					return false;
				}else { //输入正确时	   			   			
				    	span.html('').removeClass('redcolor').addClass('gree');
					   validate1.code1=true;
					}  
		}
	});
	
	
	
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
				span.removeClass('gree');span.html(msg).addClass('redcolor');
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
							span.removeClass('gree');span.html(msg).addClass('redcolor');
							validate.email=false;
							return false;
						}else{
							
							span.html('').removeClass('redcolor');
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
			span.removeClass('gree');
			span.html(msg).addClass('redcolor');
			validate.firstname=false;
			return;
		}else{
			
			 var fe=/^[0-9a-zA-Z\u4e00-\u9fa5]*$/;
			if(!firstname || !fe.test(firstname) ) {
				msg="请输入符合规范的昵称!";
				span.removeClass('gree');
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
							span.removeClass('gree');
							span.html(msg).addClass('redcolor');
							
							validate.firstname=false;
							return false;
						}else{
							span.html('').removeClass('redcolor');
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
				
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate.password=false;
				return;
			}else{
			span.html('').removeClass('redcolor');
			validate.password=true;
		}
	});
	
	
	$('input[name=confirm]',form).blur(function(){
		var confirm=$.trim($(this).val());
		var span=$('#errorMessage_pwded');
		if(confirm.length<6){
				msg='请输入6位以上确认密码';
				
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate.pwded=false;
				return;
			}else{
				if(confirm != $('input[name=password]').val()){
					msg='两次密码不一致';
					
					span.removeClass('gree');span.html(msg).addClass('redcolor');
					validate.pwded=false;
					return false;
				}else{
				span.html('').removeClass('redcolor');
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
				
				span.removeClass('gree');span.html(msg).addClass('redcolor');
				validate.code=false;
				return;
			}else{
			  if(inputCode != indexCode ) { //若输入的验证码与产生的验证码不一致时
					msg="验证码输入错误";
					
					span.removeClass('gree');span.html(msg).addClass('redcolor');//验证码输入错误
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


//校验验证码
/*
function validate(){


    //检测邮箱地址
    var email = $("#email").val();
    
    //检测昵称
    var firstname = $("#firstname").val();
    
    //检测密码
    var password = $("#password").val();
    
    //确认密码
    var confirm = $("#confirm").val();
    
    //验证码
    var identifying = $("#identifying").val();
    
    //同意条款
    var chkbox = $("#chkbox").val();
    
    
    var pe=/^[^\@]+@.*\.[a-z]{2,6}$/;
    if(!email || !pe.test(email) ) {
        alert("请输入符合规范的邮箱地址!");
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: "index.php?route=account/register/checkemail",
            data: "email=" + email ,
            success: function(flag) {  
                if(flag) {
                    alert("该邮箱地址已经存在,请重新输入！");
                    return false;
                }
            }
            
        });
       
    }
    
    
    var fe=/^[0-9a-zA-Z\u4e00-\u9fa5]*$/;
    if(!firstname || !fe.test(firstname) ) {
        alert("请输入符合规范的昵称!");
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: "index.php?route=account/register/checkfirstname",
            data: "firstname=" + firstname ,
            success: function(flag) {  
                if(flag) {
                    alert("该用户昵称已经存在,请重新输入！");
                    return false;
                }
            }
            
        });
       
    }
    
    if(!password) {
        alert("请输入密码！");
        return false;
    }
    
    if(!confirm) {
        alert("请再次输入密码！");
        return false;
    }
    
    if(password != confirm) {
        alert("两次密码输入不一致，请重新输入!");
        return false;
    }
    
    
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


*/


















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
