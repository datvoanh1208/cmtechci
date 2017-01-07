<?php 
Class Contact extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	 function index()
    {
    	//$this->load->view('site/contact/contact');

    	//Hien thi ra view
        $this->data['temp'] = 'site/contact/contact';
        $this->load->view('site/layout',$this->data);
    }
}
