<?php

/*
   This is NOT a freeware, use is subject to license terms
   ��Ȩ���У�TOM΢�� www.tomwx.net
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
} 

class table_tom_yaoyiyao_user extends discuz_table{
	public function __construct() {
        parent::__construct();
		$this->_table = 'tom_yaoyiyao_user';
		$this->_pk    = 'id';
	}

    public function fetch_by_id($id,$field='*') {
		return DB::fetch_first("SELECT $field FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function fetch_by_yao_id_tel($yao_id,$tel) {
		return DB::fetch_first("SELECT * FROM %t WHERE yao_id=%d AND tel=%s ", array($this->_table, $yao_id,$tel));
	}
    
    public function fetch_by_yao_id_openid($yao_id,$openid) {
		return DB::fetch_first("SELECT * FROM %t WHERE yao_id=%d AND openid=%s ", array($this->_table, $yao_id,$openid));
	}
	
    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE 1 %i $orders LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}
    
    public function insert_id() {
		return DB::insert_id();
	}
    
    public function fetch_all_count($condition) {
        $return = DB::fetch_first("SELECT count(*) AS num FROM ".DB::table($this->_table)." WHERE 1 $condition ");
		return $return['num'];
	}
    
	public function delete_by_id($id) {
		return DB::query("DELETE FROM %t WHERE id=%d", array($this->_table, $id));
	}
    
    public function delete_by_yao_id($yao_id) {
		return DB::query("DELETE FROM %t WHERE yao_id=%d", array($this->_table, $yao_id));
	}

}


?>