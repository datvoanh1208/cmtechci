<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
   		<h2>Thông tin giỏ hàng (Có <?php echo $total_items ?> sản phẩm)</h2>
 	</div>
    	 <div class="box-content-center product"><!-- The box-content-center -->
    	 <table>
    	 	<thead>
    	 		<th>Sản phẩm</th>
    	 		<th>Giá bán</th>
    	 		<th>Số lượng</th>
    	 		<th>Tổng số</th>
    	 		<th>Xóa</th>
    	 	</thead>
    	 	<tbody>
    	 		<?php foreach ($carts as $row):?>
    	 			<td>
    	 				<?php echo $row['name'];?>
    	 			</td>
    	 			<td>
    	 				<?php echo number_format($row['price']);?>đ
    	 			</td>
    	 			<td>
    	 				<?php echo $row['qty'];?>
    	 			</td>
    	 			<td>
    	 				<?php echo $row['subtotal'];?>
    	 			</td>
    	 			<td>
    	 				<a href="">Xóa</a>
    	 			</td>
    	 		<?php endforeach;?>
    	 	</tbody>
    	 </table>
     	</div>
</div>