## $Id$
##
##        Mod title:  DS Auto Warnings
##
##      Mod version:  1.1
##  Works on FluxBB:  1.5.10, 1.5.11
##     Release date:  2020-08-18
##           Author:  DenisVS (deniswebcomm@gmail.com)
##         Based on:  Auto Warnings 1.0 by Koos (pampoen10@yahoo.com)
##
##      Description:  Adds warning/infraction system to your forum.
##      DS features:  Works with current version of PMS New, displays warning labels in the wrong posts.
##
##   Affected files:  footer.php
##                    profile.php
##                    viewtopic.php
##
##       Affects DB:  New tables:
##                       'warnings'
##                       'warning_levels'
##                       'warning_types'
##                    New options in 'config' table:
##                       'o_warnings_enabled'
##                       'o_warnings_custom'
##                       'o_warnings_see_status'
##                       'o_warnings_mod_add'
##                       'o_warnings_mod_remove'
##                    New column in 'post' table:
##                       'warning'
##
##       DISCLAIMER:  Please note that "mods" are not officially supported by
##                    FluxBB. Installation of this modification is done at your
##                    own risk. Backup your forum database and any and all
##                    applicable files before proceeding.
##


#
#---------[ 1. UPLOAD ]-------------------------------------------------------
#

Upload all files and folders contained in archive to forum root.
Keep folder structure intact.


#
#---------[ 2. RUN ]----------------------------------------------------------
#

install_mod.php


#
#---------[ 3. DELETE ]-------------------------------------------------------
#

install_mod.php


#
#---------[ 4. OPEN ]---------------------------------------------------------
#

footer.php


#
#---------[ 5. FIND (line: 47) ]----------------------------------------------
#

$footer_style = isset($footer_style) ? $footer_style : NULL;


#
#---------[ 6. AFTER, ADD ]----------------------------------------------------
#

// WARNINGS MOD:
require PUN_ROOT.'include/warnings/footer_links.php';


#
#---------[ 7. OPEN ]----------------------------------------------------------
#

profile.php


#
#---------[ 8. FIND (line: 617) ]----------------------------------------------
#

		redirect('index.php', $lang_profile['User delete redirect']);


#
#---------[ 9. BEFORE, ADD ]---------------------------------------------------
#

		// WARNINGS MOD: Delete all the user's warnings
		require PUN_ROOT.'include/warnings/profile_delete.php';


#
#---------[ 8. FIND (line: 1048) ]---------------------------------------------
#

	if ($user['num_posts'] > 0)
	{
		$user_activity[] = '<dt>'.$lang_common['Last post'].'</dt>';
		$user_activity[] = '<dd>'.$last_post.'</dd>';
	}


#
#---------[ 9. BEFORE, ADD ]---------------------------------------------------
#

	// WARNINGS MOD:
	require PUN_ROOT.'include/warnings/warnings_profile2.php';


#
#---------[ 10. FIND (line: 1221) ]--------------------------------------------
#

							<?php echo $posts_field ?>


#
#---------[ 11. AFTER, ADD ]---------------------------------------------------
#

<?php
// WARNINGS MOD:
require PUN_ROOT.'include/warnings/warnings_profile.php'; 
?>


#
#---------[ 12. OPEN ]---------------------------------------------------------
#

viewtopic.php


#
#---------[ 13. FIND ]---------------------------------------------
#

p.edited_by, 					

#
#---------[ 14. AFTER, ADD ]---------------------------------------------------
#

 p.warning,		


#
#---------[ 15. FIND (line: 268) ]---------------------------------------------
#

	// Generation post action array (quote, edit, delete etc.)


#
#---------[ 16. AFTER, ADD ]---------------------------------------------------
#

	// WARNINGS MOD:
	require PUN_ROOT.'include/warnings/warnings_viewtopic.php';

#
#---------[ 17. FIND ]---------------------------------------------
#

<?php echo $cur_post['message']."\n" ?>

#
#---------[ 18. AFTER, ADD ]---------------------------------------------------
#

<?php if ($cur_post['warning_title']) echo $cur_post['warning_title']; // WARNINGS MOD: Show warning in the post ?>


