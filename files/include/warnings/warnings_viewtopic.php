<?php
//$Id$
// Make sure no one attempts to run this script "directly"
if (!defined('PUN'))
	exit;

// Load the warnings.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/warnings.php';
if ($pun_config['o_warnings_enabled'] == '1') {
  if (($pun_user['g_id'] == PUN_ADMIN || ($pun_user['is_admmod'] && $pun_config['o_warnings_mod_add'] == '1'))) {
	$post_actions[] = '<li class="postreport"><span><a href="warnings.php?warn='.$cur_post['poster_id'].'&amp;pid='.$cur_post['id'].'">'.$lang_warnings['Warn'].'</a></span></li>';
	}			

  if ($cur_post['warning']) {

	$result2 = $db->query('SELECT type_id, title FROM '.$db->prefix.'warnings WHERE id='.$cur_post['warning']) or error('Unable to load posts', __FILE__, __LINE__, $db->error());

	/* fetch associative array */
	while ($row = $result2->fetch_assoc()) {
		$warning["type_id"] = $row["type_id"];
		$warning["title"] = $row["title"];
	}

	$result2->free(); // free result set

	// If the warning row consists the type of warnings
	if ($warning["type_id"]) {
		// We fetching types of the warnings by ID and getting the title
		$result2 = $db->query('SELECT title FROM '.$db->prefix.'warning_types WHERE id='.$warning["type_id"]) or error('Unable to load warning types', __FILE__, __LINE__, $db->error());
		$cur_post['warning_title'] = $db->result($result2);
		$result2->free();
	} else {
		$cur_post['warning_title'] = $warning["title"]; // Else we showing the title from the warnings table
	}

    $cur_post['warning_title'] = '<div style="background: url(\'img/warning.png\') no-repeat #FFF6BF 5px 5px; padding: 1em;padding-left: 3.5em;  border: 2px solid #FFD324; color: #817134;">'.$lang_warnings['Warning'].': '.$cur_post['warning_title'].'</div>';
    unset ($cur_post['signature']); // Signature is not allowed for rules perpetrator at least now.
  }
}

//todo Ищем в warnings.php "// MOD" и документируем
?>
