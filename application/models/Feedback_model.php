<?php

class Feedback_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getall()
    {
        $ret = $this->db//select_max("name");
            ->from("pictures")
            ->get();

        //$this->db->where("date>","444"); //где дата больше 444
        //$this->db->or_where("date>","333"); //или где дата больше 333
        //$this->db->where([
        //"date>"=>"444",
        //"name"=>"zzz"]); //где дата больше 444
        //$this->db->like("name","s");
        return $ret->result();


    }
    public function best()
    {
        $ret = $this->db//select_max("name");
        ->from("pictures")
            ->where("name>","7.jpeg")
            ->get();


        return $ret->result();

    }

    public function randomize()
    {
        $ret = $this->db//select_max("name");
        ->from("pictures")
            ->order_by('name', 'random')
            ->limit(1)
            ->get();

        //$this->db->where("date>","444"); //где дата больше 444
        //$this->db->or_where("date>","333"); //или где дата больше 333
        //$this->db->where([
        //"date>"=>"444",
        //"name"=>"zzz"]); //где дата больше 444
        //$this->db->like("name","s");
        return $ret->result();


    }

    public function nod()
    {
        return "sdgsdfg";
    }

    public function nod2()
    {
        return "4556";
    }
}