//$Id$
//Based on:  Auto Warnings 1.0 by Koos (pampoen10@yahoo.com)
***Changed
readme.txt

*********
install_mod.php

Add column "warning" type "unsigned int" after "edit_post" into the table "posts"
Drop column "warning" from the table "posts"


*********
warnings.php


* Find

			$db->query('INSERT INTO '.$db->prefix.'pms_new_posts (poster, poster_id, poster_ip, message, hide_smilies, posted, post_seen, post_new, topic_id) VALUES(\''.$db->escape($pun_user['username']).'\', '.$pun_user['id'].', \''.$db->escape(get_remote_address()).'\',  \''.$db->escape($message).'\', '.'\'1\''.', '.$now.', 0, 1, '.$new_tid.')') or error('Unable to create pms_new_posts', __FILE__, __LINE__, $db->error());


* replace with

			$db->query('INSERT INTO '.$db->prefix.'pms_new_posts (poster, poster_id, poster_ip, message, hide_smilies, posted, post_new, topic_id) VALUES(\''.$db->escape($pun_user['username']).'\', '.$pun_user['id'].', \''.$db->escape(get_remote_address()).'\',  \''.$db->escape($message).'\', '.'\'1\''.', '.$now.', 1, '.$new_tid.')') or error('Unable to create pms_new_posts', __FILE__, __LINE__, $db->error());

*******

include/warnings/warnings_viewtopic.php





****

* Find
			//Insert warning
			$db->query('INSERT INTO '.$db->prefix.'warnings (user_id, type_id, post_id, title, points, date_issued, date_expire, issued_by, expired, note_admin, note_post, note_pm) VALUES('.$user_id.', '.$warning_type.', '.$post_id.', \'\', '.$warning_points.', '.$now.', '.$expiration_date.', '.$pun_user['id'].', \'0\', \''.$db->escape($note_admin).'\', \''.$db->escape($note_post).'\', \''.$db->escape($note_pm).'\')') or error('Unable to insert warning', __FILE__, __LINE__, $db->error());
		}

* Add after

		// MOD insert warning ID into the posts table
		$lastWarning = $db->insert_id();
		$db->query('UPDATE '.$db->prefix.'posts SET warning='.$lastWarning.' WHERE id='.$post_id) or error('Unable to update the message.', __FILE__, __LINE__, $db->error());


************

* Find

	// Delete the warning
	$db->query('DELETE FROM '.$db->prefix.'warnings WHERE id='.$_POST['delete_id']) or error('Unable to delete warning', __FILE__, __LINE__, $db->error());

* Add Before

	// MOD delete the warning ID from the posts table
	$result = $db->query('SELECT post_id FROM '.$db->prefix.'warnings WHERE id='.$_POST['delete_id']) or error('Unable to load posts', __FILE__, __LINE__, $db->error());
	$post_id = $db->result($result);
	$db->query('UPDATE '.$db->prefix.'posts SET warning=0 WHERE id='.$post_id) or error('Unable to update the warning.', __FILE__, __LINE__, $db->error());




***Added
img/warning.png



