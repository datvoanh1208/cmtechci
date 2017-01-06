<?php
class User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }
    
    //Lay danh sach
    
    function index()
    {
        $input = array();
        $list = $this -> user_model -> get_list($input);
        $this->data['list'] = $list;
        
        $total = $this->user_model->get_total();
        $this->data['total'] = $total;
        
        //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        $this->data['temp'] = 'admin/user/index';
        $this->load->view('admin/main',$this->data);
    }
    
    //Kiem tra username da ton tai chua 
     function check_username()
     {
         $username = $this->input->post('username');
         $where = array('username' => $username);
         //Kiem tra xem username da ton tai chua
         if($this->user_model->check_exists($where))
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
            $this->form_validation->set_rules('email','Email','required|valid_email');
            
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                //them vao co so du lieu
                $name = $this -> input -> post('name');
                $username = $this -> input -> post('email');
                
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    
                );
                if($this->user_model->create($data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                redirect(user_url('user'));
            }
        }
        
        $this->data['temp'] = 'admin/user/add';
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
        $info = $this->user_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không ton tai quan tri vien nay');
            redirect(user_url('user'));
        }
        $this->data['info'] = $info;
        
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required|min_length[8]');
            $this->form_validation->set_rules('email','Email','required|valid_email');
            
            
           
            if($this->form_validation->run())
            {
                 //themvao co so du lieu
                $name = $this -> input -> post('name');
                $email = $this -> input -> post('email');
                
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    
                );
                //Neu ma thay doi mat khau thi moi gan du lieu
                
                if($this->user_model->update($id,$data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                redirect(admin_url('user'));
            }
        }
        $this->data['temp'] = 'admin/user/edit';
        $this->load->view('admin/main',$this->data);
    }
    
    //Ham xoa du lieu 
    
    function delete()
    {
        $id = $this->uri->rsegment('3');
        $id = intval($id);
        //Lay thong tin cua quan tri vien
         $info = $this->user_model->get_info($id);
        if(!$info)
        {
            $this->session->set_flashdata('message', 'Không tồn tại quản tri vien nay');
            redirect(user_url('user'));
        }
        //Thuc hien xoa
        $this->user_model->delete($id);
        
        $this->session->set_flashdata('message', 'Xóa thành công');
            redirect(user_url('user'));
         
    }
    
    //thuc hien dang xuat
    function logout()
    {
        if($this->session->userdata('login'))
        {
            $this->session->unset_userdata('login');
        }
        redirect(user_url('login'));
    }
}