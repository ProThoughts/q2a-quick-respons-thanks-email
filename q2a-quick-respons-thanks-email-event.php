<?php
if (!defined('QA_VERSION')) { 
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
   require_once QA_INCLUDE_DIR.'app/emails.php';
}

class q2a_quick_respons_thanks_email_event
{
	function process_event ($event, $userid, $handle, $cookieid, $params)
	{
		if ($event != 'a_post')
			return;

		$LIMIT = '01:00:00';	// 閾値：時間

		$quickflag = 0;
		$posts = $this->getQuickResposFlag($params['postid'], $LIMIT);
		foreach($posts as $post){
			$quickflag = $post["quickflag"];
		}
$fp = fopen("/tmp/plugin02.log", "a+");
$outs = "--------------------------\n";
$outs .= "postid[" . $params['postid'] . "] userid[" . $userid . "]\n";
$outs .= "quickflag:".$quickflag."\n";
fputs($fp, $outs);
fclose($fp);

		if ($quickflag == 1) {
			$user = $this->getUserInfo($userid);
			$handle = $user[0]['handle'];
			$email = $user[0]['email'];
			$title = "素早い回答ありがとうございます。";
/*************
			$bodyTemplate = qa_opt('q2a-quick-thanks-body');
			$body = strtr($bodyTemplate, 
				array(
					'^username' => $handle,
					'^sitename' => qa_opt('site_title')
				)
			);
**************/
$body = "本文です。素早い回答をしていただき感謝しております。";
			$this->sendEmail($title, $body, $handle, $email);
		}
		return;
	}

	function sendEmail($title, $body, $toname, $toemail)
	{

		$params['fromemail'] = qa_opt('from_email');
		$params['fromname'] = qa_opt('site_title');
		$params['subject'] = '【' . qa_opt('site_title') . '】' . $title;
		$params['body'] = $body;
		$params['toname'] = $toname;
		$params['toemail'] = $toemail;
		$params['html'] = false;
$fp = fopen("/tmp/plugin02.log", "a+");
$outs = $params['fromemail']."\n";
fputs($fp, $outs);
$outs = $params['fromname'] . "\n";
fputs($fp, $outs);
$outs = $params['subject'] . "\n";
fputs($fp, $outs);
$outs = $params['body'] . "\n";
fputs($fp, $outs);
$outs = $params['toname'] . "\n";
fputs($fp, $outs);
$outs = $params['toemail'] . "\n";
fputs($fp, $outs);
fclose($fp);

		qa_send_email($params);

		//$params['toemail'] = 'yuichi.shiga@gmail.com';
		$params['toemail'] = 'ryuta9.takeyama6@gmail.com';
		qa_send_email($params);
	}

	function getQuickResposFlag($a_postid, $limit)
	{
		$sql = "select count(postid) as quickflag from";
		$sql .= " (select t2.postid,timediff(now(),t2.created) as dftime from";
		$sql .= " (select * from q2adb.qa_posts where postid=" . $a_postid . ") as t1";
		$sql .= " left join q2adb.qa_posts as t2 on t1.parentid=t2.postid) t0";
		$sql .= " where dftime <= '" . $limit . "'";
		$result = qa_db_query_sub($sql); 
		return qa_db_read_all_assoc($result);
	}

	function getUserInfo($userid)
	{
		$sql = 'select email,handle from qa_users where userid=' . $userid;
		$result = qa_db_query_sub($sql);
		return qa_db_read_all_assoc($result);
	}
}

/*
    Omit PHP closing tag to help avoid accidental output
*/
