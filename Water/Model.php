<?php 
/**
 * 数据库操作类
 */
// require('Model.php');
// $arr = array(
//     'type'      => 'mysql',
//     'host'      => 'localhost',
//     'port'      => 3306,
//     'dbname'    => 'test',
//     'username'  => 'root',
//     'password'  => '',
//     'names'     => 'utf8'
//     );
// $db = M($arr, 'user');
// $select = $db->where('id < 10')->limit('1,3')->order('id desc')->select('id,user');
// $count = $db->count();
// $data = array(
//     'user' => 'abc',
//     'age'   => 20,
//     );
// $insert = $db->insert($data);
// $data = array(
//     'user' => 'water',
//     'age'   => 24,
//     );
// $update = $db->where('id<10')->update($data);
// $del = $db->where('id>0 and id< 6')->delete();

Class Model{   
    public $con = NULL; // pdo对象
    public $tab = ''; // 表名
    public $fields = '*'; // 字段
    public $where = ''; // 条件
    public $order = ''; // 排序
    public $limit = ''; // 条数
    
/* 构造函数 */
    function __construct($config){
        try {
            $this->con = new PDO("{$config['db']['type']}:host={$config['db']['host']};dbname={$config['db']['dbname']};port={$config['db']['port']};", "{$config['db']['username']}", "{$config['db']['password']}", array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES `{$config['db']['names']}`", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
        } catch (PDOException $e) {
            echo "Error : " . $e->getMessage() . '<br />';
            die("{$config['db']['type']}数据库连接失败");
        }
        $this->tab = $config['tab'];
    }
/* FIELDS 字段 */
    function fields($fields){
        $this->fields = $fields;
        return $this;
    }
/* WHERE 条件 */
    function where($where){
        $this->where = 'WHERE ' . $where;
        return $this;
    }
/* ORDER BY 排序 */
    function order($order){
        $this->order = 'ORDER BY ' . $order;
        return $this;
    }
/* LIMIT 条数 */
    function limit($limit){
        $this->limit = 'LIMIT ' . $limit;
        return $this;
    }
/* SELECT 查询 */
    function select($fields = ''){
        if (empty($fields)) {
            $fields = $this->fields;
        }
        $sql = "SELECT {$fields} FROM {$this->tab} {$this->where} {$this->order} {$this->limit}";
        // 清除，以免影响其他定义
        $this->where = $this->order = $this->limit = '';
        return $this->query($sql);
    }
/* INSERT 增加 */
    function insert($data){
        foreach ($data as $k => $v) {
            $fields_arr[] = $k;
            $values_arr[] = "'$v'";
        }
        $fields = implode(',', $fields_arr);
        $values = implode(',', $values_arr);
        $sql = "INSERT INTO {$this->tab} ({$fields}) VALUES ({$values})";
        if (!$this->con->exec($sql)) {
            exit("插入失败");
        }
        return $this->con->lastInsertId();
    }
/* UPDATE 修改 */
    function update($data){
        // 一定要有 WHERE 条件限制
        if (empty($this->where)) {
            exit("未限制条件");
        }
        foreach ($data as $k => $v) {
            $sets .= "{$k}='{$v}',";
        }
        $sets = rtrim($sets, ',');
        $sql = "UPDATE {$this->tab} SET {$sets} {$this->where}";
        $this->where = '';
        return $this->execute($sql);
    }
/* DELETE 删除 */
    function delete(){
        // 一定要有 WHERE 条件限制
        if (empty($this->where)) {
            exit("未限制条件");
        }
        // 只支持单条删除        
        $sql = "DELETE FROM {$this->tab} {$this->where}";
        $this->where = '';
        return $this->execute($sql);
    }
/* COUNT 查询总条数 */
    function count(){
        $sql = "SELECT COUNT(*) AS count FROM {$this->tab} {$this->where}";
        $count_arr = $this->query($sql);
        $this->where = '';
        return $count_arr[0]['count'];
    }
/* 执行SQL语句 */
    function query($sql){
        $query = $this->con->query($sql);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $rst = $query->fetchAll();
        return $rst;
    }
    function execute($sql){
   		$affectedRows = $this->con->exec($sql);
        return $affectedRows;
    }
}
