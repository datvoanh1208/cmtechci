<div class="box-center"><!-- The box-center product-->
    <div> <h2>Thông tin nhận hàng của thành viên</h2>
             </div>
             <div class="box-content-center product"><!-- The box-content-center -->
               <form enctype="multipart/form-data" action="<?php echo site_url('order/checkout')?>" method="post" class="t-form form_action">
                
 
                 <div class="form-row">
                   <label class="form-label" for="param_email">Tổng số tiền thanh toán:</label>
                    <div class="form-item">
                      <b style="color:red"><?php echo number_format($total_amount) ?> đ</b>
                   </div>
                    <div class="clear"></div>
                  </div>

                 <div class="form-row">
                   <label class="form-label" for="param_email">Email:<span class="req">*</span></label>
                    <div class="form-item">
                      <input value="<?php echo isset($user->email) ? $user->email : ''?>" name="email" id="email" class="input" type="text">
                      <div class="clear"></div>
                      <div id="email_error" class="error"><?php echo form_error('email');?></div>
                   </div>
                    <div class="clear"></div>
                  </div>
          
      
          <div class="form-row">
            <label class="form-label" for="param_name">Họ và tên:<span class="req">*</span></label>
            <div class="form-item">
              <input value="<?php echo isset($user->name) ? $user->name : ''?>" name="name" id="name" class="input" type="text">
              <div class="clear"></div>
              <div id="name_error" class="error"><?php echo form_error('name');?></div>
            </div>
            <div class="clear"></div>
          </div>

          <div class="form-row">
            <label class="form-label" for="param_phone">Số điện thoại:<span class="req">*</span></label>
            <div class="form-item">
              <input value="<?php echo isset($user->phone) ? $user->phone : ''?>" name="phone" id="phone" class="input" type="text">
              <div class="clear"></div>
              <div id="phone_error" class="error"><?php echo form_error('phone');?></div>
            </div>
            <div class="clear"></div>
          </div>
          
          <div class="form-row">
            <label class="form-label" for="param_address">Ghi chú:<span class="req">*</span></label>
            <div class="form-item">
              <textarea name="message" id="message" class="input"></textarea>
              <p>Nhập địa chỉ nhận hàng và thời gian nhận hàng</p>
              <div class="clear"></div>
              <div id="message_error" class="error"><?php echo form_error('message'); ?></div>
            </div>
            <div class="clear"></div>
          </div>
          

          <div class="form-row">
            <label class="form-label" for="param_address">Thanh toán qua:<span class="req">*</span></label>
            <div class="form-item">
              <select name="payment">
                <option value="">----- Chọn cổng thanh toán -----</option>
                <option value="offline">Thanh toán khi nhận hàng</option>
                <option value="baokim">Bảo Kim</option>
                <option value="nganLuong">Ngân lượng</option>
              </select>
              <div class="clear"></div>
              <div id="message_error" class="error"><?php echo form_error('payment'); ?></div>
            </div>
            <div class="clear"></div>
          </div>
           
          
          <div class="form-row">
            <label class="form-label">&nbsp;</label>
            <div class="form-item">
                    <input name="submit" value="Thanh toán" class="button" type="submit">
            </div>
           </div>
            </form>

                   <div class="clear"></div>
             </div><!-- End box-content-center -->
              
</div>