<?php 
Class Slide extends MY_Controller
{
    function __construct() {
        parent::__construct();
        //Load ra file model
        $this->load->model('slide_model');
    }
    //Hien thi danh sach slide
    function index()
    {
        //Lay tong so luong tat ca cac slide trong website
        $total_rows = $this->slide_model->get_total();
        $this->data['total_rows'] = $total_rows;
       

        
        $input = array();
      

        //Lay danh sach slide
        $list = $this->slide_model->get_list($input);
        $this->data['list'] = $list;
        
        
         //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        //load view
        $this->data['temp'] = 'admin/slide/index';
        $this->load->view('admin/main', $this->data);
    }
    
    //Them slide moi
    function add()
    {
       
        
         //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên slide','required');
            
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                
                //Lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                
                $upload_path = './upload/slide';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
                
                //Luu du lieu can them
                $data = array(
                    'name' => $this->input->post('name'), 
                    'image_link' => $image_link,
                    'link' => $this->input->post('link'),
                    'info' => $this->input->post('info'),
                    'sort_order' => $this->input->post('sort_order'),
                );
                
                //Them moi co so du lieu
                if($this->slide_model->create($data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                redirect(admin_url('slide'));
            }
        }
        
        //load view
        $this->data['temp'] = 'admin/slide/add';
        $this->load->view('admin/main', $this->data);
    }
    
    //Chinh sua slide
    function edit()
    {
        $id = $this->uri->rsegment('3');
        $slide = $this -> slide_model -> get_info($id);
        if(!$slide)
        {
            //Tao ra noi dung thong bao
            $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
            redirect(admin_url('slide'));
        }
        $this->data['slide'] = $slide;
    
        
        
        
         //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên slide','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                
                //Lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                
                $upload_path = './upload/slide';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
                
                
              //Luu du lieu can them
                $data = array(
                    'name' => $this->input->post('name'), 
   
                    'link' => $this->input->post('link'),
                    'info' => $this->input->post('info'),
                    'sort_order' => $this->input->post('sort_order'),
                );
                if($image_link !='')
                {
                    $data['image_link'] = $image_link;
                }
               

                
                //Them moi co so du lieu
                if($this->slide_model->update($slide->id,$data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                redirect(admin_url('slide'));
            }
        }
        
        //load view
        $this->data['temp'] = 'admin/slide/edit';
        $this->load->view('admin/main', $this->data);
    }
    
    
    //Xoa du lieu
    function del()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Xóa bài viết thành công');
        redirect(admin_url('slide'));
        
    }

    //Xoa nhieu slide
    function delete_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
        {
            $this->_del($id);
        }
    }

    //Xoa slide
    private function _del($id)
    {
        $slide = $this->slide_model->get_info($id);
        if(!$slide)
        {
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
        redirect(admin_url('slide'));
        }
        //Thực hiện xóa bài viết
        $this->slide_model->delete($id);
        //Xóa các ảnh của bài viết
        $image_link = './upload/slide/'.$slide->image_link;
        if(file_exists($image_link))
        {
            unlink($image_link);
        }
        
    }
}