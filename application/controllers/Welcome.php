<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model("welcome_model");

    }

    public $base = "http://homework1.my/";
	private $jquery = "<script src=\"/js/jquery-3.3.1.min.js\" defer></script>";

    private function script($name="/js/main.js")//Создает строку для запуска скриптов на странице
    {
        return $this->jquery."<script src=\" {$name}\" defer></script>";
    }


	public function index()//Стартовая страница
	{
	    if ($this->autorized()){
            header("Location: /Loged");
        }

        $data["title"] = "Добро пожаловать";
        $data["script"] = $this->script("/js/enter.js");
        $this->load->view('header',$data);
		$this->load->view(static::class.'/enter');
        $this->load->view('footer');
	}

    public function autorized()
    {
        if ($this->checkCookie()) return true;
        return false;
    }
    public function registration()//страница регистрации
    {
        $data["title"] = "Форма регистрации";
       // $data["script"] = $this->script("js/enter.js");
        $this->load->view('header',$data);
        $this->load->view(static::class.'/registration');
        $this->load->view('footer');
    }

    public function ajaxLogin()
    {
        $ret = [

            "status"=>1,
            "error"=>"Ошибка",
            "path"=>"",
            "name"=>"",
            "id"=>-1
        ];

        $login= $this->input->post("Login");
        $pass= $this->input->post("Pass");


            if ($temp=$this->welcome_model->checkPass($login,$pass)){

                $ret["status"]=0;
                $ret["error"]=$this->addCookie($login);
                $ret["name"]=$temp;

            } else {
                $ret["error"]="Неверный логин-пароль";
            };


        echo json_encode($ret);
    }


    private function addCookie($login)
    {

        $sol="msL3K0z=?14";
        $md5=md5($login.rand(0,1000).$sol);
        setcookie("token",$md5,strtotime("+2 H"),"/");


        return $this->welcome_model->saveToken($login,$md5);
    }

    public function checkCookie()//возвращет имя если куки в базе или фальш
    {
        if($cookie=$this->getcookie("token")){

            return $this->welcome_model->checkToken($cookie);

        }
        return false;

    }

    public function getcookie($name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name]: false;
    }


    public function addUser()
    {

        $data=$this->verifyData(
            $this->input->post("Login"),
            $this->input->post("Pass"),
            $this->input->post("mail"));
        if ($data["state"]){
         try{
             $this->welcome_model->addDBUser($this->input->post("Login"),
                 $this->input->post("Pass"),
                 $this->input->post("mail"));

             echo "Пользователь добавлен";
         } catch (Exception $e) { echo "Пользователь недобавлен".$e;};
        } else echo "Данные некорректны";


    }

    public function verifyData($l,$p,$m)
    {
        return [
            'Login' => $l,
            'Pass' => $p,
            'mail' => $m,
            'state' => TRUE

        ];
    }

    public function createDB()
    {
        $this->welcome_model->createDBLogin();
        $this->load->model("loged_model");
        $this->loged_model->createDBList();
        echo "Базы созданы";
        header("refresh: 2; url=/welcome/registration");
    }

    public function logOut()
    {
        //deletecookie;
        setcookie("token","",strtotime("-2 H"),"/");
        echo "куки удален";
        header("refresh: 1; url=/");
    }




}
