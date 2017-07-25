<?php
// +----------------------------------------------------------------------
// | Program Name: 万能投票
// +----------------------------------------------------------------------
// | Copyright:    http://www.sosv.net All rights reserved.
// +----------------------------------------------------------------------
// | Developer:    蘑菇云
// +----------------------------------------------------------------------

if (!defined('IN_DISCUZ')) {
    exit('Aecsse Denied');
}

class table_xyivite_apply extends discuz_table {
    public function __construct() {
        $this->_table = 'xyivite_apply';
        $this->_pk = 'id';
        parent::__construct();
    }

    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE %i $orders LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}
	public function fetch_by_uid($uid) {
		$data = DB::result_first("SELECT count(*) FROM %t WHERE uid=%i",array($this->_table,$uid));
		return $data;
	}
		public function count_by_search(){
		return DB::result_first("SELECT COUNT(1) FROM %t ",array($this->_table));
	}
	
	public function fetch_rank($score) {
        $s = DB::result_first('SELECT COUNT(1) FROM %t WHERE totalscore>%d', array($this->_table,$score));
		return $s+1;
    }
}
?>

