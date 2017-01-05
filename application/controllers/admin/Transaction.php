
<?php
Class Transaction extends My_Controller
{
    function __construct() {
        parent::__construct();
        //Load ra file model
        $this->load->model('transaction_model');
    }
    //Hien thi danh sach giao dich
    function index()
    {
        //Lay tong so luong tat ca cac giao dich trong website
        $total_rows = $this->transaction_model->get_total();
        $this->data['total_rows'] = $total_rows;
       
        //Load ra thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $total_rows;
        $config['base_url'] = admin_url('transaction/index');
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
        
        
       
        
        //Lay danh sach giao dich
        $list = $this->transaction_model->get_list($input);
        $this->data['list'] = $list;
        
        
       
         //Lay noi dung cua bien message
        $message = $this->session->flashdata('message');
        $this->data['message'] = $message; 
        
        //load view
        $this->data['temp'] = 'admin/transaction/index';
        $this->load->view('admin/main', $this->data);
    }

      //Xoa du lieu
    function del()
    {
        $id = $this->uri->rsegment(3);
        $this->_del($id);
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Xóa giao dịch thành công');
        redirect(admin_url('transaction'));
        
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
        $transaction = $this->transaction_model->get_info($id);
        if(!$transaction)
        {
        //Tao ra noi dung thong bao
        $this->session->set_flashdata('message', 'Không tồn tại giao dịch này');
        redirect(admin_url('transaction'));
        }
        //Thực hiện xóa giao dịch
        
    }
}