<!-- Load ra cai file head -->
<?php $this->load->view('admin/transaction/head', $this->data) ?>

<div class="line"></div>

<div class="wrapper" id="main_transaction">
	<div class="widget">
		<div class="title">
			<span class="titleIcon"><input id="titleCheck" name="titleCheck" type="checkbox"></span>
			<h6>
				Danh sách giao dịch			</h6>
		 	<div class="num f12">Số lượng: <b><?php echo $total_rows?></b></div>
		</div>
		
		<table class="sTable mTable myTable" id="checkAll" width="100%" cellspacing="0" cellpadding="0">
			
			<thead class="filter"><tr><td colspan="7">
				<form class="list_filter form" action="<?php echo admin_url('transaction'); ?>" method="get">
					<table width="80%" cellspacing="0" cellpadding="0"><tbody>
						<tr>
							<td class="label" style="width:40px;"><label for="filter_id">Mã số</label></td>
							<td class="item"><input name="id" value="<?php echo $this->input->get('id')?>" id="filter_id" style="width:55px;" type="text"></td>
							
							
							
							<td style="width:150px">
							<input class="button blueB" value="Lọc" type="submit">
                                     <input class="basic" value="Reset" onclick="window.location.href = '<?php echo admin_url('transaction') ?>'; " type="reset">
							</td>
							
						</tr>
					</tbody></table>
				</form>
			</td></tr></thead>
			
			<thead>
				<tr>
					<td style="width:21px;"><img src="<?php echo public_url('admin/images') ?>/icons/tableArrows.png"></td>
					<td style="width:60px;">Mã số</td>
					<td>Số tiền</td>
					<td>Cổng thanh toán</td>
					<td>Trạng thái</td>
					<td style="width:75px;">Ngày tạo</td>
					<td style="width:120px;">Hành động</td>
				</tr>
			</thead>
			
 			<tfoot class="auto_check_pages">
				<tr>
					<td colspan="7">
						 <div class="list_action itemActions">
								<a href="#submit" id="submit" class="button blueB" url="<?php echo admin_url('transaction/delete_all') ?>">
									<span style="color:white;">Xóa hết</span>
								</a>
						 </div>
							
					     <div class="pagination">
                                 <?php echo $this->pagination->create_links()?>
	               		</div>
					</td>
				</tr>
			</tfoot>
			
			<tbody class="list_item">
                            <?php foreach ($list as $row): ?>
			      	<tr class="row_<?php echo $row->id ?>">
					<td><input name="id[]" value="<?php echo $row->id ?>" type="checkbox"></td>
					
					<td class="textC"><?php echo $row->id?></td>
					
					<td>
					  <?php echo number_format($row->amount)?>đ	
					</td>	
					<td><?php echo $row->payment ?></td>	
					<td><?php 
					if($row->status == 0)
					{
						echo "Chua thanh toan!";
					}elseif($row->status==1) {
						echo "Da thanh toan";
					}
					else
					{
						echo "Thanh toan that bai!";
					}


					 ?></td>

	
					<td class="textC"><?php echo get_date($row->created) ?></td>
					
					<td class="option textC">
				    	
                        <a href="<?php echo admin_url('transaction/view/'.$row->id)?>" target="_blank" class="tipS" title="Xem chi tiết giao dịch">
                            <img src="<?php echo public_url('admin/images') ?>/icons/color/view.png">
						 </a>

					
						
						<a href="<?php echo admin_url('transaction/del/'.$row->id)?>" title="Xóa" class="tipS verify_action">
						    <img src="<?php echo public_url('admin/images') ?>/icons/color/delete.png">
						</a>
					</td>
				</tr>
		        	<?php endforeach;?>		    
		      </tbody>
			
		</table>
	</div>
	
</div>