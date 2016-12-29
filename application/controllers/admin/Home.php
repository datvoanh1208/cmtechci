<?php
Class Home extends My_Controller
{
    function index()
    {
        $this->data['temp'] = 'admin/home/index';
        $this->load->view('admin/main', $this->data);
        
        
    }
}

