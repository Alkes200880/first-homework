<?php
class Feedback extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("feedback_model");

    }

    public function index()
    {
        echo "hello";
    }
    public function lst($name='',$phone='')
    {
        echo "data : ".$name." ".$phone." ";

    }

    public function db()
    {
        $this->load->database();

       // $this->db->select("name");
        $this->db->select_max("name");
        //$this->db->from("first");
        //$this->db->where("date>","444"); //где дата больше 444
        //$this->db->or_where("date>","333"); //или где дата больше 333
        //$this->db->where([
        //"date>"=>"444",
        //"name"=>"zzz"]); //где дата больше 444
        //$this->db->like("name","s");



        $query = $this->db->get("first",2);
        foreach ($query->result() as $row){
            echo $row->name;
        }
    }


    public function put(){
    //    echo "<pre>";
    //print_r($this->feedback_model->getall());
     //   echo "</pre>";
        $feedb =$this->feedback_model->getall();

        $data["title"] = "myyy";
        $this->load->view('header',$data);
        $this->load->view("Welcome".'/m3',["feed"=>$feedb]);
        $this->load->view('footer');

    }
    public function best()
    {
        $feedb =$this->feedback_model->best();

        $data["title"] = "myyy";
        $this->load->view('header',$data);
        $this->load->view("Welcome".'/m3',["feed"=>$feedb]);
        $this->load->view('footer');

    }

    public function randomize()
    {
        $feedb =$this->feedback_model->randomize();

        $data["title"] = "myyy";
        $this->load->view('header',$data);
        $this->load->view("Welcome".'/m3',["feed"=>$feedb]);
        $this->load->view('footer');

    }

}