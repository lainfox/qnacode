<?php

/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-theme/qnacode/qa-theme.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Override some theme functions for Snow theme


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

	class qa_html_theme extends qa_html_theme_base
	{	
		
		function head_script() // change style of WYSIWYG editor to match theme better
		{
			qa_html_theme_base::head_script();
		}
		
		function nav_user_search() // outputs login form if user not logged in
		{
			//qa_html_theme_base::nav_user_search();			
			$this->search();
			$this->nav('user');			

			if (!qa_is_logged_in()) {
				$login=@$this->content['navigation']['user']['login'];
			}
		}
	
		function logged_in() // adds points count after logged in username
		{
			qa_html_theme_base::logged_in();

			if (qa_is_logged_in()) {
				$userpoints=qa_get_logged_in_points();
				
				$pointshtml = qa_lang_html_sub('main/x_points', qa_html(number_format($userpoints)));
						
				$this->output(
					'<SPAN CLASS="qa-logged-in-points">',
					'('.$pointshtml.')',
					'</SPAN>'
				);
			}
		}
    
		function body_header() // adds login bar, user navigation and search at top of page in place of custom header content
		{
			$this->output('<div id="qa-login-bar"><div id="qa-login-group">');
			$this->nav_user_search();
            $this->output('</div></div>');
        }
		
		function header_custom() // allows modification of custom element shown inside header after logo
		{
			if (isset($this->content['body_header'])) {
				$this->output('<DIV CLASS="header-banner">');
				$this->output_raw($this->content['body_header']);
				$this->output('</DIV>');
			}
		}
		
		function header() // removes user navigation and search from header and replaces with custom header content. Also opens new <DIV>s
		{	
			$this->output('<DIV CLASS="qa-header">');			
			$this->logo();						
			$this->header_clear();
			$this->header_custom();
			$this->nav('main');
			$this->output('</DIV> <!-- END qa-header -->', '');

			$this->output('<DIV CLASS="qa-main-wrapper">', '');			
		}
		
		function page_title_error()
		{
			if ( isset($this->content['q_view']['url']) )
			{
				$this->content['title'] = '<a href="' . $this->content['q_view']['url'] . '">' . @$this->content['title'] . '</a>';
				if ( @$this->content['q_view']['raw']['closedbyid'] !== null )
					$this->content['title'] .= ' [closed]';
			}

			// remove favourite star here
			$this->favourite = @$this->content['favorite'];
			unset($this->content['favorite']);

			if ( $this->template != 'question' && isset($this->favourite) ) {
				$this->output('<DIV CLASS="qa-favoriting" '.@$this->favourite['favorite_tags'].'>');
				$this->favorite_inner_html($this->favourite);
				$this->output('</DIV>');
			}

			parent::page_title_error();
		}
		
		function main_parts($content)
		{	
			
			// 유저 정보 페이지
			if($this->template == 'user') {
				// 내 유저 페이지면 설정링크 보이기
				$handle=qa_request_part(1);
				$publictouserid=qa_get_userids_from_public(array($handle));
				$userid=reset($publictouserid);
				$loginuserid=qa_get_logged_in_userid();

				if( $loginuserid==$userid ) {
					$this->output('<a class="goto-setting" href="'.bp_loggedin_user_domain().'profile/edit">내 프로필설정</a>');
				}
				
			}
			qa_html_theme_base::main_parts($content);		
		}
		
		function title() // add RSS feed icon after the page title
		{
			qa_html_theme_base::title();
			
			$feed=@$this->content['feed'];
			
			if (!empty($feed))
				$this->output('<a href="'.$feed['url'].'" title="'.@$feed['label'].'"><img src="'.$this->rooturl.'images/rss.jpg" alt="" width="16" height="16" border="0" CLASS="qa-rss-icon"/></a>');
		}
		
		function q_item_stats($q_item) // add view count to question list
		{
			$this->output('<DIV CLASS="qa-q-item-stats">');
			
			$this->voting($q_item);
			$this->a_count($q_item);
			qa_html_theme_base::view_count($q_item);

			$this->output('</DIV>');
		}
		
		function view_count($q_item) // prevent display of view count in the usual place
		{			 
		}
		
		function body_suffix() // to replace standard Q2A footer
        {
			$this->output('<div class="qa-footer-bottom-group">');
			qa_html_theme_base::footer();
			$this->output('</DIV> <!-- END footer-bottom-group -->', '');
        }
		
		function a_item_main($a_item)
		{
			$this->output('<DIV CLASS="qa-a-item-main">');
			
			if (isset($a_item['main_form_tags']))
				$this->output('<FORM '.$a_item['main_form_tags'].'>'); // form for buttons on answer

			if ($a_item['hidden'])
				$this->output('<DIV CLASS="qa-a-item-hidden">');
			elseif ($a_item['selected'])
				$this->output('<DIV CLASS="qa-a-item-selected">');

			$this->a_selection($a_item);
			$this->error(@$a_item['error']);
			
			$this->post_avatar_meta($a_item, 'qa-a-item');
			$this->a_item_content($a_item);
			
			if ($a_item['hidden'] || $a_item['selected'])
				$this->output('</DIV>');
			
			$this->a_item_buttons($a_item);
			
			$this->c_list(@$a_item['c_list'], 'qa-a-item');

			if (isset($a_item['main_form_tags']))
				$this->output('</FORM>');

			$this->c_form(@$a_item['c_form']);

			$this->output('</DIV> <!-- END qa-a-item-main -->');
		}

		function c_item_main($c_item)
		{
			$this->error(@$c_item['error']);
			
			$this->post_avatar_meta($c_item, 'qa-c-item');

			if (isset($c_item['expand_tags']))
				$this->c_item_expand($c_item);
			elseif (isset($c_item['url']))
				$this->c_item_link($c_item);
			else
				$this->c_item_content($c_item);
			
			$this->output('<DIV CLASS="qa-c-item-footer">');			
			$this->c_item_buttons($c_item);
			$this->output('</DIV>');
		}
		
		function voting($post)
		{
			if (isset($post['vote_view'])) {

				if ( $this->template == 'question' )
					$this->output('<div style="float:left; width:56px">');

				$this->output('<DIV CLASS="qa-voting '.(($post['vote_view']=='updown') ? 'qa-voting-updown' : 'qa-voting-net').'" '.@$post['vote_tags'].' >');
				$this->voting_inner_html($post);
				$this->output('</DIV>');

				if ( $this->template == 'question' )
				{
					// add favourite star back
					if ( $post['raw']['type'] == 'Q' && isset($this->favourite) )
					{
						$this->output('<DIV style="text-align:center" '.@$this->favourite['favorite_tags'].'>');
						$this->favorite_inner_html($this->favourite);
						$this->output('</DIV>');
					}
					$this->view_count($post);
				}

				if ( $this->template == 'question' )
					$this->output('</div>');
			}
		}

		function voting_inner_html($post)
		{
			$this->vote_button_up($post);
			$this->vote_count($post);
			$this->vote_button_down($post);
			$this->vote_clear();
		}

		function vote_button_up($post)
		{
			$this->output('<DIV CLASS="qa-vote-buttons '.(($post['vote_view']=='updown') ? 'qa-vote-buttons-updown' : 'qa-vote-buttons-net').'">');

			switch (@$post['vote_state'])
			{
				case 'voted_down':
				case 'voted_down_disabled':
					break;
				case 'voted_up':
					$this->post_hover_button($post, 'vote_up_tags', '', 'qa-vote-one-button qa-voted-up');
					break;
				case 'voted_up_disabled':
					$this->post_disabled_button($post, 'vote_up_tags', '', 'qa-vote-one-button qa-vote-up');
					break;
				case 'enabled':
					$this->post_hover_button($post, 'vote_up_tags', '', 'qa-vote-first-button qa-vote-up');
					break;
				default:
					$this->post_disabled_button($post, 'vote_up_tags', '', 'qa-vote-first-button qa-vote-up');
					break;
			}

			$this->output('</DIV>');
		}

		function vote_button_down($post)
		{
			$this->output('<DIV CLASS="qa-vote-buttons '.(($post['vote_view']=='updown') ? 'qa-vote-buttons-updown' : 'qa-vote-buttons-net').'">');

			switch (@$post['vote_state'])
			{
				case 'voted_up':
				case 'voted_up_disabled':
					break;
				case 'voted_down':
					$this->post_hover_button($post, 'vote_down_tags', '', 'qa-vote-one-button qa-voted-down');
					break;
				case 'voted_down_disabled':
					$this->post_disabled_button($post, 'vote_down_tags', '', 'qa-vote-one-button qa-vote-down');
					break;
				case 'enabled':
					$this->post_hover_button($post, 'vote_down_tags', '', 'qa-vote-second-button qa-vote-down');
					break;
				default:
					$this->post_disabled_button($post, 'vote_down_tags', '', 'qa-vote-second-button qa-vote-down');
					break;
			}

			$this->output('</DIV>');
		}

		function vote_count($post)
		{
			$post['netvotes_view']['data'] = str_replace( '+', '', $post['netvotes_view']['data'] );
			parent::vote_count($post);
		}


		function main()
		{
			$content=$this->content;

			$this->output('<DIV CLASS="qa-main'.(@$this->content['hidden'] ? ' qa-main-hidden' : '').'">');
			$this->nav('sub');
			$this->widgets('main', 'top');
			
			$this->page_title_error();		
			
			$this->widgets('main', 'high');

			/*if (isset($content['main_form_tags']))
				$this->output('<FORM '.$content['main_form_tags'].'>');*/
				
			$this->main_parts($content);
		
			/*if (isset($content['main_form_tags']))
				$this->output('</FORM>');*/
				
			$this->widgets('main', 'low');

			$this->page_links();
			$this->suggest_next();
			
			$this->widgets('main', 'bottom');

			$this->output('</DIV> <!-- END qa-main -->', '');
		}		

		function attribution()
		{
			$this->output(
				'<span class="qa-attribution">',
				'2012 &copy; <a href="http://qnacode.com" class="copyright">QnAcode</a>',
				'</span>'
			);
			//qa_html_theme_base::attribution();
		}
		
		function footer() 
		{			
			$this->output('</DIV> <!-- END main-wrapper -->');	
			// wp_footer(); top Admin bar
			$this->output('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>');
			$this->output('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>');
			$this->output('<script src="'.$this->rooturl.'qnacode.js"></script>');
			$this->output('<link REL="stylesheet" HREF="'.$this->rooturl.'/prettify/prettify.css" />');
			$this->output('<script src="'.$this->rooturl.'/prettify/prettify.js"></script>');
		}	
		
		/*
		function doctype() 
        { 
            qa_html_theme_base::doctype(); 
            if(isset($this->content['a_form'])) { 
                $a_form = $this->content['a_form']; 
                unset($this->content['a_form']); 
                $this->content['a_form'] = $a_form; 
            } 
        }
		*/
	}
	 

/*
	Omit PHP closing tag to help avoid accidental output
*/