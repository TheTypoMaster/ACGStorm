<!DOCTYPE html>
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>


<style type="text/css">
.content {
    font-family: Microsoft Yahei;
    position:relative;
    white-space:nowrap;
}

table.altrowstable {
	font-family: verdana,arial,sans-serif;
	font-size:20px;
	color:#333333;
	border-width: 1px;
	border-color: #a9c6c9;
	border-collapse: collapse;
    width: 100%;
}
table.altrowstable th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9;
}
table.altrowstable td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #a9c6c9; 
}
.oddrowcolor{
	background-color:#d4e3e5;
    text-align:center;
}

</style>

<div id="content">
  <div class="content">
    <div align="center"><img src="/image/data/logo.png" width="198" height="auto"/></div>
    <div align="center" style="line-height: 58px;font-size: 16px;font-weight: bold;">消费日志:<?php echo $rid ;?>消费详情</div>
   
    <table class="altrowstable">
             <tr>
             <th>运单编号</th>
             <th>包裹重量(g)</th>
             <th>运费(元)</th>
             <th>服务费(元)</th>
             <th>报关费(元)</th>
             <th>打包策略</th>
             <th>订单处理</th>
             <th>包装材料</th>
             <th>增值服务</th>
             <th>运输方式</th>
             <th>原运输方式</th>
             <th>运单金额(元)</th>
             </tr>
             
       <?php     
           if ($results) {      
              foreach ($results as $result) {   
       ?>
             
            <tr class="oddrowcolor">
                <td><?php echo $result['sid']?></td>
                <td><?php echo $result['countweight']?></td>
                <td><?php echo $result['freight']?></td>
                <td><?php echo $result['serverfee']?></td>
                <td><?php echo $result['customsfee']?></td>
                <td><?php 
                if(0 == $result['dabao']) {
                    echo "经济方案";
                }else if(1 == $result['dabao']) {
                    echo "标准方案";
                }else if(2 == $result['dabao']) {
                    echo "高级方案";
                }else if(3 == $result['dabao']) {
                    echo "免费体验";
                }
                ?></td>
                
                <td><?php 
                if(0 == $result['dingdan']) {
                    echo "经济方案";
                }else if(1 == $result['dingdan']) {
                    echo "标准方案";
                }else if(2 == $result['dingdan']) {
                    echo "高级方案";
                }else if(3 == $result['dingdan']) {
                    echo "免费体验";
                }   
                ?></td>
                
                <td><?php 
                if(0 == $result['baozhuang']) {
                    echo "标准耗材";
                }else if(1 == $result['baozhuang']) {
                    echo "坚固耗材";
                }
                ?></td>
                
                <td><?php 
                if(0 == $result['zengzhi']) {
                    echo "免费体验";
                }else if(1 == $result['zengzhi']) {
                    echo "提供大包裹方案";
                }else if(2 == $result['zengzhi']) {
                    echo "为运单拍照";
                }
                ?></td>
                
                <td><?php echo $result['deliveryname']?></td>
                <td><?php echo $result['olddeliveryname']?></td>
                <td><?php echo $result['totalfee']?></td>
            </tr>
             
        <?php  } }  ?>


        <tr >
          <td colspan="12" align="right">感谢阁下选择CNstorm，我们竭诚为您提供极致国际购物及运输体验!<br/>
            TeL:(0086)75581466633</br>
            Mailbox：support@cnstorm.com</br>
            CNstorm(ShenZhen) Co.,Ltd. All rights reserved.</td>
        </tr>
      </table>
  
  </div>
</div>

