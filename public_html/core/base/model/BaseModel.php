<?php


namespace core\base\model;



use core\base\controller\Singleton;
use core\base\exceptions\DbException;

class BaseModel extends BaseModelMethods
{
    use Singleton;
    protected $db;

    private function __construct()
    {
        $this->db = @new \mysqli(HOST,USER,PASS,DB_NAME);

        if($this->db->connect_error){
            throw new DbException('Ошибка подключения к базе данных : '
                 . $this->db->connect_errno . ' '. $this->db->connect_error);
        }

        $this->db->query('SET NAMES UTF8');
    }

    /**
     * @param $query
     * @param string $crud
     * @param false $return_id    r - SELECT/ c - INSERT/ u - UPDATE / d - DELETE
     * @return array|bool|int|string
     * @throws DbException
     */

    final public function query($query, $crud = 'r', $return_id = false)
    {
        $result = $this->db->query($query);

        if($this->db->affected_rows === -1){
            throw new DbException('Ошибка в SQL запросе : '
               . $query . ' - ' . $this->db->errno . ' ' . $this->db->error);
        }

        switch ($crud)
        {
            case 'r':
                    if($result->num_rows){
                        $res = [];

                        for($i=0; $i < $result->num_rows; $i++){
                            $res[] = $result->fetch_assoc();
                        }
                        return $res;
                    }
                    return false;

                break;

            case 'c':
                    if($return_id) return $this->db->insert_id;

                    return true;
                break;

            default:
                return true;
                break;
        }
    }

    /**
     * @param $table
     * @param array $set
     *
    $res = $db->get($table,[
    'fields' => ['id','name'],
    'where' => ['id' => 1, 'name' =>'Rudik'],
    'operand' => ['=', '<>'],
    'condition' => ['AND'],
    'order' => ['fio', 'name'],
    'order_direction' => ['ASC','DESC'],
    'limit' => '1'

    ]);
    $query = "SELECT * FROM article";
    $res = $db->
     */
    final public function get($table, $set = [])
    {
        $fields = $this->createFields($set,$table);

        $order = $this->createOrder($set,$table);

        $where = $this->createWhere($set,$table);

        if(!$where) $new_where = true;
            else $new_where = false;

        $join_arr = $this->createJoin($set,$table,$new_where);



        $fields .= $join_arr['fields'];

        $join = $join_arr['join'];

        $where .= $join_arr['where'];

        $fields = rtrim($fields,", ");



        $limit = $set['limit'] ? ' LIMIT ' . $set['limit'] : '';

        $query = "SELECT $fields FROM $table $join $where $order $limit";



        return $this->query($query);

    }

    final public function add($table, $set = [])
    {
        $set['fields'] = (is_array($set['fields']) && !empty($set['fields']))  ? $set['fields'] : $_POST;
        $set['files'] = (is_array($set['files']) && !empty($set['files']))  ? $set['files'] : false;

        if(!$set['fields'] && !$set['files']) return false;

        $set['return_id'] = $set['return_id'] ? true : false;
        $set['except'] = (is_array($set['except']) && !empty($set['except']))  ? $set['except'] : false;

        $insert_arr = $this->createInsert($set['fields'], $set['files'],$set['except']);

        if($insert_arr){

            $query = "INSERT INTO $table ({$insert_arr['fields']}) VALUES ({$insert_arr['values']})";
            return $this->query($query,'c',$set['return_id']);
        }

        return false;

    }

    final public function edit($table, $set = [])
    {
        $set['fields'] = (is_array($set['fields']) && !empty($set['fields']))  ? $set['fields'] : $_POST;
        $set['files'] = (is_array($set['files']) && !empty($set['files']))  ? $set['files'] : false;

        if(!$set['fields'] && !$set['files']) return false;

        $set['except'] = (is_array($set['except']) && !empty($set['except']))  ? $set['except'] : false;

        if(!$set['all_rows']){

            if($set['where']){

                $where = $this->createWhere($set);
            }else{

                $columns = $this->showColumns($table);

                if(!$columns) return false;

                if($columns['id_row'] && $set['fields'][$columns['id_row']]){

                    $where = 'WHERE '. $columns['id_row'] . '=' . $set['fields'][$columns['id_row']];

                    unset($set['fields'][$columns['id_row']]);
                }
            }
        }

        $update = $this->createUpdate($set['fields'], $set['files'],$set['except']);

        $query = "UPDATE $table SET $update  $where";

        return $this->query($query, 'u');

    }

    public function delete($table, $set)
    {

        $table = trim($table);

        $where = $this->createWhere($set, $table);

        $columns = $this->showColumns($table);

        if(!$columns) return false;

        if(is_array($set['fields']) && !empty($set['fields'])){

            if($columns['id_rows']){

                $key = array_search($columns['id_rows'], $set['fields']);

                if($key !== false) unset($set['fields'][$key]);
            }

            $fields =[];

            foreach($set['fields'] as $field){

                $fields[$field] = $columns[$field]['Default'];
            }

          $update =$this->createUpdate($fields,false,false);

            $query = "UPDATE $table SET $update $where";
        }else{

            $join_arr = $this->createJoin($set,$table);
            $join = $join_arr['join'];
            $join_tables = $join_arr['tables'];

            $query = 'DELETE ' . $table . $join_tables . ' FROM ' . $table . ' ' . $join . ' ' . $where;

     }
        return $this->query($query, 'u');
    }

   final public function showColumns($table)
    {
        $query = "SHOW COLUMNS FROM $table";

        $res = $this->query($query);

        $columns = [];

        if($res){

            foreach($res as $row){

                $columns[$row['Field']] = $row;
                if($row['Key'] === 'PRI') $columns['id_row'] = $row['Field'];
            }

        }
        return $columns;
    }

}