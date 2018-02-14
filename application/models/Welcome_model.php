<?php

class Welcome_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function checkPass($login,$pass){


        $ret=$this->db
            ->from("Login")
            ->where([
                "Login"=>$login,
                "Pass"=>$pass
            ])
            ->get();


        return $ret->result();
    }

    public function saveToken($login,$md5)
    {

        $this->db->set('token', $md5)
                ->where("Login",$login)
                ->update('Login');
        return "Save cookie";
    }

    public function checkToken($cookie)
    {

        $ret=$this->db
            ->from("Login")
            ->select("Login")
            ->where(
                "token",$cookie
            )
            ->get();

        return $ret->result()[0]->Login;
    }

    public function addDBUser($l,$p,$m)
    {

        $this->db->insert('Login', [
            'Login' => $l,
            'Pass' => $p,
            'mail' => $m,
            'approved' => TRUE

        ]);
        return true;
    }

    public function createDBLogin()
    {
        $this->load->dbforge();
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'Login' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => TRUE,
            ),
            'Pass' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'mail' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'approved' => array(
                'type' => 'BOOLEAN',
                //'null' => TRUE,
            ),
            'token' => array(
                'type' => 'VARCHAR',
                'constraint' => '32',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);

        $this->dbforge->create_table('Login', TRUE,['ENGINE' => 'InnoDB']);

    }


}