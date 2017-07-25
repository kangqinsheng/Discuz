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

class table_xyivite_ivite extends discuz_table {
    public function __construct() {
        $this->_table = 'xyivite_ivite';
        $this->_pk = 'id';
        parent::__construct();
    }

    public function fetch_all_list($condition,$orders = '',$start = 0,$limit = 10) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE %i $orders LIMIT $start,$limit",array($this->_table,$condition));
		return $data;
	}

	public function fetch_all_by_uid($uid) {
		$data = DB::fetch_all("SELECT * FROM %t WHERE uid=%i AND status !=2",array($this->_table,$uid));
		return $data;
		
	}

	public function fetch_all_uid(){
		$data = DB::fetch_all("SELECT * FROM %t WHERE status !=2",array($this->_table));
		return $data;
	}

	public function count_by_search($uid){
		return DB::result_first("SELECT count(*) FROM %t WHERE uid=%i",array($this->_table,$uid));
	}

	public function fetch_score($uid) {
        $score = DB::result_first('SELECT SUM(score) FROM %t WHERE uid=%i', array($this->_table,$uid));
		return $score;
    }
}
?>
