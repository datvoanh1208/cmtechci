<?php $this->load->view('site/slide', $this->data); ?>

<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
               <h2>Sản phẩm mới</h2>
             </div>
             <div class="box-content-center product"><!-- The box-content-center -->
               <?php foreach($product_newest as $row): ?>
               <div class="product_item">
              <h3>
                <a href="<?php echo base_url('product/view/'.$row->id)?>" title="<?php echo $row->name ?> ">
                <?php echo $row->name ?>                   
                </a>
                  </h3>
              <div class="product_img">
                    <a href="<?php echo base_url('product/view/'.$row->id)?>" title="<?php echo $row->name ?>">
                       <img src="<?php echo base_url('upload/product/'.$row->image_link)?>" alt="<?php echo $row->name ?> ">
                   </a>
              </div>
                     

              <p class="price"> 
              <?php if($row->discount > 0): ?> 
              <?php $price_new = $row->price - $row->discount; ?>
              <?php echo number_format($price_new) ?> <span class="price_old"><?php echo number_format($row->price) ?> đ</span>
               <?php else: ?> 
                <?php echo number_format($row->price) ?> đ
                <?php endif;?>
               </p>
               <center>
                 <div class='raty' style='margin:10px 0px' id='9' data-score='4'>
                   <!-- <img src="raty/img/star-on.png" alt="1" title="good">&nbsp;
                   <img src="raty/img/star-on.png" alt="2" title="good">&nbsp;
                   <img src="raty/img/star-on.png" alt="3" title="good">&nbsp;
                   <img src="raty/img/star-on.png" alt="4" title="good">&nbsp;
                   <img src="raty/img/star-off.png" alt="5" title="good">
                   <input name="score" value="4" readonly="readonly" type="hidden"> -->
                 </div>
               </center>
              <div class="action">
                  <p style="float:left;margin-left:10px">Lượt xem: <b><?php echo $row->view ?></b></p>
                      <a class="button" href="" title="Mua ngay">Mua ngay</a>
                      <div class="clear"></div>
              </div>
          </div>
           <?php  endforeach;?>          

                   <div class="clear"></div>
             </div><!-- End box-content-center -->
</div>


<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
               <h2>Sản phẩm được mua nhiều</h2>
             </div>
             <div class="box-content-center product"><!-- The box-content-center -->
               <?php foreach($product_buy as $row): ?>
               <div class="product_item">
              <h3>
                <a href="<?php echo base_url('product/view/'.$row->id)?>" title="<?php echo $row->name ?> ">
                <?php echo $row->name ?>                   
                </a>
                  </h3>
              <div class="product_img">
                    <a href="" title="<?php echo $row->name ?>">
                       <img src="<?php echo base_url('upload/product/'.$row->image_link)?>" alt="<?php echo $row->name ?> ">
                   </a>
              </div>
                     

              <p class="price"> 
              <?php if($row->discount > 0): ?> 
              <?php $price_new = $row->price - $row->discount; ?>
              <?php echo number_format($price_new) ?> <span class="price_old"><?php echo number_format($row->price) ?> đ</span>
               <?php else: ?> 
                <?php echo number_format($row->price) ?> đ
                <?php endif;?>
               </p>
               <center>
                 <div class='raty' style='margin:10px 0px' id='9' data-score='4'>
                  <!--  <img src="raty/img/star-on.png" alt="1" title="good">&nbsp;
                   <img src="raty/img/star-on.png" alt="2" title="good">&nbsp;
                   <img src="raty/img/star-on.png" alt="3" title="good">&nbsp;
                   <img src="raty/img/star-on.png" alt="4" title="good">&nbsp;
                   <img src="raty/img/star-off.png" alt="5" title="good">
                   <input name="score" value="4" readonly="readonly" type="hidden"> -->
                 </div>
               </center>
              <div class="action">
                  <p style="float:left;margin-left:10px">Lượt mua: <b><?php echo $row->buyed ?></b></p>
                      <a class="button" href="" title="Mua ngay">Mua ngay</a>
                      <div class="clear"></div>
              </div>
          </div>
           <?php  endforeach;?>          

                   <div class="clear"></div>
             </div><!-- End box-content-center -->
</div>