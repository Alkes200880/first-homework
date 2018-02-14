<?
require_once "MyPDO.php";

class First extends CI_Model{
    public function index()
    {
        var_dump(MyPDO::createTable("first"));
        MyPDO::addDataSQL(["a","b","c"],"first");
        MyPDO::addDataSQL(["a","b","c"],"first");
        return "ok";
    }
}


