<?php

/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-include/qa-external-users-wp.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: External user functions for WordPress integration


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

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}


	function qa_get_mysql_user_column_type()
	{
		return 'BIGINT UNSIGNED';
	}


	function qa_get_login_links($relative_url_prefix, $redirect_back_to_url)
	{
		return array(
			'login' => wp_login_url(qa_opt('site_url').$redirect_back_to_url),
			'register' => site_url('wp-login.php?action=register'),
			'logout' => strtr(wp_logout_url(), array('&amp;' => '&')),
		);
	}
	

	function qa_get_logged_in_user()
	{
		$wordpressuser=wp_get_current_user();
		
		if ($wordpressuser->ID==0)
			return null;

		else {
			if (current_user_can('administrator'))
				$level=QA_USER_LEVEL_ADMIN;
			elseif (current_user_can('editor'))
				$level=QA_USER_LEVEL_EDITOR;
			elseif (current_user_can('contributor'))
				$level=QA_USER_LEVEL_EXPERT;
			else
				$level=QA_USER_LEVEL_BASIC;
			
			return array(
				'userid' => $wordpressuser->ID,
				'publicusername' => $wordpressuser->user_nicename,
				'displayname' => $wordpressuser->display_name,
				'email' => $wordpressuser->user_email,
				'level' => $level,
			);
		}
	}

	
	function qa_get_user_email($userid)
	{
		$user=get_userdata($userid);

		return @$user->user_email;
	}
	

	function qa_get_userids_from_public($publicusernames)
	{
		global $wpdb;

		if (count($publicusernames))
			return qa_db_read_all_assoc(qa_db_query_sub(
				'SELECT user_nicename, ID FROM '.$wpdb->base_prefix.'users WHERE user_nicename IN ($)',
				$publicusernames
			), 'user_nicename', 'ID');
		else
			return array();
	}

	// Use this List
	function qa_get_public_from_userids($userids)
	{
		global $wpdb, $qa_cache_wp_user_emails;

		if (count($userids)) {
			$useridtopublic=array();
			$qa_cache_wp_user_emails=array();
			
			$userfields=qa_db_read_all_assoc(qa_db_query_sub(
				'SELECT ID, user_nicename, display_name, user_email FROM '.$wpdb->base_prefix.'users WHERE ID IN (#)',
				$userids
			), 'ID');
			
			foreach ($userfields as $id => $fields) {
				$useridtopublic[$id]['displayname']=$fields['display_name'];
				$useridtopublic[$id]['publicname']=$fields['user_nicename'];
				$qa_cache_wp_user_emails[$id]=$fields['user_email'];
			}
			
			return $useridtopublic;

		} else
			return array();
	}


	function qa_get_logged_in_user_html($logged_in_user, $relative_url_prefix)
	{
		$publicusername=$logged_in_user['publicusername'];
		$displayName = $logged_in_user['displayname'];
		
		return '<A HREF="'.htmlspecialchars($relative_url_prefix.'user/'.urlencode($publicusername)).
			'" CLASS="qa-user-link">'.htmlspecialchars($displayName).'</A>';
	}


	function qa_get_users_html($userids, $should_include_link, $relative_url_prefix)
	{
		$useridtopublic=qa_get_public_from_userids($userids);
		$usershtml=array();

		foreach ($userids as $userid) {
			$publicusername=$useridtopublic[$userid]['publicname'];
			$displayusername=$useridtopublic[$userid]['displayname'];			

			$usershtml[$userid]=htmlspecialchars($publicusername);
			
			if ($should_include_link)
				$usershtml[$userid]='<A HREF="'.htmlspecialchars($relative_url_prefix.'user/'.urlencode($publicusername)).
					'" CLASS="qa-user-link">'.$displayusername.'</A>';
			else
				$usershtml[$userid]= $displayusername;
		}
		return $usershtml;
	}
	
	
	function qa_avatar_html_from_userid($userid, $size, $padding)
	{
		require_once QA_INCLUDE_DIR.'qa-app-format.php';		
		global $qa_cache_wp_user_emails;
		
		$avatar = get_bp_avatar($userid, 30);
		$avatar = '<span class="thumb-avatar">'.$avatar.'</span>';
		if( isset( $avatar ) )
			return $avatar;
		else 
			return null;
	}
	
	function get_bp_avatar($uid, $size, $type='thumb')
	{
		$user_info = get_userdata($uid);
		$email = $user_info->user_email;

		$avatar = bp_core_fetch_avatar( array( 'item_id' => $uid, 'type'=> $type, 'width' => $size, 'height' => $size, 'email' => $email ) );
		
		return $avatar;
	}


	function qa_user_report_action($userid, $action)
	{
	}


/*
	Omit PHP closing tag to help avoid accidental output
*/