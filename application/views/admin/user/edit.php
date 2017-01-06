<!-- Load ra cai file head -->
<?php $this->load->view('admin/user/head', $this->data) ?>

<div class="line"></div>
<div class="wrapper">
	<div class="widget">
	
		<div class="title">
			<h6>Cập nhật thông tin thành viên</h6>
		</div>
        <form id="form" class="form" action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <div class="formRow">
            <label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
            <div class="formRight">
                    <span class="oneTwo"><input name="name" id="param_name" value="<?php echo $info->name ?>"_autocheck="true" type="text"></span>
                    <span name="name_autocheck" class="autocheck"></span>
                    <div name="name_error" class="clear error"><?php echo form_error('name')?></div>
            </div>
            <div class="clear"></div>
            </div>
            
            <div class="formRow">
            <label class="formLeft" for="param_email">Email:<span class="req">*</span></label>
            <div class="formRight">
                    <span class="oneTwo"><input name="email" id="param_email" value="<?php echo $info->email ?>" autocheck="true" type="text"></span>
                    <span name="name_autocheck" class="autocheck"></span>
                    <div name="name_error" class="clear error"><?php echo form_error('email')?></div>
            </div>
            <div class="clear"></div>
            </div>

            
            <div class="formSubmit">
                <input value="Cập nhật" class="redB" type="submit">
	    </div>
         
            

        </fieldset>
        </form>
        </div>
    
</div>