<?php

class Portfolio_categories extends CI_Controller {

    public $viewFolder = "";

    public function __construct(){
        parent::__construct();

        $this->viewFolder = "portfolio_categories_v";

        $this->load->model("portfolio_category_model");

        if(!get_active_user()){
            redirect(base_url("login"));
        }
    }

    public function index(){
        $viewData = new stdClass();

        /**Tablodan Verilerin Getirilmesi.. */
        $items = $this->portfolio_category_model->get_all(
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

        $this->form_validation->set_rules("title","Başlık","required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b> {field} </b> alanı doldurulmalıdır"
            )
        );

        //Form validation çalıştırılır
        $validate = $this->form_validation->run();

        if($validate){

                //upload süreci...

                $insert = $this->portfolio_category_model->add(array(
                    "title"         => $this->input->post("title"),
                    "isActive"      => 1,
                    "createdAt"     => date("Y-m-d H:i:s")
                    )
                );

            //TODO Alert sistemi eklenecek...
            if($insert){

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text"  => "Kayıt başarılı bir şekilde eklendi",
                    "type"  => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text"  => "Kayıt ekleme sırasında bir problem oluştu",
                    "type"  => "error"
                );
            }

        $this->session->set_flashdata("alert", $alert);

        redirect(base_url("portfolio_categories"));


        } else {
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
        $item = $this->portfolio_category_model->get(
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

    public function update($id){

        $this->load->library("form_validation");

        //kurallar yazılır..
        
        $this->form_validation->set_rules("title","Başlık","required|trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b> {field} </b> alanı doldurulmalıdır"
            )
        );

        //Form validation çalıştırılır
        $validate = $this->form_validation->run();

        if($validate){
                
                //upload süreci...

            $update = $this->portfolio_category_model->update(
                array(
                    "id" => $id 
                ), 
                array(
                    "title"         => $this->input->post("title"),
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

            redirect(base_url("portfolio_categories"));

        } else {

            $viewData = new stdClass();
            
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "update";
            $viewData->form_error = true;

            /**Tablodan Verilerin Getirilmesi.. */
            $viewData->item = $this->portfolio_category_model->get(
                array(
                    "id"   => $id
                )
            );

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
    }

    public function delete($id){
        $delete = $this->portfolio_category_model->delete(
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

        redirect(base_url("portfolio_categories"));
    }

    public function isActiveSetter($id){
        
        if($id){

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->portfolio_category_model->update(
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
}