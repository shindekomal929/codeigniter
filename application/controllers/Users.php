<?php
class Users extends CI_Controller
{
    public function index()
    {
        log_message('error','error message in this line');
        log_message('debug','debug message in this line');
        log_message('info','info message in this line');
        $this->load->model('loginmodel','ar');
        $this->load->library('pagination');
        $config=[
       'base_url' => base_url('Users/index'),
       'per_page' =>2,
       'total_rows' => $this->ar->all_articles_count(),
       'full_tag_open'=>"<ul class='pagination'>",
       'full_tag_close'=>"</ul>",
       'next_tag_open' =>"<li>",
       'next_tag_close' =>"</li>",
       'prev_tag_open' =>"<li>",
       'prev_tag_close' =>"</li>",
       'num_tag_open' =>"<li>",
       'num_tag_close' =>"<li>",
       'cur_tag_open' =>"<li class='active'><a>",
       'cur_tag_close' =>"</a></li>"

];


 $this->pagination->initialize($config);
$articles=$this->ar->all_articleList($config['per_page'],$this->uri->segment(3));
 $this->load->view('users/HomePage',compact('articles')); 
    }
    public function register()
    {
        $this->load->view('Admin/register');
    }
    public function sendemail()
    {
        $this->form_validation->set_rules('username','User Name','required|alpha');
        $this->form_validation->set_rules('password','Password','required|max_length[12]');
        $this->form_validation->set_rules('firstname','First Name','required|alpha');
        $this->form_validation->set_rules('lastname','Last Name','required|alpha');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
        $this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');
        if($this->form_validation->run())
        {
            $post=$this->input->post();
            $this->load->model('loginmodel','user');
            if($this->user->add_user($post))
            {
                $this->session->set_flashdata('user','user added successfully');
                $this->session->set_flashdata('user_class','alert-success');
            }
            else{
                $this->session->set_flashdata('user','user not added please try again!');
                $this->session->set_flashdata('user_class','alert-danger');
            }
            return redirect('users/sendemail');
          //  $this->load->library('email');
            //$this->email->from(set_value('email'),set_value('fname'));
           // $this->email->to("shindekomal929@gmail.com");
           // $this->email->subject("Registration Greeting..");
           // $this->email->message("thank you for registration");
           // $this->email->set_newline("\r\n");
           // if(!$this->email->send()){
            //    show_error($this->email->print_debugger());
           // }
           // else{
            //    echo "Your email has been sent!";
           // }
        }
        else{
            $this->load->view('Admin/register');
        }
    }
}

?>