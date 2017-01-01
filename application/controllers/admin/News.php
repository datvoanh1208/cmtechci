<?php 
Class News extends MY_Controller
{
    function __construct() {
        parent::__construct();
        //Load ra file model
        $this->load->model('news_model');
    }
    //Hien thi danh sach bai viet
    function index()
    {
        //Lay tong so luong tat ca cac bai viet trong website
        $total_rows = $this->news_model->get_total();
        $this->data['total_rows'] = $total_rows;
       
        //Load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;
        $config['base_url'] = admin_url('news/index');
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['next_link'] = 'Trang ke tiep';
        $config['prev_link'] = 'Trang truoc';
        //Khoi tao cac cau hinh phan trang
        $this->pagination->initialize($config);

        $segment = $this->uri->segment(4);
        $segment = intval($segment);

        
        $input = array();
        $input['limit'] = array($config['per_page'], $segment);
        
        //Kiem tra co thuc hien loc du lieu  khong
        $id = $this->input->get('id');
        $id = intval($id);
        $input['where'] = array();
        if($id > 0)
        {
            $input['where']['id'] = $id;
        }
        $title = $this->input->get('title');
        if($title)
        {
            $input['like'] = array('title', $title);
        }
        
        
        //Lay danh sach bai viet
        $list = $this->news_model->get_list($input);
        $this->data['list'] = $list;
        
        
         //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        //load view
        $this->data['temp'] = 'admin/news/index';
        $this->load->view('admin/main', $this->data);
    }
    
    //Them bai viet moi
    function add()
    {
       
        
         //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('title','Tiêu đề bài viết','required');
            $this->form_validation->set_rules('content','Nội dung bài viết','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                
                //Lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                
                $upload_path = './upload/news';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
                
                //Luu du lieu can them
                $data = array(
                    'title' => $this->input->post('title'), 
                    'image_link' => $image_link,
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                    'created' => now(),
                );
                
                //Them moi co so du lieu
                if($this->news_model->create($data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                redirect(admin_url('news'));
            }
        }
        
        //load view
        $this->data['temp'] = 'admin/news/add';
        $this->load->view('admin/main', $this->data);
    }
    
    //Chinh sua bai viet
    function edit()
    {
        $id = $this->uri->rsegment('3');
        $news = $this -> news_model -> get_info($id);
        if(!$news)
        {
            //Tao ra noi dung thong bao
            $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
            redirect(admin_url('news'));
        }
        $this->data['news'] = $news;
    
        
        
        
         //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('title','Tiêu đề bài viết','required');
            $this->form_validation->set_rules('content','Nội dung bài viết','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                
                //Lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                
                $upload_path = './upload/news';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
                
                
              //Luu du lieu can them
                $data = array(
                    'title' => $this->input->post('title'), 
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                    'created' => now(),
                );
                if($image_link !='')
                {
                    $data['image_link'] = $image_link;
                }
               

                
                //Them moi co so du lieu
                if($this->news_model->update($news->id,$data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                redirect(admin_url('news'));
            }
        }
        
        //load view
        $this->data['temp'] = 'admin/news/edit';
        $this->load->view('admin/main', $this->data);
    }
    
    
    //Xoa du lieu
    function del()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Xóa bài viết thành công');
        redirect(admin_url('news'));
        
    }

    //Xoa nhieu bai viet
    function delete_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
        {
            $this->_del($id);
        }
    }

    //Xoa bai viet
    private function _del($id)
    {
        $news = $this->news_model->get_info($id);
        if(!$news)
        {
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Không tồn tại bài viết này');
        redirect(admin_url('news'));
        }
        //Thực hiện xóa bài viết
        $this->news_model->delete($id);
        //Xóa các ảnh của bài viết
        $image_link = './upload/news/'.$news->image_link;
        if(file_exists($image_link))
        {
            unlink($image_link);
        }
        
    }
}