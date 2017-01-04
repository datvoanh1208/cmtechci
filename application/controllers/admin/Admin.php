<?php
class Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }
    
    //Lay danh sach
    
    function index()
    {
        $input = array();
        $list = $this -> admin_model -> get_list($input);
        $this->data['list'] = $list;
        
        $total = $this->admin_model->get_total();
        $this->data['total'] = $total;
        
        //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        $this->data['temp'] = 'admin/admin/index';
        $this->load->view('admin/main',$this->data);
    }
    
    //Kiem tra username da ton tai chua 
     function check_username()
     {
         $username = $this->input->post('username');
         $where = array('username' => $username);
         //Kiem tra xem username da ton tai chua
         if($this->admin_model->check_exists($where))
         {
             //Tra ve thong bao loi
             $this->form_validation->set_message(__FUNCTION__, 'Tai khoan da ton tai');
             return false;
         }
         return true;
     }
    // 
    
    //Them moi quan tri vien
    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required|min_length[8]');
            $this->form_validation->set_rules('username','Tài khoản đăng nhập','required|callback_check_username');
            $this->form_validation->set_rules('password','Mật khẩu','required|min_length[6]');
            $this->form_validation->set_rules('re_password','Nhập lại mật khẩu','matches[password]');
            
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                //themvao co so du lieu
                $name = $this -> input -> post('name');
                $username = $this -> input -> post('username');
                $password = $this -> input -> post('password');
                $data = array(
                    'name' => $name,
                    'username' => $username,
                    'password' => md5($password)
                );
                if($this->admin_model->create($data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                redirect(admin_url('admin'));
            }
        }
        
        $this->data['temp'] = 'admin/admin/add';
        $this->load->view('admin/main',$this->data);
    }
    //
    //Chinh sua thong tin quan tri vien
    //
    function edit()
    {
        
        //Lay id cua quan tri vien can chinh sua
        $id = $this->uri->rsegment('3');
        $id= intval($id);
        
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Lay thong tin cua quan tri vien
        $info = $this->admin_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không ton tai quan tri vien nay');
            redirect(admin_url('admin'));
        }
        $this->data['info'] = $info;
        
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required|min_length[8]');
            $this->form_validation->set_rules('username','Tài khoản đăng nhập','required|callback_check_username');
            
            $password=$this->input->post('password');
            if($password)
            {
            $this->form_validation->set_rules('password','Mật khẩu','required|min_length[6]');
            $this->form_validation->set_rules('re_password','Nhập lại mật khẩu','matches[password]'); 
            }  
            if($this->form_validation->run())
            {
                 //themvao co so du lieu
                $name = $this -> input -> post('name');
                $username = $this -> input -> post('username');
                
                $data = array(
                    'name' => $name,
                    'username' => $username,
                    
                );
                //Neu ma thay doi mat khau thi moi gan du lieu
                if($password)
                {
                    $data['password'] = md5($password);
                }
                if($this->admin_model->update($id,$data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                redirect(admin_url('admin'));
            }
        }
        $this->data['temp'] = 'admin/admin/edit';
        $this->load->view('admin/main',$this->data);
    }
    
    //Ham xoa du lieu 
    
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        //Lay thong tin cua quan tri vien
         $info = $this->admin_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản tri vien nay');
            redirect(admin_url('admin'));
        }
        //Thuc hien xoa
        $this->admin_model->delete($id);
        
        $this->session->set_flashdata('message', 'Xóa thành công');
            redirect(admin_url('admin'));
         
    }
    
    //thuc hien dang xuat
    function logout()
    {
        if($this->session->userdata('login'))
        {
            $this->session->unset_userdata('login');
        }
        redirect(admin_url('login'));
    }
}