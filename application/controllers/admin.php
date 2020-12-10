<?php
class admin extends CI_Controller
{
    
    
    public function welcome()
    {
       
        $this->load->model('loginmodel','ar');
        $this->load->library('pagination');
        $config=[
            'base_url' =>base_url('admin/welcome'),
            'per_page' =>2,
            'total_rows' =>$this->ar->num_rows(),
            'full_tag_open'=>"<ul class='pagination'>",
            'full_tag_close'=>"</ul>",
            'next_tag_open'=>"<li>",
            'next_tag_close'=>"</li>",
            'prev_tag_open'=>"<li>",
            'prev_tag_close'=>"</li>",
            'num_tag_open'=>"<li>",
            'num_tag_close'=>"<li>",
            'cur_tag_open'=>"<li class='active'><a>",
            'cur_tag_close'=>"</a></li>"
        ];
        $this->pagination->initialize($config);
        $articles=$this->ar->articleList($config['per_page'],$this->uri->segment(3));
        $this->load->view('Admin/dashboard',['articles'=>$articles]);
    }
    public function adduser()
    {
        $this->load->view('Admin/add_article');
    }
    public function userValidation()
    {
        $config=[
        'upload_path'=>'./upload/',
        'allowed_types'=>'gif|jpg|png',
        ];
                       
        $this->load->library('upload',$config);
          if($this->form_validation->run('add_article_rules') && $this->upload->do_upload())
          {
              $post=$this->input->post(); 
             
             $data=$this->upload->data();
        
           
        
              $image_path=base_url("upload/".$data['raw_name'].$data['file_ext']);
             
                $post['image_path']=$image_path;
              $this->load->model('loginmodel','useradd');
              if($this->useradd->add_articles($post))
              {
                 $this->session->set_flashdata('msg','Articles added successfully');
                  $this->session->set_flashdata('msg_class','alert-success');
              }
              else
              {
                 $this->session->set_flashdata('msg','Articles not added Please try again!!');
                 $this->session->set_flashdata('msg_class','alert-danger');
              }
              return redirect('admin/welcome');
        }
          else
          {
          $upload_error=$this->upload->display_errors();
        
          $this->load->view('admin/add_article',compact('upload_error'));
          }
        
         }
    public function edituser($id)
    {
        $this->load->model('loginmodel');
        $article=$this->loginmodel->find_article($id);
        $this->load->view('Admin/edit_article',['article'=>$article]);
    }
    public function updatearticle($article_id)
    {
        
        if($this->form_validation->run('add_article_rules'))
        {
            $post=$this->input->post();
            //$articleid=$post['article_id'];
            //unset($articleid);
            $this->load->model('loginmodel','editupdate');
            if($this->editupdate->update_article($article_id,$post))
            {
              $this->session->set_flashdata('msg','Articles Edit successfully');
              $this->session->set_flashdata('msg_class','alert-success');
              
            }
            else{
              $this->session->set_flashdata('msg','Articles not edit pleas try again');
              $this->session->set_flashdata('msg_class','alert-danger');
            }
            return redirect('admin/welcome');
      }
        else
        {
            $this->edituser($article_id);
        }
    }
    public function delarticles()
    {
        $id=$this->input->post('id');
        $this->load->model('loginmodel','delarticle');
        if($this->delarticle->del($id))
        {
            $this->session->set_flashdata('msg','Delete successfully');
            $this->session->set_flashdata('msg_class','alert-success');
        }
        else
        {
            $this->session->set_flashdata('msg','Please try again');
            $this->session->set_flashdata('msg_class','alert-danger');
        }
        return redirect('admin/welcome');
    }
    public function __construct()
    {
        parent::__construct();
        if( ! $this->session->userdata('id'))
        return redirect('login');
    }
    public function logout()
    {
        
        $this->session->unset_userdata('id');
        return redirect('login');
    }
    
    
}

?>