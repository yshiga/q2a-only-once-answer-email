<?php
/*
	Plugin Name: only once answer mail
	Plugin URI: 
	Plugin Description: send advice mail to users that are only once answer X days ago
	Plugin Version: 0.3
	Plugin Date: 2015-10-20
	Plugin Author:
	Plugin Author URI:
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.7
	Plugin Update Check URI: 
*/
/*
## cron setting  

0 8 * * * {qa-root-path}/qa-plugin/q2a-only-once-answer-email/send-email.php 

*/
if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

qa_register_plugin_module('module', 'q2a-only-once-answer-admin.php', 'q2a_only_once_answer_admin', 'only once answer mail');

function getXdaysAgoOnlyOnceAnswerPosts($days) {
	$days_from = $days;
	$days_to = $days + 1;
	$sql = "select * from";
	$sql .= " (select userid,count(postid) as postcount,datediff(current_date,created) as dfday,type";
	$sql .= " from qa_posts group by userid) t0";
	$sql .= " where postcount=1 and userid is not null and type='A'";
	$sql .= " and dfday >= " . $days_from . " and dfday < " . $days_to;
	$result = qa_db_query_sub($sql); 
	return qa_db_read_all_assoc($result);
}


