<?php
	
/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-include/qa-lang-emails.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Language phrases for email notifications


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

	return array(
		'a_commented_body' => "당신의 답변에 ^c_handle님이 의견을 달았습니다.^open^c_content^close\n\n당신의 답변 : ^open^c_context^close\n\n확인하려면 아래 링크를 클릭해 주세요.\n^url\n\nThank you,\n^site_title",
		'a_commented_subject' => '당신의 답변에 새로운 의견이 달렸습니다 - ^site_title',

		'a_followed_body' => "당신의 답변 ^open^a_content^close에 ^q_handle님이 연관된 질문을 등록했습니다 : ^open^q_title^close\n\n확인하려면 아래 링크를 클릭해 주세요.\n^url\n\nThank you,\n^site_title",
		'a_followed_subject' => '당신의 답변에 연관된 질문이 등록되었습니다 - ^site_title',

		'a_selected_body' => "축하합니다! 당신의 답변이 ^s_handle님에게 채택되었습니다 :^open^a_content^close\n\n질문제목:^open^q_title^close\n\n확인하려면 아래 링크를 클릭해 주세요.\n^url\n\nThank you,\n^site_title",
		'a_selected_subject' => '당신의 답변이 채택되었습니다! - ^site_title',

		'c_commented_body' => "당신의 의견 이후에 ^c_handle님이 새 의견을 달았습니다. ^open^c_content^close\n\n이전 의견:^open^c_context^close\n\n확인하려면 아래 링크를 클릭해 주세요.\n^url\n\nThank you,\n^site_title",
		'c_commented_subject' => '새로운 의견이 달렸습니다 - ^site_title',

		'confirm_body' => "Please click below to confirm your email address for ^site_title.\n\n^url\n\nThank you,\n^site_title",
		'confirm_subject' => '^site_title - Email Address Confirmation',

		'feedback_body' => "Comments:\n^message\n\nName:\n^name\n\nEmail:\n^email\n\nPrevious page:\n^previous\n\nUser:\n^url\n\nIP address:\n^ip\n\nBrowser:\n^browser",
		'feedback_subject' => '^ feedback',

		'flagged_body' => "A post by ^p_handle has received ^flags:\n\n^open^p_context^close\n\nClick below to see the post:\n\n^url\n\nThank you,\n^site_title",
		'flagged_subject' => '^site_title has a flagged post',

		'moderate_body' => "A post by ^p_handle requires your approval:\n\n^open^p_context^close\n\nClick below to approve or reject the post:\n\n^url\n\nThank you,\n^site_title",
		'moderate_subject' => '^site_title moderation',

		'new_password_body' => "Your new password for ^site_title is below.\n\nPassword: ^password\n\nIt is recommended to change this password immediately after logging in.\n\nThank you,\n^site_title\n^url",
		'new_password_subject' => '^site_title - Your New Password',

		'private_message_body' => "You have been sent a private message by ^f_handle on ^site_title:\n\n^open^message^close\n\n^moreThank you,\n^site_title\n\n\nTo block private messages, visit your account page:\n^a_url",
		'private_message_info' => "More information about ^f_handle:\n\n^url\n\n",
		'private_message_reply' => "Click below to reply to ^f_handle by private message:\n\n^url\n\n",
		'private_message_subject' => 'Message from ^f_handle on ^site_title',

		'q_answered_body' => "당신의 질문에 ^a_handle님이 답변했습니다:^open^a_content^close\n\n당신의 질문 제목:^open^q_title^close\n\n답변이 도움이 되었거나 질문을 해결해 주었다면 아래 링크를 통해 이동 후 채택해 주세요!\n^url\n\nThank you,\n^site_title",
		'q_answered_subject' => '당신의 질문에 답변이 달렸습니다 - ^site_title',

		'q_commented_body' => "당신의 질문에 ^c_handle님이 의견을 달았습니다:^open^c_content^close\n\n당신의 질문 제목:^open^c_context^close\n\n의견에 새로운 의견을 달려면 아래 링크를 통해 이동해주세요:\n^url\n\nThank you,\n^site_title",
		'q_commented_subject' => '당신의 질문에 새로운 의견이 달렸습니다- ^site_title',

		'q_posted_body' => "^q_handle님이 새 질문을 등록했습니다:\n^open^q_title\n\n^q_content^close\n\n아래 링크를 클릭해 주세요:\n^url\n\nThank you,\n^site_title",
		'q_posted_subject' => '새 질문이 등록되었습니다 - ^site_title',

		'reset_body' => "Please click below to reset your password for ^site_title.\n\n^url\n\nAlternatively, enter the code below into the field provided.\n\nCode: ^code\n\nIf you did not ask to reset your password, please ignore this message.\n\nThank you,\n^site_title",
		'reset_subject' => '^site_title - Reset Forgotten Password',

		'to_handle_prefix' => "^,\n\n",

		'welcome_body' => "Thank you for registering for ^site_title.\n\n^custom^confirmYour login details are as follows:\n\nEmail: ^email\nPassword: ^password\n\nPlease keep this information safe for future reference.\n\nThank you,\n^site_title\n^url",
		'welcome_confirm' => "Please click below to confirm your email address.\n\n^url\n\n",
		'welcome_subject' => 'Welcome to ^site_title!',
	);
	

/*
	Omit PHP closing tag to help avoid accidental output
*/