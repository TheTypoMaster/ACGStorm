
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