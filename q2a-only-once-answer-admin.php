<?php
class q2a_only_once_answer_admin {
	function init_queries($tableslc) {
		return null;
	}
	function option_default($option) {
		switch($option) {
			case 'q2a-only_once_answer-day':
				return 10; 
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
		if (qa_clicked('q2a-only_once_answer-save')) {
			qa_opt('q2a-only_once_answer-body', qa_post_text('q2a-only_once_answer-body'));
			qa_opt('q2a-only_once_answer-day', (int)qa_post_text('q2a-only_once_answer-day'));
			$ok = qa_lang('admin/options_saved');
		}
		
		// form fields to display frontend for admin
		$fields = array();
		
		$fields[] = array(
			'type' => 'textarea',
			'label' => '本文',
			'tags' => 'name="q2a-only_once_answer-body"',
			'value' => qa_opt('q2a-only_once_answer-body'),
		);

		$fields[] = array(
			'type' => 'number',
			'label' => 'mail day',
			'tags' => 'name="q2a-only_once_answer-day"',
			'value' => qa_opt('q2a-only_once_answer-day'),
		);
		
		return array(     
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="q2a-only_once_answer-save"',
				),
			),
		);
	}
}

