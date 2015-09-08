 //商品详细页点击选择颜色或尺寸
    $(".color_list li").each(function() {
        $(this).click(function() {
		
				if($(this).hasClass("noclick")){
					
					return false;
				}else if ($(this).children().hasClass("cannot_choose")) {
					return false;
				} else {
				
					$(this).addClass('after_choose').siblings().removeClass("after_choose");
					setPrice();
						
				}
			
        });
    });
	
    $(".size_list li").each(function() {
        $(this).click(function() {
            if ($(this).children().hasClass("cannot_choose")) {
                return false;
            } else {
                $(this).addClass('after_choose').siblings().removeClass("after_choose");
				var indexSize=$(this).children('a').attr('alt');
			
				$('input[name=hsize]').val(indexSize);
					setShowColor(indexSize);
				setPrice();
			
            }

        });
    });

    	function setPrice(){
console.log(121212);
			var indexColor=$('input[name=hcolor]').val();	
			var indexSize=$('input[name=hsize]').val();	
			if(!indexSize){
					$.each(obj,function(name,value){ 
						indexSize=name;
						return false;
					})
				$('input[name=hsize]').val(indexSize);		
			}
			
			if(!indexColor){
		
					var indexSize=$('input[name=hsize]').val();	
					setShowColor(indexSize);
					$.each(obj[indexSize],function(name,value){ 
						indexColor=name;
						return false;
					})
					$('input[name=hcolor]').val(indexColor);
			}
			
			var price=obj[indexSize][indexColor].price;
			var kucun=obj[indexSize][indexColor].kucun;
			$('.size_list li').children('a[alt="'+indexSize+'"]').parent().addClass('after_choose').siblings().removeClass("after_choose");
			$('.color_list li').children('a[alt="'+indexColor+'"]').parent().addClass('after_choose').siblings().removeClass("after_choose");
			$('#price').html(price);
			$('.kucun').html('<span alt='+kucun+'>库存'+kucun+'</span>');
	}

	function setShowColor(indexSize){
	
			var temp = []; //临时数组1  
			$.each(obj[indexSize],function(name,value){ 
							
			  temp[name] = true;//巧妙地方：把数组B的值当成临时数组1的键并赋值为真  
						
			}); 	 
			
		 $(".color_list li").each(function(){

			var indexColor=$(this).find('a').attr('alt');
			$(this).removeClass('noclick');
			
			if( !temp[indexColor] ){
					$(this).addClass('noclick');
					if($('input[name=hcolor]').val()==indexColor){
						$('input[name=hcolor]').val('');
					}
				}
		})
	}
$(function(){
		setPrice();
})