<?php
  //$Id: profile_delete.php 2 2017-04-13 16:06:22Z denis $
	// Delete user's warnings
	$db->query('DELETE FROM '.$db->prefix.'warnings WHERE user_id='.$id) or error('Unable to delete user\'s warnings', __FILE__, __LINE__, $db->error());

?>