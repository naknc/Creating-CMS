<?php

class Userop extends CI_Controller {

    public $viewFolder = "";

    public function __construct(){
        parent:: __construct();

        $this->viewFolder = "users_v";

        $this->load->model("user_model");
    }

    public function login(){

        if(get_active_user()){
            redirect(base_url());
        }

        $viewData = new stdClass();

        /**View'e gönderilecek değişkenlerin set edilmesi..*/
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "login";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function do_login(){
        
        if(get_active_user()){
            redirect(base_url());
        }

        $this->load->library("form_validation");

        //kurallar yazılır..
        $this->form_validation->set_rules("user_email","E-posta","required|trim|valid_email");
        $this->form_validation->set_rules("user_password","Şifre","required|trim|min_length[6]|max_length[8]");

        $this->form_validation->set_message(
            array(
                "required"    => "<b> {field} </b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçeril bir e-posta adresi giriniz.",
                "min_length"  => "<b> {field} </b> en az 6 karakter olmalıdır.",
                "max_length"  => "<b> {field} </b> 8 karakterden fazla olamaz."

            ));

            //Form validation çalıştırılır
            $validate = $this->form_validation->run();

            if($this->form_validation->run() == FALSE){

                $viewData = new stdClass();
            
                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "login";
                $viewData->form_error = true;

                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


            } else {
                $user = $this->user_model->get(
                    array(
                        "email"     => $this->input->post("user_email"),
                        "password"  => md5($this->input->post("user_password")),
                        "isActive"  => 1
                    )
                );
                if($user){

                    $alert = array(
                        "title" => "İşlem Başarılı",
                        "text"  => "$user->full_name Hoşgeldiniz",
                        "type"  => "success"
                    );

                    $this->session->set_userdata("user", $user);
                        
                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url());

                } else {
                    //Hata verilecek
                    $alert = array(
                        "title" => "İşlem Başarısız",
                        "text"  => "Lütfen giriş bilgilerrinizi kontrol ediniz",
                        "type"  => "error"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("login"));
                }
            }
    }

    public function logout(){

        $this->session->unset_userdata("user");
        redirect(base_url("login"));
    }

    public function send_email(){

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'nihan.akinci.35@gmail.com',
            'smtp_pass' => '********',
            'starttls' => TRUE,
            'charset'=>'utf-8',
            'mailtype' => 'html',
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );

        $this->load->library('email', $config);

        $this->email->from("nihan.akinci.35@gmail.com", "CMS");
        $this->email->to("tombraidern@gmail.com");
        $this->email->subject("CMS için Email Çalışmaları");
        $this->email->message("Deneme e-postası...");

        $send = $this->email->send();

        if($send){
            echo "E-posta başarılı bir şekilde gönderilmiştir.";
        } else {
            echo $this->email->print_debugger();
        }
    }
}