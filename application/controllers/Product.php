<?php 
Class Product extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		//Load model san pham
		$this->load->model('product_model');
	}
	
	//Hien thi danh sach san pham theo danh muc
	function catalog()
	{
		//Lay id cua the loai
		$id = intval($this->uri->rsegment(3));
		//Lay ra thong tin cua the loai
		$this->load->model('catalog_model');
		$catalog = $this->catalog_model->get_info($id);
		if(!$catalog)
		{
			redirect();
		}
		$this->data['catalog'] = $catalog;
		$input = array();
		//Kiem tra xem day la danh muc con hay danh muc cha
		if($catalog -> parent_id == 0)
		{
			$input_catalog = array();
			$input_catalog['where'] = array('parent_id' => $id);
			$catalog_subs = $this->catalog_model->get_list($input_catalog);
			if(!empty($catalog_subs)) //Neu danh muc hien tai co danh muc con
			{
				$catalog_subs_id = array();
				foreach($catalog_subs as $sub)
				{
					$catalog_subs_id[] = $sub->id;
				}
				//Lay tat ca san pham thuoc cac danh muc con do
				$this->db->where_in('catalog_id', $catalog_subs_id);
			}else
			{
				$input['where'] = array('catalog_id' => $id);
			}
		}
		else
		{
				$input['where'] = array('catalog_id' => $id);
		}


		
		
		//Lay ra danh sach san pham thuoc danh muc do
		//Lay tong so luong tat ca cac san pham trong website
        $total_rows = $this->product_model->get_total($input);
        $this->data['total_rows'] = $total_rows;
       
        //Load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;
        $config['base_url'] = base_url('product/catalog/'.$id);
        $config['per_page'] = 6;
        $config['uri_segment'] = 4;
        $config['next_link'] = 'Trang ke tiep';
        $config['prev_link'] = 'Trang truoc';
        //Khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        
        
        $input['limit'] = array($config['per_page'], $segment);
        
         //Lay danh sach san pham
        $list = $this->product_model->get_list($input);
        $this->data['list'] = $list;

        //Hien thi ra view
        $this->data['temp'] = 'site/product/catalog';
        $this->load->view('site/layout',$this->data);
	}

	//Xem chi tiet san pham
	function view()
	{
		//Lay id san pham muon xem
		$id = $this->uri->rsegment(3);
		$product = $this->product_model->get_info($id);
		if(!$product) redirect();
		$this->data['product'] = $product;

		//Danh sach cac anh san pham kem theo
		$image_list = @json_decode($product->image_list);
		$this->data['image_list'] = $image_list;
		
		//Cap nhat lai luot xem cua san pham
		$data = array();
		$data['view'] = $product->view+1;
		$this->product_model->update($product->id, $data);

		//Lay thong tin cua danh muc san pham
		$catalog = $this->catalog_model->get_info($product->catalog_id);
		$this->data['catalog'] = $catalog;

		//Hien thi ra view
        $this->data['temp'] = 'site/product/view';
        $this->load->view('site/layout',$this->data);
	}

	//Tim kiem theo ten san pham
	function search()
	{

		
		if($this->uri->rsegment('3') == 1)
		{
			//Lay du lieu tu autocomplete
			$key = $this->input->get('term');
		}else
		{
			$key = $this->input->get('key-search');
		}
		$this->data['key'] = trim($key);
		$input = array();
		$input['like'] = array('name', $key);
		$list = $this->product_model->get_list($input);
		$this->data['list'] = $list;

		if($this->uri->rsegment('3') == 1)
		{
			//Xu ly autocomplete
			$result = array();
			foreach($list as $row)
			{
				$item = array();
				$item['id'] = $row->id;
				$item['label'] = $row->name;
				$item['value'] = $row->name;
				$result[] = $item;
			}
			//Du lieu tra ve duoi dang json
			die(json_encode($result));

		}else
		{
		//load view
        $this->data['temp'] = 'site/product/search';
        $this->load->view('site/layout',$this->data);
		}
		
	}
	//Tim kiem theo gia sp
	function search_price()
	{
		$price_from = intval($this->input->get('price_from'));
		$price_to = intval($this->input->get('price_to'));
		$this->data['price_from'] = $price_from;
		$this->data['price_to'] = $price_to; 

		//Loc theo gia
		$input = array();
		$input['where'] = array('price >= ' => $price_from, 'price <=' => $price_to);
		$list = $this->product_model->get_list($input);

		$this->data['list'] = $list;

		//load view
        $this->data['temp'] = 'site/product/search_price';
        $this->load->view('site/layout',$this->data);
	}
}