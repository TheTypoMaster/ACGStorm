<?php echo $header;?>
<title>CNstorm代购全中国--海外留学生、华人代购淘宝/天猫/京东等首选平台，包括服饰代购，鞋靴代购、箱包代购、手机数码大狗，食品代购等等超过16个大类，150个小类。</title>
<meta name="keywords" content="代购淘宝,国内代购,服装代购，化妆品代购，食品代购，礼物代购，首饰代购、书籍代购、特产代购、手机代购" />
<meta name="description" content="海外留学生、华人代购国货网站，代购中国商品必选cnstorm代购公司，一站代购淘宝、拍拍、京东等网站国货，国际邮费最低12元起。" />
<style type="text/css">

html {text-rendering: optimizelegibility;color: #000;}
body{font: 12px/1.5 Tahoma,Tahoma,"宋体",sans-serif;}
nav{display: block;}
a {text-decoration: none;}
i {font-style: normal;}
#breadcrumb .first {color: #666;float: left;font-family: "Microsoft YaHei","黑体";font-size: 14px;}
#breadcrumb .crust {display: inline;float: left;margin-left: 20px;}
#breadcrumb .crust a {color: #000;font-size: 12px;margin-right: 20px;}
#breadcrumb .last {display: inline;float: left;font-size: 12px;margin-left: 20px;}


</style>

<nav id="breadcrumb" class="child_nav" data-uts-mode="2">
    <span class="first">你当前的位置：</span>
    <span class="first">
        <a href="/">首页</a>
        <i>></i>
    </span>
    <span class="first">
        <a href="http://www.acgstorm.com/index.php?route=product/types&path=<?php echo $path; ?>"><?php echo $categoryName; ?></a>
        <i>></i>
    </span>
    <span class="first">
        <a href=""><?php echo $s_categoryName; ?></a>
    </span>
</nav>

<div class="shopping_bg wrap ml10">
  <div class="shopping_types">
     <?php for($i=0;$i<count($categoryids);$i++) {  ?>
     <div class="goods classify">
         <h3 class="<?php echo 'goods'.$i ;?>"><em class="item_bg"><?php echo $categoryids[$i]['name']; ?></em></h3>
         <ul class="choose">
         <?php foreach ($s_categoryids as $s_categoryid) {  ?>
         <?php if($s_categoryid['s_parent_category_id'] == $categoryids[$i]['category_id']) {  ?> 
            
             <li><a href="<?php echo $s_categoryid['href'];?>"><?php echo $s_categoryid['name']; ?></a></li>
         <?php } }?> 
         </ul>
     </div>
     <?php } ?>
   
  </div>
</div>
<div class="look_through wrap">
  <div class="goods_sort ml10">
     <ul class="goods_sort_list">


        <?php if($sort_id == 'ASC'){?>
        <li><a href="<?php echo $urlNew ?>&sort=viewed&sort_id=<?php echo $sort_id; ?>">按人气从高到低</a></li>
    <?php }elseif ($sort_id == 'DESC'){?>
                <li><a href="<?php echo $urlNew ?>&sort=viewed&sort_id=<?php echo $sort_id; ?>">按人气从低到高</a></li>
    <?php }else{?>
                <li><a href="<?php echo $urlNew ?>&sort=viewed&sort_id=<?php echo $sort_id; ?>">人气</a></li>
    <?php }?>
    
    <?php if($sort_name == 'ASC'){?>
                <li><a href="<?php echo $urlNew ?>&sort=date_modified&sort_name=<?php echo $sort_name; ?>">按最新从早到晚</a></li>
    <?php }elseif ($sort_name == 'DESC'){?>
                <li><a href="<?php echo $urlNew ?>&sort=date_modified&sort_name=<?php echo $sort_name; ?>">按最新从晚到早</a></li>
    <?php }else{?>
                <li><a href="<?php echo $urlNew ?>&sort=date_modified&sort_name=<?php echo $sort_name; ?>">最新</a></li>
    <?php }?>
    
    <?php if($sort_age == 'ASC'){?>
                <li><a href="<?php echo $urlNew ?>&sort=price&sort_age=<?php echo $sort_age; ?>">按价格从高到低</a></li>
    <?php }elseif ($sort_age == 'DESC'){?>
                <li><a href="<?php echo $urlNew ?>&sort=price&sort_age=<?php echo $sort_age; ?>">按价格从低到高</a></li>
    <?php }else{?>
                <li><a href="<?php echo $urlNew ?>&sort=price&sort_age=<?php echo $sort_age; ?>">价格</a></li>
    <?php }?>


        <!-- <li><a href="javascript:void(0);">人气<i class="go_top"></i></a></li>
        <li><a href="javascript:void(0);">最新<i class="go_top"></i></a></li>
        <li><a href="javascript:void(0);">价格<i class="go_top"></i></a></li> -->
     </ul>
     <!--
     <p class="goods_sort_info ml10"><span class="total">共<em><?php echo $product_total ;?></em>件商品</span><span class="pages"><em><?php echo $page;?></em>/<?php echo $pagenum;?> </span><a class="click_left now" href="<?php if($page>1) echo str_replace("{page}",$page-1,$url);?><&lt;</a>  <a class="click_right" href="<?php if($page<$pagenum) echo str_replace("{page}",$page+1,$url);?>">&gt;</a></p>
     -->
  </div>
  <ul class="cloth_list">
        <?php foreach($products as $product)  { ?>
        <li>
            <a target="_blank" href="<?php echo $product['href'];?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name'];?>" ></a>
            <a target="_blank" class="introduce" href="<?php echo $product['href'];?>"><?php echo $product['name'];?></a>
            <strong class="current_price">￥<?php echo $product['price']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;人气：<span><?php echo $product['viewed']; ?></span></strong>
            <span class="btn"><a class="add" href="javascript:void(0);">加入购物车</a><a class="save" href="javascript:void(0);">收藏</a></span>
        </li>
        <?php } ?> 
  </ul>
     <div class="pages_change"><?php echo $pagination; ?></div>
    <div class="CLR"></div>
   
</div>

<?php echo $footer; ?>