<?php 
Class My_Controller extends CI_Controller
{
    //Bien gui da lieu sang ben view
    public $data = array();
    function __construct() {
        //Ke thua tu CI_Controller
        parent::__construct();
        
        $controller = $this->uri->segment(1);
        switch($controller)
        {
            case 'admin' :
            {
                $this -> load -> helper('admin');
                $this->_check_login();
                //Xu ly cac du lieu khi truy cap vao trang admin
                break;
            }
            default: 
            {
                //Xu ly du lieu o trang ngoai
            }
        }
    }
//    Kiem tra trang thai dang nhap cua admin
    private function _check_login()
    {
        $controller = $this->uri->rsegment('1');
        $controller = strtolower($controller);
        
        $login = $this->session->userdata('login');
        //Neu ma chua dang nhap, ma truy cap 1 controller khac login
        if(!$login && $controller != 'login')
        {
            redirect(admin_url('login'));
        }
        //Neu ma damin da dang nhap thi khong cho phep vao login nua
        if($login && $controller == 'login')
        {
            redirect(admin_url('home'));
        }
    }
}