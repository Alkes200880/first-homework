<?

error_reporting(E_ALL );
ini_set('display_errors', '1');

class MyPDO
{
    private static $host = "test.site";
    private static $db = "test";
    private static $user = "root";
    private static $pass = "alkes200880";
    private static $charset = "utf8";

    private static $dsn;

    private static $pdo;

    private static $opt = [PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES      => false];


    private static function connect() {
        $ret = ["state"=>0,"error"=>""];
        if (!self::$pdo){
            self::$dsn = "mysql:host=".self::$host.";dbname=".self::$db.";charset=".self::$charset;
            try{
                self::$pdo= new PDO(self::$dsn, self::$user, self::$pass, self::$opt);
            } catch (PDOException $e){
                $ret["state"]=1;
                $ret["error"]=$e->getMessage();
            }

        }
        return $ret;

    }



//------------------- создать таблицу
    public static function createTable($table="pictures")// Создает с таблицу с указанным именем или таблицу pictures
    {
        $ret = self::connect();
        if (!$ret["state"]) {
            if (self::$pdo->query("CREATE TABLE IF NOT EXISTS `".$table."` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `path` varchar(50) NOT NULL,
                `name` varchar(30) NOT NULL,
                `ext` varchar(4) NOT NULL,
                PRIMARY KEY (`id`)
                ) Engine=InnoDB DEFAULT CHARSET=utf8;")){
                $ret["error"]='таблица "пользователей" создана\n';
            }
            else{
                $ret["state"]=2;
                $ret["error"]='не получилось создать таблицу\n';
            }
        }
        return $ret;
    }
//------------------ end

    public static function addDataSQL($data,$table="pictures") //параметр массив с тремя значениями путь имя расширение
    {
        $ret = self::connect();
        if (!$ret["state"]) {
            $stmt = self::$pdo->prepare(
                "INSERT INTO `" . $table . "` (`id`, `path`, `name`, `ext`)
                      VALUES (NULL, ?, ?, ?);");

            if ($stmt->execute($data)){
                $ret["id"]=self::$pdo->lastInsertId();
                //$ret["path"]=$data[0];
                //$ret["name"]=$data[1];
                //$ret["ext"]=$data[2];
            }else{
                $ret["state"]=3;
                $ret["error"]='не получилось добавить данные';
            };
        }
        return $ret;
    }

    function receiveElem($col,$row,$table="pictures"){
        $ret = self::connect();
        if (!$ret["state"]) {
            $stmt = self::$pdo->prepare("SELECT `?` FROM `?` WHERE id = ? ;");

            if ($stmt->execute(array($col,$table,$row))){
                $ret["data"]=$stmt->fetch()[$col];
            }else{
                $ret["state"]=3;
                $ret["error"]='не получилось получить данные';
            };
        }
        return $ret;

    }
    function deleteRow($row,$table="pictures"){
        $ret = self::connect();
        if (!$ret["state"]) {
            $stmt = self::$pdo->prepare("DELETE FROM `?` WHERE id = ? ;");

            if ($stmt->execute(array($table,$row))){
                //$ret["data"]=$stmt->;
            }else{
                $ret["state"]=3;
                $ret["error"]='не получилось удалить строку';
            };
        }
        return $ret;
    }
    public static function qu($string){
        $ret = self::connect();
        if (!$ret["state"]) {
            $stmt = self::$pdo->query($string);
            return $stmt;
        }
        return false;
    }
//    function last($table="pictures")
//    {
//        $stmt = $this->pdo->query('SELECT * FROM `'.$table.'`ORDER BY `id` DESC LIMIT 1');
//
//        return $stmt->fetch();
//    }
//
//    function receiveDataSQL($table="pictures")
//    {//        $stmt = $this->pdo->query('SELECT * FROM '.$table);
//        while ($row = $stmt->fetch()) {
//            var_dump($row);
//            echo "<br>";
//        }
//    }
}

//echo "hello";
//MyPDO::createTable("first");


//MyPDO::addDataSQL(["a","b","c"],"first");
//MyPDO::addDataSQL(["a","b","c"],"first");
//echo "<pre>";
//var_dump(self::connect());
//echo "</pre>end";