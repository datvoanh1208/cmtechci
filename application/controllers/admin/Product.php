
<?php
Class Product extends My_Controller
{
    function __construct() {
        parent::__construct();
        //Load ra file model
        $this->load->model('product_model');
    }
    //Hien thi danh sach san pham
    function index()
    {
        //Lay tong so luong tat ca cac san pham trong website
        $total_rows = $this->product_model->get_total();
        $this->data['total_rows'] = $total_rows;
       
        //Load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;
        $config['base_url'] = admin_url('product/index');
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
        $name = $this->input->get('name');
        if($name)
        {
            $input['like'] = array('name', $name);
        }
        
        $catalog_id = $this->input->get('catalog');
        $catalog_id = intval($catalog_id);
        if($catalog_id > 0)
        {
            $input['where']['catalog_id'] = $catalog_id;
        }
        
        //Lay danh sach san pham
        $list = $this->product_model->get_list($input);
        $this->data['list'] = $list;
        
        
        //Lay danh sach danh muc san pham
        $this->load->model('catalog_model');
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $catalogs = $this->catalog_model->get_list($input);
        foreach($catalogs as $row)
        {
            $input['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input);
            $row -> subs = $subs;
        }
        
        $this->data['catalogs'] = $catalogs;
        
         //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        //load view
        $this->data['temp'] = 'admin/product/index';
        $this->load->view('admin/main', $this->data);
    }
    
    //Them san pham moi
    function add()
    {
        //Lay danh sach danh muc san pham
        $this->load->model('catalog_model');
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $catalogs = $this->catalog_model->get_list($input);
        foreach($catalogs as $row)
        {
            $input['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input);
            $row -> subs = $subs;
        }
        
        $this->data['catalogs'] = $catalogs;
        
         //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required');
            $this->form_validation->set_rules('catalog','Thể loại','required');
            $this->form_validation->set_rules('price','Giá','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                //them vao co so du lieu
                $name = $this -> input -> post('name');
                $catalog_id = $this -> input -> post('catalog');
                $price = $this->input->post('price');
                $price = str_replace(',', '', $price);
                
                
                $discount=$this->input->post('discount');
                $discount = str_replace(',', '', $discount);
                //Lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                
                $upload_path = './upload/product';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
                //upload cac anh kem theo
                $image_list = array();
                $image_list = $this->upload_library->upload_file($upload_path, 'image_list');
                $image_list = json_encode($image_list);
                //Luu du lieu can them
                $data = array(
                    'name' => $name,
                    'catalog_id' => $catalog_id,
                    'price' => $price,
                    'image_link' => $image_link,
                    'image_list' => $image_list,
                    'discount' => $discount,
                    'warranty' => $this->input->post('warranty'),
                    'gifts' => $this->input->post('gifts'),
                    'site_title' => $this->input->post('site_title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                    'created' => now(),
                );
                
                //Them moi co so du lieu
                if($this->product_model->create($data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Thêm mới dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không thêm được');
                }
                redirect(admin_url('product'));
            }
        }
        
        //load view
        $this->data['temp'] = 'admin/product/add';
        $this->load->view('admin/main', $this->data);
    }
    
    //Chinh sua san pham
    function edit()
    {
        $id = $this->uri->rsegment('3');
        $product = $this -> product_model -> get_info($id);
        if(!$product)
        {
            //Tao ra noi dung thong bao
            $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
            redirect(admin_url('product'));
        }
        $this->data['product'] = $product;
    
        
        
        //Lay danh sach danh muc san pham
        $this->load->model('catalog_model');
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $catalogs = $this->catalog_model->get_list($input);
        foreach($catalogs as $row)
        {
            $input['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input);
            $row -> subs = $subs;
        }
        
        $this->data['catalogs'] = $catalogs;
        
         //Load thu vien validate du lieu
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        //Neu ma co du lieu post len thi kiem tra
        if($this->input->post())
        {
            $this->form_validation->set_rules('name','Tên','required');
            $this->form_validation->set_rules('catalog','Thể loại','required');
            $this->form_validation->set_rules('price','Giá','required');
         
            //nhap lieu chinh xac
            if($this->form_validation->run())
            {
                //them vao co so du lieu
                $name = $this -> input -> post('name');
                $catalog_id = $this -> input -> post('catalog');
                $price = $this->input->post('price');
                $price = str_replace(',', '', $price);
                
                $discount=$this->input->post('discount');
                $discount = str_replace(',', '', $discount);
                //Lay ten file anh minh hoa duoc upload len
                $this->load->library('upload_library');
                
                $upload_path = './upload/product';
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                
                $image_link = '';
                if(isset($upload_data['file_name']))
                {
                    $image_link = $upload_data['file_name'];
                }
                
                
                
                //upload cac anh kem theo
                $image_list = array();
                $image_list = $this->upload_library->upload_file($upload_path, 'image_list');
                $image_list_json = json_encode($image_list);
                //Luu du lieu can them
                $data = array(
                    'name' => $name,
                    'catalog_id' => $catalog_id,
                    'price' => $price,
                   
                    'discount' => $discount,
                    'warranty' => $this->input->post('warranty'),
                    'gifts' => $this->input->post('gifts'),
                    'site_title' => $this->input->post('site_title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'content' => $this->input->post('content'),
                );
                if($image_link !='')
                {
                    $data['image_link'] = $image_link;
                }
                if(!empty($image_list))
                {
                    $data['image_list'] = $image_list_json;
                }
                
                //Them moi co so du lieu
                if($this->product_model->update($product->id,$data))
                {
                    //Tao ra noi dung thong bao
                    $this->session->set_flashdata('message', 'Cập nhật dữ liệu thành công');
                }
                else 
                {
                    $this->session->set_flashdata('message', 'Không cập nhật được');
                }
                redirect(admin_url('product'));
            }
        }
        
        //load view
        $this->data['temp'] = 'admin/product/edit';
        $this->load->view('admin/main', $this->data);
    }
    
    
    //Xoa du lieu
    function del()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Xóa sản phẩm thành công');
        redirect(admin_url('product'));
        
    }

    //Xoa nhieu san pham
    function delete_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
        {
            $this->_del($id);
        }
    }

    //Xoa san pham
    private function _del($id)
    {
        $product = $this->product_model->get_info($id);
        if(!$product)
        {
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Không tồn tại sản phẩm này');
        redirect(admin_url('product'));
        }
        //Thực hiện xóa sản phẩm
        $this->product_model->delete($id);
        //Xóa các ảnh của sản phẩm
        $image_link = './upload/product/'.$product->image_link;
        if(file_exists($image_link))
        {
            unlink($image_link);
        }
        //Xóa các ảnh kèm theo của sản phẩm
        $image_list = json_decode($product->image_list);
        if(is_array($image_list))
        {
            foreach ($image_list as $img)
            {
                $image_link = './upload/product/'.$img;
                if(file_exists($image_link))
                {
                    unlink($image_link);
                }
            }
        }
    }
}