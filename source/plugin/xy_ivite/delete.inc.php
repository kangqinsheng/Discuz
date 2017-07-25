<?php
	DB::query("DELETE FROM ".DB::table("xyivite_ivite")." WHERE uid=163");
	DB::query("DELETE FROM ".DB::table("xyivite_apply")." WHERE uid=163");
?>