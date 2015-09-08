<?php if($delivery_info) {
       foreach($delivery_info as $delivery) {
?>

<div class="ui-body">
  <div class="ex-infro">
    <div class="ex-ifro-top">
      <div class="comdiv ah">
        <span class="img"><img width="64" height="64" src="<?php echo $delivery['deliveryimg']; ?>" alt="<?php echo $delivery['deliveryname']; ?>"/><p class=""><?php echo $delivery['deliveryname']; ?></p></span>
      </div>
      <div class="comdiv ah">
        <div class="infro-com">
          <p class="ex-orgcolor"><b><?php echo $delivery['first_fee']; ?></b></p>
          <p class="grey">（首重<?php echo $delivery['first_weight']; ?>g）</p>
          <p></p>
        </div>
      </div>
      <div class="comdiv ah">
        <div class="infro-com">
          <p class="ex-orgcolor"><b><?php echo $delivery['continue_fee']; ?></b></p>
          <p class="grey">（续重<?php echo $delivery['continue_weight']; ?>g）</p>
        </div>
      </div>
      <div class="comdiv ah">
        <div class="infro-com">
          <p><b>不限</b></p>
        </div>
      </div>
      <div class="comdiv ah2">
        <div class="infro-com">
          <p class="time-end"><b><?php echo $delivery['delivery_time']; ?>个工作日</b></p>
        </div>
      </div>
    </div>
  </div>
  <div class="s-body">
    <!-- div class="percent">
      <div class="grey-notice">以下统计数据仅供参考，具体以实际为准</div>
      <div class="ta-common">
        <h2>寄送时效</h2>
        <dl>
          <dt>3天以内</dt>
          <dd>
            <div style="width:3%"></div>
          </dd>
        </dl>
        <dl>
          <dt>7天以内</dt>
          <dd>
            <div style="width:73%"></div>
          </dd>
        </dl>
        <dl>
          <dt>15天以内</dt>
          <dd>
            <div style="width:23%"></div>
          </dd>
        </dl>
        <dl>
          <dt>30天以内</dt>
          <dd>
            <div style="width:0%"></div>
          </dd>
        </dl>
      </div>
      <div class="ta-common">
        <h2>派送方式</h2>
        <dl>
          <dt>送货上门</dt>
          <dd>
            <div style="width:74%;"></div>
          </dd>
        </dl>
        <dl>
          <dt>自提</dt>
          <dd>
            <div style="width:26%"></div>
          </dd>
        </dl>
      </div>
      <div class="ta-common">
        <h2>配送通知</h2>
        <dl>
          <dt>电话通知</dt>
          <dd>
            <div style="width:4%;"></div>
          </dd>
        </dl>
        <dl>
          <dt>字条通知</dt>
          <dd>
            <div style="width:39%;"></div>
          </dd>
        </dl>
        <dl>
          <dt>都没有</dt>
          <dd>
            <div style="width:56.99999999999999%;"></div>
          </dd>
        </dl>
      </div>
      <div class="ta-common">
        <h2>是否收税</h2>
        <dl>
          <dt style="width:23px;">是</dt>
          <dd>
            <div style="width:4%"></div>
          </dd>
        </dl>
        <dl>
          <dt style="width:23px;">否</dt>
          <dd>
            <div style="width:96%;"></div>
          </dd>
        </dl>
      </div>
    </div -->
    <div class="feature-box">
      <p><img src="/images/site/tools/trait.png" align="absmiddle"/><span class="ex-feature"><?php echo $delivery['carrierDesc']; ?></span></p>
    </div>
    <div class="ex-usesay">
      <div class="user-title"><span>用过TA会说</span><a target="_blank" class="fr" href="/information-comments.html">更多</a></div>
      <div class="user-ul">
        <ul>
          <li>
            <div class="user-content">
              <?php if($delivery['comment_info']){ foreach($delivery['comment_info'] as $comment) { ?>
              <span class="face"><img src="<?php echo $comment['face']; ?>" alt="<?php echo $comment['uname'];?>"/></span>
              <div class="content-right"> <span class="uname"><?php echo $comment['uname'];?></span> <span class="uarea"><?php echo $comment['country']; ?> - <?php echo $delivery['deliveryname']; ?></span><p><?php echo $comment['comment'];?></p></span></div>
              <?php }} ?>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php }} ?>