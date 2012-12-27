<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// theme replacement functions

		function head_custom()
		{
			qa_html_theme_base::head_custom();
			if(in_array($this->template, array('question','ask','not-found')) && qa_opt('confirm_close_plugin')) { 
				$this->output('<script type="text/javascript">
jQuery("document").ready(function() {

	jQuery("form").submit(function(event) {
		window.onbeforeunload = null;
	});

	window.onbeforeunload = function(event) {
		var content = false
		jQuery("textarea:visible").each( function() {
			if(this.value) {
				content = true;
				return false;
			}
		});
		if (content)
			return "다른 화면으로 이동하면 입력하던 내용은 모두 사라집니다. 계속할까요?";

	}
});
</script>');
			}
		}
	}

