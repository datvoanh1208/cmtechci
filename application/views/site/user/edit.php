<div class="box-center"><!-- The box-center product-->
    <div> <h2>Chỉnh sửa thông tin thành viên</h2>
             </div>
             <div class="box-content-center product"><!-- The box-content-center -->
               <form enctype="multipart/form-data" action="<?php echo site_url('user/edit')?>" method="post" class="t-form form_action">
                  <div class="form-row">
            <label class="form-label" for="param_email">Email:</label>
            <div class="form-item">
             <?php echo $user->email?>
            </div>
            <div class="clear"></div>
          </div>
          
          <div class="form-row">
            <label class="form-label" for="param_password">Mật khẩu:</label>
            <div class="form-item">
              <input name="password" id="password" class="input" type="password">
              <div class="clear"></div>
              <p>Nếu thay đổi mật khẩu thì nhập dữ liệu</p>
              <div id="password_error" class="error"><?php echo form_error('password');?></div>
            </div>
            <div class="clear"></div>
          </div>
          
          <div class="form-row">
            <label class="form-label" for="param_re_password">Gõ lại mật khẩu:</label>
            <div class="form-item">
              <input name="re_password" id="re_password" class="input" type="password">
              <div class="clear"></div>
              <div id="re_password_error" class="error"><?php echo form_error('re_password');?></div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="form-row">
            <label class="form-label" for="param_name">Họ và tên:<span class="req">*</span></label>
            <div class="form-item">
              <input value="<?php echo $user->name?>" name="name" id="name" class="input" type="text">
              <div class="clear"></div>
              <div id="name_error" class="error"><?php echo form_error('name');?></div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="form-row">
            <label class="form-label" for="param_phone">Số điện thoại:<span class="req">*</span></label>
            <div class="form-item">
              <input value="<?php echo $user->phone?>" name="phone" id="phone" class="input" type="text">
              <div class="clear"></div>
              <div id="phone_error" class="error"><?php echo form_error('phone');?></div>
            </div>
            <div class="clear"></div>
          </div>
          
          <div class="form-row">
            <label class="form-label" for="param_address">Địa chỉ:<span class="req">*</span></label>
            <div class="form-item">
              <textarea name="address" id="address" class="input"><?php echo $user->address;?></textarea>
              <div class="clear"></div>
              <div id="address_error" class="error"><?php echo form_error('address'); ?></div>
            </div>
            <div class="clear"></div>
          </div>
          
           
          
          <div class="form-row">
            <label class="form-label">&nbsp;</label>
            <div class="form-item">
                    <input name="submit" value="Chỉnh sửa thông tin" class="button" type="submit">
            </div>
           </div>
            </form>

                   <div class="clear"></div>
             </div><!-- End box-content-center -->
              
</div>