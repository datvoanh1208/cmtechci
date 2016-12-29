<?php
Class Catalog extends My_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('catalog_model');
    }
    //Lay danh sach danh muc san pham
    function index()
    {
        $list = $this->catalog_model->get_list();
        $this->data['list'] = $list;
        
        
        //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        //load view
        $this->data['temp'] = 'admin/catalog/index';
        $this->load->view('admin/main', $this->data);
    }
    //Them moi du lieu
    function add()
    {
        //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                //them vao co so du lieu
                $name = $this -> input -> post('name');
                $parent_id = $this -> input -> post('parent_id');
                $sort_order = $this -> input -> post('sort_order');
                
                //Luu du lieu can them
                $data = array(
                    'name' => $name,
                    'parent_id' => $parent_id,
                    'sort_order' => intval($sort_order)
                );
                
                //Them moi co so du lieu
                if($this->catalog_model->create($data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                redirect(admin_url('catalog'));
            }
        }
        
        //Lay danh sach danh muc cha
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $list = $this->catalog_model->get_list($input);
        $this->data['list'] = $list;
        
        
        $this->data['temp'] = 'admin/catalog/add';
        $this->load->view('admin/main',$this->data);
    }
    
    
    //chinh sua du lieu
    function edit()
    {
        //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        $id = $this->uri->rsegment(3);
        $info = $this->catalog_model->get_info($id);
       if(!$info)
       {
           //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Không tồn tại danh mục này');
        redirect(admin_url('catalog'));
       }
       $this->data['info'] = $info;
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                //them vao co so du lieu
                $name = $this -> input -> post('name');
                $parent_id = $this -> input -> post('parent_id');
                $sort_order = $this -> input -> post('sort_order');
                
                //Luu du lieu can them
                $data = array(
                    'name' => $name,
                    'parent_id' => $parent_id,
                    'sort_order' => intval($sort_order)
                );
                
                //Them moi co so du lieu
                if($this->catalog_model->update($id, $data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Sửa dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Sửa không thành công');
                }
                redirect(admin_url('catalog'));
            }
        }
        
        //Lay danh sach danh muc cha
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $list = $this->catalog_model->get_list($input);
        $this->data['list'] = $list;
        
        
        $this->data['temp'] = 'admin/catalog/edit';
        $this->load->view('admin/main',$this->data);
    }
    //Xoa danh muc
    function delete()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);

       //Xoa du lieu
       $this->catalog_model->delete($id);
       //Tao ra noi dung thong tin
       $this->session->set_flashdata('message', 'Xóa thành công');
       redirect(admin_url('catalog'));
    }
    //Xoa nhieu danh muc san pham
    function delete_all()
    {
        $ids = $this->input->post($id);
        foreach($ids as $id)
        {
             $this->_del($id, false);  
        }
    }
    //Thuc hien xoa
    private function _del($id, $redirect = true)
    {
          $info = $this->catalog_model->get_info($id);
       if(!$info)
       {
           //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Không tồn tại danh mục này');
        if($redirect)
        {
            redirect(admin_url('catalog'));
        }
        else
        {
            return false;
        }
       }
       //Kiem tra xem danh muc nay co san pham khong
       $this->load->model('product_model');
       $product = $this->product_model->get_info_rule(array('catalog_id' => $id), 'id');
       if($product)
       {
            //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Danh mục' .$info->name. 'có chứa sản phẩm, bạn cần xóa các sản phẩm trước khi xóa danh mục');
        if($redirect)
        {
            redirect(admin_url('catalog'));
        }
        else
        {
            return false;
        }
       }
    }
}

