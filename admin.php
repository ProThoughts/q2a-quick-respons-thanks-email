<?php
class q2a_quick_respons_thanks_admin {
	function init_queries($tableslc) {
		return null;
	}
	function option_default($option) {
		switch($option) {
			case 'q2a-quick-respons-thanks-body':
				return ''; 
			default:
				return null;
		}
	}
		
	function allow_template($template) {
		return ($template!='admin');
	}       
		
	function admin_form(&$qa_content){                       
		// process the admin form if admin hit Save-Changes-button
		$ok = null;
		if (qa_clicked('q2a-quick-respons-thanks-save')) {
			qa_opt('q2a-quick-respons-thanks-body', qa_post_text('q2a-quick-respons-thanks-body'));
			$ok = qa_lang('admin/options_saved');
		}
		
		// form fields to display frontend for admin
		$fields = array();
		
		$fields[] = array(
			'type' => 'textarea',
			'label' => '本文',
			'tags' => 'name="q2a-quick-respons-thanks-body"',
			'value' => qa_opt('q2a-quick-respons-thanks-body'),
		);

		return array(     
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="q2a-quick-respons-thanks-save"',
				),
			),
		);
	}
}
