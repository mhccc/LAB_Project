<?php 
class Core_db extends CI_Model {

        function isConnectedToDB($db)
        {
                return $this->db->db_connect();
        }
        function db_query($sql, $con=NULL)
        {
                return $this->db->query($sql);
        }
        function db_fetch_array($res)
        {
                // return @mysql_fetch_array($res);
                return $res->result_array();
        }
        function db_fetch_assoc($res)
        {
                // return mysql_fetch_assoc($res);
                return $res->result_array();
        }
        function db_num_rows($res)
        {
                // return mysql_num_rows($res);
                return $res->num_rows();
        }
        function db_info()
        {
                return mysql_get_server_info();
        }
        function db_error()
        {
                // return mysql_error();
                return $this->db->display_error();
        }
        function db_close($conn)
        {
                // return mysql_close($conn);
                return $this->db->close();
        }
        function db_insert_id($conn=NULL)
        {
                return $this->db->insert_id();
        }
        //DB-UID데이터 
        function getUidData($table,$uid)
        {
                return getDbData($table,'uid='.(int)$uid,'*');
        }
        //DB데이터 1ROW
        function getDbData($table,$where,$data)
        {
                $this->db->select($data);
                $this->db->where($where);
                $query = $this->db->get($table);
                return $query->row_array();
        }
        //DB데이터 ARRAY
        function getDbArray($table,$where,$data,$sort,$orderby,$recnum,$p)
        {
                $this->db->select($data);
                $this->db->where($where);
                $this->db->order_by($sort, $orderby);
                $rcd = $this->db->get($table, $recnum, (($p-1)*$recnum));
                return $rcd;
        }
        //DB데이터 NUM
        function getDbRows($table,$where)
        {
                $this->db->where($where);
                $this->db->from($table);
                $rows = $this->db->count_all_results();
                return $rows[0] ? $rows[0] : 0;
        }
        //DB데이터 MAX
        function getDbCnt($table,$type,$where)
        {
                $this->db->select($type);
                $this->db->where($where);
                $this->db->from($table);
                return $this->db->count_all_results();
        }
        //DB셀렉트
        function getDbSelect($table,$where,$data)
        {
                $this->db->select($data);
                $this->db->where($where);
                $r = $this->db->get($table);
                return $r;
        }
        //DB삽입
        function getDbInsert($table,$key,$val)
        {
                $key_array = explode(',', $key);
                $val_array = explode(',', $val);
                $data = array();
                if(count($key_array) == count($val_array)){
                        for ($i=0; $i < count($key_array) ; $i++) { 
                                $data[$key_array[$i]] = $val_array[$i];
                        }
                        return $this->db->insert($table, $data);
                }else{
                        return false;
                }
        }
        //DB업데이트
        function getDbUpdate($table,$set,$where)
        {
                $this->db_query("update ".$table." set ".$set.($where?' where '.$this->getSqlFilter($where):''),$DB_CONNECT);
        }
        //DB삭제
        function getDbDelete($table,$where)
        {
                $this->db_query("delete from ".$table.($where?' where '.$this->getSqlFilter($where):''),$DB_CONNECT);
        }
        //SQL필터링
        function getSqlFilter($sql)
        {
                return preg_replace("( union| update| insert| delete| drop|\/\*|\*\/|\\\|\;)",'',$sql);
        }

}

?>