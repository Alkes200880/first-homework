<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("welcome_model");

    }

    public $base = "http://homework1.my/";
	private $jquery = "<script src=\""."/js/jquery-3.3.1.min.js"."\" defer></script>";
//{$this->base}
    private function script($name="/js/main.js")
    {
        return $this->jquery."<script src=\"
{$name}\" defer></script>";
    }


	public function index()
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
    public function registration()
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





}
