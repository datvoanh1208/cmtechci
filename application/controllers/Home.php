<?php
class Home extends MY_Controller
{
    function index()
    {
    	//Lay danh sach slide
    	$this->load->model('slide_model');
    	$slide_list = $this->slide_model->get_list();
    	$this->data['slide_list'] = $slide_list;

   		//Lay danh sach san pham moi
    	$this->load->model('product_model');
    	$input = array();
    	$input['limit'] = array(3, 0);
    	$product_newest = $this->product_model->get_list($input);
    	$this->data['product_newest'] = $product_newest;

    	$input['order'] = array('buyed', 'DESC');
    	$product_buy = $this->product_model->get_list($input);
		$this->data['product_buy'] = $product_buy;
        
        //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 

        
        $this->data['temp'] = 'site/home/index';
        $this->load->view('site/layout', $this->data);
    }
}
