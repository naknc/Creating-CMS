<?php

class Product_model extends CI_Model {

public $tableName = "products";

    public function __construct()
    {
        parent:: __construct();
    }

    /**Sadece bir kaydı bana getirecek olan metot.. */
    public function get($where = array()){
        return $this->db->where($where)->get($this->tableName)->row();
    }


    /**Tüm kayıtları bana getirecek olan metot.. */
    public function get_all($where = array()){

        return $this->db->where($where)->get($this->tableName)->result();
    }

    public function add($data = array()){

        return $this->db->insert($this->tableName, $data);
        
    }

    public function update($where = array(), $data = array()){

        return $this->db->where($where)->update($this->tableName, $data);

    }

}