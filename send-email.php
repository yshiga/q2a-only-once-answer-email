<?php
if (!defined('QA_VERSION')) { 
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
	require_once QA_INCLUDE_DIR.'app/emails.php';
}

$LIMIT = qa_opt('q2a-only-once-answer-day');	// 閾値：日数
if (!is_numeric($LIMIT) or $LIMIT == '0') {
	return;
}

$posts = getXdaysAgoOnlyOnceAnswerPosts($LIMIT);
foreach($posts as $post){
	$user = getUserInfo($post['userid']);
	$handle = $user[0]['handle'];
	$email = $user[0]['email'];
$title = "plugin08 title";
	$bodyTemplate = qa_opt('q2a-only-once-answer-body');
	$body = strtr($bodyTemplate, 
		array(
			'^username' => $handle,
			'^sitename' => qa_opt('site_title')
		)
	);
	sendEmail($title, $body, $handle, $email);
}

function sendEmail($title, $body, $toname, $toemail){

	$params['fromemail'] = qa_opt('from_email');
	$params['fromname'] = qa_opt('site_title');
	$params['subject'] = '【' . qa_opt('site_title') . '】' . $title;
	$params['body'] = $body;
	$params['toname'] = $toname;
	$params['toemail'] = $toemail;
	$params['html'] = false;

	qa_send_email($params);

	//$params['toemail'] = 'yuichi.shiga@gmail.com';
	$params['toemail'] = 'ryuta_takeyama@nexyzbb.ne.jp';
	qa_send_email($params);
}
function getUserInfo($userid) {
    $sql = 'select email,handle from qa_users where userid=' . $userid;
    $result = qa_db_query_sub($sql);
    return qa_db_read_all_assoc($result);
}
