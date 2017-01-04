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
                //Lay danh sach danh muc san pham
                $this->load->model('catalog_model');
                $input = array();
                $input['where'] = array('parent_id' => 0);
                $catalog_list = $this->catalog_model->get_list($input);
                foreach($catalog_list as $row)
                {
                    $input['where'] = array('parent_id' => $row->id);
                    $subs = $this->catalog_model->get_list($input);
                    $row -> subs = $subs; 
                }
                $this->data['catalog_list'] = $catalog_list;
                
                //Lay danh sach bai viet moi
                $this->load->model('news_model');
                $input = array();
                $input = array(5,0);
                $news_list = $this->news_model->get_list($input);
                $this->data['news_list'] = $news_list; 
               
                //Kiem tra xem thanh vien da dang nhap hay chua
                $user_id_login = $this->session->userdata('user_id_login');
                $this->data['user_id_login'] = $user_id_login;
                //Neu da dang nhap thi lay thong tin cua thanh vien
                if($user_id_login)
                {
                    $this->load->model('user_model');
                    $user_info = $this->user_model->get_info($user_id_login);
                    $this->data['user_info'] = $user_info;
                }

                //Goi toi thu vien
                $this->load->library('cart');
                $this->data['total_items'] = $this->cart->total_items();
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