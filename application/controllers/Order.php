<?php 
Class Order extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
	}
	//Lấy thông tin của khách hàng 
	function checkout()
	{
		//Thong tin gio hang
		$carts = $this->cart->contents();

		//Tong so san pham co trong gio hang
		$total_items = $this->cart->total_items();
		

		if($total_items <= 0)
		{
			redirect();
		}
		//Tong so tien can thanh toan
		$total_amount = 0;
		foreach($carts as $row)
		{
			$total_amount = $total_amount + $row['subtotal'];
		}
		$this->data['total_amount'] = $total_amount;


		//Neu thanh vien da dang nhap thi lay thong tin cua thanh vien
		$user_id = 0;
		$user = '';
		if($this->session->userdata('user_id_login'))
    	{
    		//Lay thong tin cua thanh vien
    		$user_id = $this->session->userdata('user_id_login');
    		$user = $this->user_model->get_info($user_id);
    	}
    	$this->data['user'] = $user;    	

    	$this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
        	$this->form_validation->set_rules('email','Email nhận hàng','required|valid_email');
            $this->form_validation->set_rules('name','Tên','required|min_length[8]');
            $this->form_validation->set_rules('phone','Số điện thoại','required');
            $this->form_validation->set_rules('message','Ghi chú','required');
            $this->form_validation->set_rules('payment','Cổng thanh toán','required');
            
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
            	$payment = $this->input->post('payment');
                //themvao co so du lieu
                $data = array(
                	'status' => 0, //Trang thai chua thanh toan
                	'user_id' => $user_id, //id thanh vien mua hang neu da dang nhap
                	'user_email' => $this->input->post('email'),
                    'user_name' => $this->input->post('name'),
                    'user_phone' => $this->input->post('phone'),
                    'message' => $this->input->post('message'), //ghi chu khi mua hang
                    'amount' => $total_amount, //Tong so tien can thanh toan
                    'payment' => $payment,//cong thanh toan
                    'created' => now(),
                );
                //Them du lieu vao bang transaction
               $this->load->model('transaction_model');
               $this->transaction_model->create($data);
               $transaction_id = $this->db->insert_id(); //Lay ra id cua giao dich vua them vao

               //Them vao bang order (chi tiet don hang)
               $this->load->model('order_model');
               foreach ($carts as $row) 
               {
               		$data = array(
               			'transaction_id' => $transaction_id,
               			'product_id' => $row['id'],
               			'qty' => $row['qty'],
               			'amount' => $row['subtotal'],
               			'status' => '0',
               		);
               		$this->order_model->create($data);
               }
               //Xoa toan bo gio hang
				$this->cart->destroy();
				if($payment == 'offline')
				{
					//Tao ra noi dung thong bao
              	 	 $this->session->set_flashdata('message', 'Bạn đã đặt hàng thành công, chúng tôi sẽ kiểm tra và gửi hàng cho bạn!');
               		//Chuyen toi trang danh sach quan tri vien
               		 redirect(site_url());
				} elseif (in_array($payment, array('nganluong', 'baokim')))//Neu thanh toan bang cong thanh toan
				{

				} 
				
            }
        }

		//Hien thi ra view
        $this->data['temp'] = 'site/order/checkout';
        $this->load->view('site/layout',$this->data);
	}
}