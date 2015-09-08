<div id="division_space"><div style="padding: 5px 10px;border: 1px solid #f9dfb2;margin: 8px 0;background: #ffffe0;width: 1138px;text-align: center;"> <strong>温馨提示：</strong>只选择包裹一则表示所有商品将由一个包裹寄出。选择包裹二则表示敏感品由包裹一寄出，其它商品由包裹二寄出。 <a href="/index.php?route=help/help&qid=80" target="_blank" style="color:#0078b6;">为什么要分箱邮寄？</a></div>
<i style="color:red;font-size: 15px;font-weight:bolder">*包裹一：请选择含敏感品包裹的运输方式(必选)</i></div>
<?php if($deliver_array){foreach($deliver_array as $deliver){ ?>
<div class="ui-body">
              <div class="ex-infro">
                <div class="ex-ifro-top">

                  <div class="comdiv0">
                    <div class="de_did">
                    <input class="radio" type="radio" name="did" value="<?php echo $deliver['did']; ?>">
                    <input type="hidden" name="areaid" value="<?php echo $deliver['areaid']; ?>">
                    </div>
                    <div class="de_img">
                    <div class="sensitive"><img src="/images/post/sensitive.png"></div>
                    <img class="deliveryimg" src="<?php echo $deliver['deliveryimg']; ?>" alt="<?php echo $deliver['deliveryname']; ?>">
                    <p><?php echo $deliver['deliveryname']; ?></p>
                    </div> 
                  </div>

                  <div class="comdiv1">
                    <div class="infro-com">
                      <p class="ex-orgcolor"><b><?php echo $deliver['first_fee']; ?></b></p>
                      <p class="grey">(首重<?php echo $deliver['first_weight']; ?>g)</p>
                      <p></p>
                    </div>
                  </div>

                  <div class="comdiv2">
                    <div class="infro-com">
                      <p class="ex-orgcolor"><b><?php echo $deliver['continue_fee']; ?></b></p>
                      <p class="grey">(续重<?php echo $deliver['continue_weight']; ?>g)</p>
                    </div>
                  </div>

                  <div class="comdiv3">
                    <div class="infro-com">
                      <p><b>20000</b></p>
                    </div>
                  </div>

                  <div class="comdiv4">
                    <div class="infro-com">
                      <p class="time-end"><b><?php echo $deliver['delivery_time']; ?>个工作日</b></p>
                    </div>
                  </div>

                  <div class="comdiv5">
                    <div class="infro-com">
                      <p class="point"><?php echo $deliver['carrierDesc']; ?></p>
                    </div>
                  </div>

                </div>
            </div>
</div>
<?php }} ?>
<div id="division_space"><i style="color:red; font-size: 15px;font-weight:bolder">*包裹二：请选择含非敏感品包裹的运输方式(可选)</i></div>
<?php if(isset($deliver_sensitive_array)) { ?>
<?php foreach($deliver_sensitive_array as $deliver_sensitive) { ?>
<div class="ui-sensitive-body">
    <div class="ex-infro">
        <div class="ex-ifro-top">
          <div class="comdiv0">
            <div class="de_did">
            <input class="radio" type="radio" name="did_sensitive" value="<?php echo $deliver_sensitive['did']; ?>">
            </div>
            <div class="de_img">
            <img class="deliveryimg" src="<?php echo $deliver_sensitive['deliveryimg']; ?>" alt="<?php echo $deliver_sensitive['deliveryname']; ?>">
            <p><?php echo $deliver_sensitive['deliveryname']; ?></p>
            </div> 
          </div>

          <div class="comdiv1">
            <div class="infro-com">
              <p class="ex-orgcolor"><b><?php echo $deliver_sensitive['first_fee']; ?></b></p>
              <p class="grey">(首重<?php echo $deliver_sensitive['first_weight']; ?>g)</p>
              <p></p>
            </div>
          </div>

          <div class="comdiv2">
            <div class="infro-com">
              <p class="ex-orgcolor"><b><?php echo $deliver_sensitive['continue_fee']; ?></b></p>
              <p class="grey">(续重<?php echo $deliver_sensitive['continue_weight']; ?>g)</p>
            </div>
          </div>

          <div class="comdiv3">
            <div class="infro-com">
              <p><b>20000</b></p>
            </div>
          </div>

          <div class="comdiv4">
            <div class="infro-com">
              <p class="time-end"><b><?php echo $deliver_sensitive['delivery_time']; ?>个工作日</b></p>
            </div>
          </div>

          <div class="comdiv5">
            <div class="infro-com">
              <p class="point"><?php echo $deliver_sensitive['carrierDesc']; ?></p>
            </div>
          </div>

        </div>
    </div>
</div>
<?php }}  ?>
