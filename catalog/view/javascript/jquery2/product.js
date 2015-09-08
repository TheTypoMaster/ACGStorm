/**************************************/
/*@author:  Kenne Wei<wk@cnstorm.com> */
/*@date:     2014.5.27               */
/**************************************/
var color_value = '';
var size_value = '';
var color_snatch_value = '';
var size_snatch_value = '';


function click_color(select_color)
{	
	 if ($('#'+ select_color).hasClass("cannot_choose"))
	 {
		//$(this).preventDefault();
		return false;
     }
	
     color_value = select_color;
     var x = document.getElementById(color_value);
     var hcolor = x.innerHTML;
     hcolor = hcolor.replace(/<[^>].*?>/g,"");
	 $('#hcolor').attr("value",hcolor);
	 //alert(hcolor);
     $('.size_list a').removeClass("cannot_choose");
     $.ajax({
		        type: "POST",
                url: 'index.php?route=product/product/getsizeinfo',
                dataType: "json",
				data: "color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(size in data)
                                             { 
                                                $('#'+ data[size]).addClass("cannot_choose");


                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    $.ajax({
		        type: "POST",
                url: 'index.php?route=product/product/getimg',
                dataType: "json",
				data: "color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             $("#imgwrapper img").attr("src", data);
                                          }
                                          
			                          },

         })
    if(size_value && color_value)
    {
	 
         $.ajax({
		        type: "POST",
                url: 'index.php?route=product/product/getcolorsizeinfo',
                dataType: "json",
				data: "size=" +  size_value + "&color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             $('#price').text(data['price']);
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    }
    
   
   
}


function click_size(select_size)
{	
    if ($('#'+ select_size).hasClass("cannot_choose")) 
	{
		//$(this).preventDefault();
		return false;
    }
	
	/*
	if($(this).hasClass("color_wenzi cannot_choose")) {
	//$(this).preventDefault();
	alert("false");
	return false;
	};
	*/
	
    size_value = select_size;
    var x = document.getElementById(size_value);
    var hsize = x.innerHTML;
    hsize = hsize.replace(/<[^>].*?>/g,"");
	$('#hsize').attr("value",hsize);
    $('.color_list a').removeClass("cannot_choose");
    $.ajax({
		        type: "POST",
                url: 'index.php?route=product/product/getcolorinfo',
                dataType: "json",
				data: "size=" + size_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(color in data)
                                             { 
                                                
                                                $('#'+ data[color]).addClass("cannot_choose");
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    if(size_value && color_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=product/product/getcolorsizeinfo',
                dataType: "json",
				data: "size=" + size_value  + "&color=" + color_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                              $('#price').text(data['price']);  
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
        })
    }
}


function preg_snatch_color(select_color_name)
{
     $('#colorname').attr("value",select_color_name);
}


function click_snatch_color(select_color,select_color_name)
{	
	/*
    if ($('.size_list a').hasClass("cannot_choose")) {
	this.preventDefault();
	return false;
    };
	*/
	if ($('#'+ select_color).hasClass("cannot_choose"))
	 {
		//$(this).preventDefault();
		return false;
     }
	 
  
     color_snatch_value = select_color;
     $('#colorname').attr("value",select_color_name);
     $('#searchcolor').attr("value",color_snatch_value);
     $('.size_list a').removeClass("cannot_choose");
     $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getsizeinfo',
                dataType: "json",
				data: "color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(size in data)
                                             { 
                                                $('#'+ data[size]).addClass("cannot_choose");
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getimg',
                dataType: "json",
				data: "color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             $("#imgwrapper img").attr("src", data);
                                          }
                                          
			                          },

         })
         
    $.ajax({
		type: "POST",
                url: 'index.php?route=product/snatch/getprice',
                dataType: "json",
				data: "key=" + select_color_name,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          {                                           
                                             $('#price').val(data); 
                                          }
                                          
			                          },

         })
         
    if(size_snatch_value && color_snatch_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getcolorsizeinfo',
                dataType: "json",
				data: "size=" +  size_snatch_value + "&color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
			
				                          if(data)
                                          { 
                                        
                                             
                                           $('#price').val(data['price']); 
                                          }
                                          
			                          },

				error: function(data){				    
                   // alert("系统繁忙，请稍后再试！");			 
				}
         })
    }
    
   
   
}


function preg_snatch_size(select_size_name)
{
    $('#sizename').attr("value",select_size_name);
}


function click_snatch_size(select_size,select_size_name)
{	
/*
    if ($('.size_list a').hasClass("cannot_choose")) {
	this.preventDefault();
	return false;
    };
*/
	if ($('#'+ select_size).hasClass("cannot_choose")) 
	{
		//$(this).preventDefault();
		return false;
    }
	

    size_snatch_value = select_size;
    $('#sizename').attr("value",select_size_name);
    $('#searchsize').attr("value",size_snatch_value);
    $('.color_list a').removeClass("cannot_choose");
    $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getcolorinfo',
                dataType: "json",
				data: "size=" + size_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(color in data)
                                             { 
                                                
                                                $('#'+ data[color]).addClass("cannot_choose");
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    
    $.ajax({
		type: "POST",
                url: 'index.php?route=product/snatch/getprice',
                dataType: "json",
				data: "key=" + select_size_name,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          {                                           
                                             $('#price').val(data); 
                                          }
                                          
			                          },

         })
         
    if(size_snatch_value && color_snatch_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getcolorsizeinfo',
                dataType: "json",
				data: "size=" + size_snatch_value  + "&color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				         
				                          if(data)
                                          { 
                                              
                                         
                                              
                                            $('#price').val(data['price']); 
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
        })
    }
}

function preg_zizhu_color(select_color_value)
{
   $('#zizhucolor').attr("value",select_color_value);
}

function click_zizhu_color(select_color,select_color_value)
{	
	/*
    if ($('.size_list a').hasClass("cannot_choose")) {
	this.preventDefault();
	return false;
    };
	*/
	if ($('#'+ select_color).hasClass("cannot_choose"))
	 {
		//$(this).preventDefault();
		return false;
     }
	 
  
     color_snatch_value = select_color;
	 $('#zizhucolor').attr("value",select_color_value);
     $('.size_list a').removeClass("cannot_choose");
     $.ajax({
		        type: "POST",
                url: 'index.php?route=product/snatch/getsizeinfo',
                dataType: "json",
				data: "color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(size in data)
                                             { 
                                                $('#'+ data[size]).addClass("cannot_choose");
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    $.ajax({
		        type: "POST",
                url: 'index.php?route=order/snatch/getimg',
                dataType: "json",
				data: "color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             $("#imgwrapper img").attr("src", data);
                                          }
                                          
			                          },

         })
    if(size_snatch_value && color_snatch_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=order/snatch/getcolorsizeinfo',
                dataType: "json",
				data: "size=" +  size_snatch_value + "&color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             $('#price2').text(data['price']);
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    }
    
   
   
}

function preg_zizhu_size(select_size_value)
{
   $('#zizhusize').attr("value",select_size_value);
}


function click_zizhu_size(select_size,select_size_value)
{	
/*
    if ($('.size_list a').hasClass("cannot_choose")) {
	this.preventDefault();
	return false;
    };
*/
	if ($('#'+ select_size).hasClass("cannot_choose")) 
	{
		//$(this).preventDefault();
		return false;
    }
	

    size_snatch_value = select_size;
	$('#zizhusize').attr("value",select_size_value);
    $('.color_list a').removeClass("cannot_choose");
    $.ajax({
		        type: "POST",
                url: 'index.php?route=order/snatch/getcolorinfo',
                dataType: "json",
				data: "size=" + size_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                             for(color in data)
                                             { 
                                                
                                                $('#'+ data[color]).addClass("cannot_choose");
                                             }
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
         })
    if(size_snatch_value && color_snatch_value)
    {
         $.ajax({
		        type: "POST",
                url: 'index.php?route=order/snatch/getcolorsizeinfo',
                dataType: "json",
				data: "size=" + size_snatch_value  + "&color=" + color_snatch_value,
                //contentType: "application/json;utf-8",   
                timeout: 25000,
				success: function(data){  
				                          if(data)
                                          { 
                                              $('#price2').text(data['price']);  
                                          }
                                          
			                          },

				error: function(data){				    
                    //alert("系统繁忙，请稍后再试！");			 
				}
        })
    }
}





function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
						
			if (json['success']) {
				alert("收藏成功！");
			}	
		}
	});
}


function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

function Border(total, balance,type) {
    isonly = $('#isonly').val();
    if (isonly) {
        oids = $('#single_oid').text();
    } else {
        oids = $('#order_id').val();
    }
	//判断空值
	if(total && balance){
		if(Number(balance) >= Number(total)){
			$('#pdllg_box').show();
			/*
			var obj=document.getElementById('dlg_box_contents');
			var content=obj.innerHTML;
			var biaoqing=new Array('.','..','...','....','.....');
			var J=0;
			var time1=setInterval(function(){
					if(J==5){
						clearInterval(time1);
					}else{
						obj.innerHTML=content+''+biaoqing[J];
					}
					J++;
				},500);
				*/
			$.ajax({
				url: 'index.php?route=checkout/confirm/Border',
				type: 'post',
				data: 'total=' + total + '&balance=' + balance + '&oids=' + oids + '&type=' + type,
				dataType: 'text',
				success: function(data) {
					if(data != 'no'){
						sendEmail(type);
						setTimeout(function(){
							$('#pdllg_box').hide();
							swal({
								  title: "支付成功!",
								  type:  "success",
								  timer: "2000"
								}); 
								setTimeout(function(){
									window.location.href="index.php?route=order/order";
								},1000)
						},3000);
					}else{
						$('#pdllg_box').hide();
						$('#notpaid').fadeIn().removeClass("hide");		
					}	
				},
				error: function(data){
					$('#pdllg_box').hide();
					$('#notpaid').fadeIn().removeClass("hide");			 
				}
			});
			
		}else{
			
			$('#notpaid').fadeIn().removeClass("hide");			 
		}
	}else{
	    swal({
                  title: "余额不足或者是问题订单,请重新下单!",
                  type:  "error",
                  timer: "2000"
             }); 
	}
}

 function sendEmail(type){
	$.get('index.php?route=checkout/confirm/sendEmail&type=' + type);
}




