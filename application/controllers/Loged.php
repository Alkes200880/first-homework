<?php
class Loged extends CI_Controller{
    public $base = "http://homework1.my/";
    private $jquery = "<script src=\""."/js/jquery-3.3.1.min.js"."\" defer></script>";

    private function script($name="/js/main.js")
    {
        return $this->jquery."<script src=\"{$name}\" defer></script>";
    }

    public $name;
    public function __construct()
    {parent::__construct();
        $this->load->database();
        $this->name=$this->checkCookie();
        $this->load->model("loged_model");

    }

    public function index()
    {
        if ($this->name){
            //echo "Список дел";
            $data["title"] = "Добро пожаловать ".$this->name;
            $data["script"] = $this->script("/js/loged.js");
            $this->load->view('header',$data);
            $data2["data"]=$this->loged_model->currentWork($this->name);
            $this->load->view(static::class.'/spisok',$data2);

            $this->load->view('footer');

        } else {
            echo "Куки отсутствует или нет в базе, Повторите ввод пароля";
            header("refresh: 2; url=/");
        }
       // header("Location: /");


    }



    public function ajaxRemoveWork()
    {

        echo json_encode($this->loged_model->removeWork());
    }

    public function ajaxMoveUp()
    {

        $up=$this->input->post("up");
        $change=$this->input->post("prev");

        $ret=["a"=>$up,"b"=>$change,"c"=>$this->loged_model->changeSort($up,$change)];
        echo json_encode($ret);
    }
    public function ajaxMoveDown()
    {
        $down=$this->input->post("down");
        $change=$this->input->post("next");

        $ret=["a"=>$down,"b"=>$change,"c"=>$this->loged_model->changeSort($down,$change)];
        echo json_encode($ret);
    }

    public function ajaxAddWork()
    {

        echo json_encode($this->loged_model->addWork(
            $this->name,
            $this->input->post("num"),
            $this->input->post("work"),
            $this->input->post("date")));
    }


    public function checkCookie()//возвращет имя если куки в базе или фальш
    {
        if($cookie=$this->getcookie("token")){
            $this->load->model("welcome_model");
            return $this->welcome_model->checkToken($cookie);

        }
        return false;

    }

    public function getcookie($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name]: false;
    }
}