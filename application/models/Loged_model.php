<?php
require_once "MyPDO.php";
class Loged_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function currentWork($name)
    {
        $ret=$this->db
            ->from("List")
            ->order_by('sort')
            ->where("name",$name)
            ->get();
        //return true;


        return $ret->result();
    }
    public function removeWork()
    {
        $this->db->where('id', $this->input->post("param1"));
        $this->db->delete('List');
        $ret=["a"=>"b"];
        return $ret;
    }
    public function AddWork($name,$n,$w,$d)
    {
        $this->db->insert('List', [
            'name' => $name,
            'num' => $n,
            'work' => $w,
            'date' => $d,

        ]);
        $id=$this->db->insert_id();
        $this->db->set('sort', $id)
            ->where("id",$id)
            ->update('List');
        $ret = [
            'num' => $n,
            'work' => $w,
            'date' => $d,
            'id' => $id,
            "state" => 0,
        ];
        return $ret;
    }

    public function changeSort($id1,$id2)
    {
        $ret=$this->db
            ->from("List")
            ->select("sort")
            ->where_in("id",[$id1,$id2])
            ->get();
        $ret1=$ret->result();
        $sort=[$ret1[0]->sort,$ret1[1]->sort];

        MyPDO::qu("UPDATE List SET sort={$sort[0]}+{$sort[1]}-sort WHERE sort IN ({$sort[0]},{$sort[1]})");
//        $this->db->set('sort', "{$sort[1]}+{$sort[0]}-sort")
//            //->where_in("sort",$sort)
//            ->where("sort",$sort[0])
//            ->or_where("sort",$sort[1])
//            ->update('List');

        //$ret="aa";
     return $sort;
    }

    public function moveDown($id1,$id2)
    {
        $ret="aa";
        return $ret;
    }

    public function createDBList()
    {
        $this->load->dbforge();
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),

            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'num' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'work' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'date' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'sort' => array(
                'type' => 'DOUBLE',
                //'constraint' => 5,
                'unsigned' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);

        $this->dbforge->create_table('List', TRUE,['ENGINE' => 'InnoDB']);

    }


}