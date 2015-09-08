/**********************************************************************/
/**@author:  Kenne Wei<wk@cnstorm.com>                                */
/**@date:    2014-08-07                                               */
/**@function:运单列表批量付款                               */
/**********************************************************************/	
window.onload = function() {
var tr = document.getElementsByClassName('daigou_hei'); //行
var selectInputs = document.getElementsByClassName('check'); // 所有勾选框
var checkAllInputsFront = document.getElementsByClassName('SelectAll_front'); //前全选框


/*更新总金额和选定订单号*/
function getTotal() {
	var buyid = '';
	
	for (var i = 0; i < tr.length; i++) {
		if(tr[i].getElementsByTagName('input')[0].checked) {
			buyid   += tr[i].getElementsByTagName('input')[0].value + ",";
		}	
	}
	$("#waybillbatch_pay").attr("value", buyid);
}

/*选择批量支付订单*/
    for (var i = 0; i < selectInputs.length; i++) {
        selectInputs[i].onclick = function() {
            if (this.className.indexOf('SelectAll') >= 0) { //如果是全选，则吧所有的选择框选中
					if (this.checked) {
						for (var j = 0; j < selectInputs.length; j++) {
						    if(!selectInputs[j].disabled)
								selectInputs[j].checked = this.checked; 
						}   
					} else {
						for (var j = 0; j < selectInputs.length; j++) {
							if(!selectInputs[j].disabled)
								selectInputs[j].checked = this.checked;
						}
					}
			}
			
			if (!this.checked)
			{
			    for (var m = 0; m < checkAllInputsFront.length; m++) {
                    checkAllInputsFront[m].checked = false;
				}
			}
			
			getTotal();//选完更新订单号
		} 
		
    } 

}



