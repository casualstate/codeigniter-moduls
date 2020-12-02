<?php
class Blog extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Blog_model');
        $this->load->helper('url');
        $this->load->library('pagination');
    }

    public function index()
    {
        //config for pagination
		$config['base_url'] = site_url('blog/index');
		$config['total_rows'] = $this->db->count_all('blog');
        $config['per_page'] = 4;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);	


        $data['blogs']=$this->Blog_model->getBlogs($config['per_page'],$from);
        $this->load->view('blogs',$data);
    }

    public function detail($url)
    {
        $data['blogs']=$this->Blog_model->getSingleBlog('url',$url);
        $this->load->view('detail',$data);
    }

    public function add()
    {
        if($this->input->post())
        {
            $data['title']=$this->input->post('title');
            $data['content']=$this->input->post('content');
            $data['url']=$this->input->post('url');
            $id = $this->Blog_model->insertBlog($data);
            if($id){
                echo "Data berhasil disimpan";
                redirect('/');
            }
            else{
                echo "Data gagal disimpan";
            }
        }
        $this->load->view('form_add');
    }

    public function edit($id)
    {
        $data['blog']=$this->Blog_model->getSingleBlog('id',$id);

        if($this->input->post())
        {
            $post['title'] =$this->input->post('title');
            $post['content']=$this->input->post('content');
            $post['url'] =$this->input->post('url');
            $id =$this->Blog_model->updateBlog($id,$post);
            if($id){
                echo "Data berhasil disimpan";
                redirect('/');
            }
            else{
                echo "Data gagal disimpan";
            }
        }
        $this->load->view('form_edit',$data);
    }

    public function delete($id)
    {
        $this->Blog_model->deleteBlog($id);
        redirect('/');
    }

}
