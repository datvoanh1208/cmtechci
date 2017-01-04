<?php 
Class Cart extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
	}

	//Phuong thuc them san pham vao gio hang
	function add()
	{
		//Lay ra san pham muon them vao gio hang
		$this->load->model('product_model');
		$id = $this->uri->rsegment(3);
		$product = $this->product_model->get_info($id);
		if(!$product)
		{
			redirect();
		}
		//Tong so san pham
		$qty = 1;
		$price = $product->price;
		if($product->discount>0)
		{
			$price = $product->price - $product->discount;
		}
		//Thong tin them vao gio
		$data = array();
		$data['id'] = $product->id;
		$data['qty'] = $qty;
		$data['name'] = url_title($product->name);
		$data['image_link'] = $product->image_link;
		$data['price'] = $price;
		$this->cart->insert($data);
		
		//Chuyen sang trang danh sach san pham trong gio hang
		redirect(base_url('cart'));
	}

	//Hien thi ra danh sach san pham trong gio hang
	function index()
	{
		//Thong tin gio hang
		$carts = $this->cart->contents();

		//Tong so san pham co trong gio hang
		$total_items = $this->cart->total_items();

		$this->data['carts'] = $carts;
		$this->data['total_items'] = $total_items;

		$this->data['temp'] = 'site/cart/index';
		$this->load->view('site/layout', $this->data);
	}

	//Cap nhat gio hang
	function update()
	{
		//Thong tin gio hang
		$carts = $this->cart->contents();

		foreach($carts as $key => $row)
		{
			//Tong so luong san pham
			$total_qty = $this->input->post('qty_'.$row['id']);
			$data = array();
			$data['rowid'] = $key;
			$data['qty']=$total_qty;
			$this->cart->update($data); 
		}
		//Chuyen sang trang danh sach san pham trong gio hang
		redirect(base_url('cart'));

	}
	//Xoa cac sp trong gio hang
	function del()
	{
		$id = $this->uri->rsegment(3);
		$id = intval($id);
		//Truong hop xoa 1 sp nao do trong gio hang
		if($id > 0)
		{
			//Thong tin gio hang
			$carts = $this->cart->contents();
			foreach($carts as $key => $row)
			{
				//Tong so luong san pham
				if($row['id'] == $id)
				{
				$data = array();
				$data['rowid'] = $key;
				$data['qty']=0;
				$this->cart->update($data);
				}
				 
			}
		}else
		{
			//Xoa toan bo gio hang
			$this->cart->destroy();
		}
		//Chuyen sang trang danh sach san pham trong gio hang
		redirect(base_url('cart'));
	}
}