<?php

class Users extends CI_Controller {

    public $viewFolder = "";

    public function __construct(){
        parent::__construct();

        $this->viewFolder = "users_v";

        $this->load->model("user_model");
    }

    public function index(){
        $viewData = new stdClass();

        /**Tablodan Verilerin Getirilmesi.. */
        $items = $this->user_model->get_all(
            array()
        );

        /**View'e gönderilecek değişkenlerin set edilmesi..*/
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "list";
        $viewData->items = $items;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function new_form(){
        $viewData = new stdClass();
        
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "add";

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function save(){
        $this->load->library("form_validation");

        //kurallar yazılır..
        $this->form_validation->set_rules("user_name","Kullanıcı Adı","required|trim|is_unique[users.user_name]");
        $this->form_validation->set_rules("full_name","Ad Soyad","required|trim");
        $this->form_validation->set_rules("email","E-posta","required|trim|valid_email|is_unique[users.email]");
        $this->form_validation->set_rules("password","Şifre","required|trim|min_length[6]|max_length[8]");
        $this->form_validation->set_rules("re_password","Şifre Tekrar","required|trim|min_length[6]|max_length[8]|matches[password]");

        $this->form_validation->set_message(
            array(
                "required"    => "<b> {field} </b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçeril bir e-posta adresi giriniz.",
                "is_unique"   => "<b>{field}</b> alanı daha önceden kullanılmış.",
                "matches"     => "Şifreler birbirlerini tutmuyor.",
                "min_length"  => "Şifre en az 6 karakter olmalıdır.",
                "max_length"  => "Şifre 8 karakterden fazla olamaz."

            ));

            //Form validation çalıştırılır
            $validate = $this->form_validation->run();

            if($validate){

                //upload süreci...

                $insert = $this->user_model->add(
                    array(
                "user_name" => $this->input->post("user_name"),
                "full_name" => $this->input->post("full_name"),
                "email"     => $this->input->post("email"),
                "password"  => md5($this->input->post("password")),
                "isActive"  => 1,
                "createdAt" => date("Y-m-d H:i:s")
                )
            );

            //TODO Alert sistemi eklenecek...
            if($insert){

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text"  => "Kayıt başarılı bir şekilde eklendi",
                    "type"  => "success"
                ); } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text"  => "Kayıt ekleme sırasında bir problem oluştu",
                    "type"  => "error"
                );
            }
            
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("users"));

            die();} else {
                $viewData = new stdClass();
            
                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "add";
                $viewData->form_error = true;

                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

            } 
    }

    public function update_form($id){
        $viewData = new stdClass();

        /**Tablodan Verilerin Getirilmesi.. */
        $item = $this->user_model->get(
            array(
                "id"        => $id
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "update";
        $viewData->item = $item;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update_password_form($id){

        $viewData = new stdClass();

        /**Tablodan Verilerin Getirilmesi.. */
        $item = $this->user_model->get(
            array(
                "id"        => $id,
            )
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "password";
        $viewData->item = $item;

        $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function update($id){

        $this->load->library("form_validation");

        $oldUser = $this->user_model->get (
                array(
                    "id" => $id
                )
            );

        if($oldUser->user_name != $this->input->post("user_name")){
            $this->form_validation->set_rules("user_name","Kullanıcı Adı","required|trim|is_unique[users.user_name]");
        }
        if($oldUser->email != $this->input->post("email")){
            $this->form_validation->set_rules("email","E-posta","required|trim|valid_email|is_unique[users.email]");
        }
        
        $this->form_validation->set_rules("full_name","Ad Soyad","required|trim");

        $this->form_validation->set_message(
            array(
                "required"    => "<b> {field} </b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçeril bir e-posta adresi giriniz.",
                "is_unique"   => "<b>{field}</b> alanı daha önceden kullanılmış.",
            )
        );
        
        //Form validation çalıştırılır
        $validate = $this->form_validation->run();

        if($validate){
            
            //upload süreci...

            $update = $this->user_model->update(
                array("id" => $id ), 
                array(
                    "user_name" => $this->input->post("user_name"),
                    "full_name" => $this->input->post("full_name"),
                    "email"     => $this->input->post("email")
                    )
                );

            //TODO Alert sistemi eklenecek...
            if($update){

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text"  => "Kayıt başarılı bir şekilde güncellendi",
                    "type"  => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text"  => "Kayıt güncelleme sırasında bir problem oluştu",
                    "type"  => "error"
                );

            }

            //İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("users"));

        } else {
            $viewData = new stdClass();
        
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;

            /**Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->user_model->get(
                array(
                    "id"        => $id
                )
            );
        

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
        
    }

    public function update_password($id){

        $this->load->library("form_validation");

        $this->form_validation->set_rules("password","Şifre","required|trim|min_length[6]|max_length[8]");
        $this->form_validation->set_rules("re_password","Şifre Tekrar","required|trim|min_length[6]|max_length[8]|matches[password]");

        $this->form_validation->set_message(
            array(
                "required"    => "<b> {field} </b> alanı doldurulmalıdır",
                "matches"   => "Şifreler birbirini tutmuyor",
            )
        );
        
        //Form validation çalıştırılır
        $validate = $this->form_validation->run();

        if($validate){
            
            //upload süreci...

            $update = $this->user_model->update(
                array("id" => $id ), 
                array(
                    "password" => md5($this->input->post("password")),
                    )
                );

            //TODO Alert sistemi eklenecek...
            if($update){

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text"  => "Şifreniz başarılı bir şekilde güncellendi",
                    "type"  => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text"  => "Şifre güncelleme sırasında bir problem oluştu",
                    "type"  => "error"
                );

            }

            //İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);

            redirect(base_url("users"));

        } else {
            $viewData = new stdClass();
        
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "password";
            $viewData->form_error = true;

            /**Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->user_model->get(
                array(
                    "id"        => $id,
                )
            );
        

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
        
    }

    public function delete($id){
        $delete = $this->user_model->delete(
            array(
                "id" => $id
            )
        );

        //TODO Alert sistemi eklenecek...
        if($delete){

            $alert = array(
                "title" => "İşlem Başarılı",
                "text"=> "Kayıt başarılı bir şekilde silindi",
                "type" => "success"
            );

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text"=> "Kayıt silme sırasında bir problem oluştu",
                "type" => "error"
            );

        }

        $this->session->set_flashdata("alert", $alert);

        redirect(base_url("users"));
    }

    public function isActiveSetter($id){
        
        if($id){

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->user_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );

        }

    }

    public function imageIsActiveSetter($id){
        
        if($id){

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->product_image_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );

        }

    }

    public function isCoverSetter($id, $parent_id){
        
        if($id && $parent_id){

            $isCover = ($this->input->post("data") === "true") ? 1 : 0;

            // Kapak yapılmak istenen kayıt
            $this->product_image_model->update(
                array(
                    "id"         => $id,
                    "product_id" => $parent_id
                ),
                array(
                    "isCover" => $isCover
                )
            );

            // Kapak yapılmayan diğer kayıtlar
            $this->product_image_model->update(
                array(
                    "id !="      => $id,
                    "product_id" => $parent_id
                ),
                array(
                    "isCover" => 0
                )
            );

            $viewData = new stdClass();
        
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "image";

        $viewData->item_images = $this->product_image_model->get_all(
            array(
                "product_id" => $parent_id
            ),  "rank ASC"
        );

        $render_html = $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/render_elements/image_list_v", $viewData, true);

        echo $render_html;

        }

    }

    public function rankSetter(){
    
        $data = $this->input->post("data");

        parse_str($data, $order);
        
        $items = $order["ord"];

        foreach($items as $rank => $id){

            $this->user_model->update(
                array(
                    "id"        => $id,
                    "rank !="   => $rank
                ),
                array(
                    "rank"      => $rank
                )
            );

        }
    }

}