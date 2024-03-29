<div class="titleArea">
	<div class="wrapper">
		<div class="pageTitle">
			<h5>Bảng điều khiển</h5>
			<span>Trang quản lý hệ thống</span>
		</div>
		
		<div class="clear"></div>
	</div>
</div>

<div class="line"></div>

<div class="wrapper">
	
	<div class="widgets">
	     <!-- Stats -->
		
<!-- Amount -->
<div class="oneTwo">
	<div class="widget">
		<div class="title">
			<img src="<?php echo public_url('admin') ?>/images/icons/dark/money.png" class="titleIcon">
			<h6>Doanh số</h6>
		</div>
		
		<table class="sTable myTable" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
					<tr>
							<td class="fontB blue f13">Tổng doanh số</td>
							<td class="textR webStatsLink red" style="width:120px;">44,000,000 đ</td>
					</tr>
				    
				    <tr>
							<td class="fontB blue f13">Doanh số hôm nay</td>
							<td class="textR webStatsLink red" style="width:120px;">0 đ</td>
					</tr>
					
				    <tr>
							<td class="fontB blue f13">Doanh số theo tháng</td>
							<td class="textR webStatsLink red" style="width:120px;">
							0 đ
							</td>
					</tr>
				    
			</tbody>
		</table>
	</div>
</div>


<!-- User -->
<div class="oneTwo">
	<div class="widget">
		<div class="title">
			<img src="<?php echo public_url('admin') ?>/images/icons/dark/users.png" class="titleIcon">
			<h6>Thống kê dữ liệu</h6>
		</div>
		
		<table class="sTable myTable" width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td>
						<div class="left">Tổng số gia dịch</div>
						<div class="right f11"><a href="admin/tran.html">Chi tiết</a></div>
					</td>
					
					<td class="textC webStatsLink">
						15					</td>
				</tr>
				
				<tr>
					<td>
						<div class="left">Tổng số sản phẩm</div>
						<div class="right f11"><a href="admin/product.html">Chi tiết</a></div>
					</td>
					
					<td class="textC webStatsLink">
						8					</td>
				</tr>
				
				<tr>
					<td>
						<div class="left">Tổng số bài viết</div>
						<div class="right f11"><a href="admin/news.html">Chi tiết</a></div>
					</td>
					
					<td class="textC webStatsLink">
						4					</td>
				</tr>
				
				<tr>
					<td>
						<div class="left">Tổng số thành viên</div>
						<div class="right f11"><a href="admin/user.html">Chi tiết</a></div>
					</td>
					
					<td class="textC webStatsLink">
						2					</td>
				</tr>
				<tr>
					<td>
						<div class="left">Tổng số liên hệ</div>
						<div class="right f11"><a href="admin/contact.html">Chi tiết</a></div>
					</td>
					
					<td class="textC webStatsLink">
						0					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

		<div class="clear"></div>
		
		<!-- Giao dich thanh cong gan day nhat -->
		
	<div class="widget">
		<div class="title">
			<span class="titleIcon"><div class="checker" id="uniform-titleCheck"><span><input id="titleCheck" name="titleCheck" style="opacity: 0;" type="checkbox"></span></div></span>
			<h6>Danh sách Giao dịch</h6>
		</div>
		
		<table class="sTable mTable myTable" id="checkAll" width="100%" cellspacing="0" cellpadding="0">
			
			
			<thead>
				<tr>
					<td style="width:10px;"><img src="<?php echo public_url('admin') ?>/images/icons/tableArrows.png"></td>
					<td style="width:60px;">Mã số</td>
					<td style="width:75px;">Thành viên</td>
					<td style="width:90px;">Số tiền</td>
					<td>Hình thức</td>
					<td style="width:100px;">Giao dịch</td>
					<td style="width:75px;">Ngày tạo</td>
					<td style="width:55px;">Hành động</td>
				</tr>
			</thead>
			
 			<tfoot class="auto_check_pages">
				<tr>
					<td colspan="8">
						 <div class="list_action itemActions">
								<a href="#submit" id="submit" class="button blueB" url="admin/tran/del_all.html">
									<span style="color:white;">Xóa hết</span>
								</a>
						 </div>
					</td>
				</tr>
			</tfoot>
			
			<tbody class="list_item">
							

							<tr>
					<td><div class="checker" id="uniform-undefined"><span><input name="id[]" value="12" style="opacity: 0;" type="checkbox"></span></div></td>
					
					<td class="textC">12</td>
					
					<td>
						Võ Anh Đạt					</td>
					
					<td class="textR red">10,000,000</td>
					
					<td>
					nganluong					</td>
					
					
					<td class="status textC">
						<span class="completed">
						Thành công						</span>
					</td>
					
					<td class="textC">13-08-2014</td>
					
					<td class="textC">
							<a href="admin/tran/view/12.html" class="lightbox cboxElement">
								<img src="<?php echo public_url('admin') ?>/images/icons/color/view.png">
							</a>
							
						   <a href="admin/tran/del/12.html" class="tipS verify_action" original-title="Xóa">
						    <img src="<?php echo public_url('admin') ?>/images/icons/color/delete.png">
						   </a>
					</td>
				</tr>
						</tbody>
			
		</table>
	</div>

        	</div>
	
</div>

<div class="clear mt30"></div>