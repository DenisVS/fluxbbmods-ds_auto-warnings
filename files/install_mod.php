<?php

//$Id$

/***********************************************************************/

// Some info about your mod.
//Based on:  Auto Warnings 1.0 by Koos (pampoen10@yahoo.com)
$mod_title      = 'DS Auto Warnings';
$mod_version    = '1.1';
$release_date   = '2020-08-18';
$author         = 'DenisVS';
$author_email   = 'deniswebcomm@gmail.com';
// Set this to false if you haven't implemented the restore function (see below)
$mod_restore	= true;


// This following function will be called when the user presses the "Install" button
function install()
{
	global $db, $db_type, $pun_config;



	$db->add_field('posts', 'warning', 'TINYINT(1) UNSIGNED', true, NULL, 'topic_id') or error('Unable to add column "warning" to table "posts"', __FILE__, __LINE__, $db->error());


	//New Install
	if (!$db->table_exists('warnings'))
	{
		$schema = array(
			'FIELDS'		=> array(
				'id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'user_id'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'type_id'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'post_id'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'title'			=> array(
					'datatype'		=> 'VARCHAR(120)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'points'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'date_issued'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'date_expire'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'issued_by'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'expired'		=> array(
					'datatype'		=> 'TINYINT(1)',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'note_admin'		=> array(
					'datatype'		=> 'TEXT',
					'allow_null'	=> true
				),
				'note_post'		=> array(
					'datatype'		=> 'MEDIUMTEXT',
					'allow_null'	=> true
				),
				'note_pm'		=> array(
					'datatype'		=> 'TEXT',
					'allow_null'	=> true
				)
			),
			'PRIMARY KEY'	=> array('id'),
		);

		$db->create_table('warnings', $schema) or error('Unable to create table '.$db->prefix.'warnings.', __FILE__, __LINE__, $db->error());
	}

	if (!$db->table_exists('warning_types'))
	{
		$schema = array(
			'FIELDS'		=> array(
				'id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'title'			=> array(
					'datatype'		=> 'VARCHAR(120)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'description'		=> array(
					'datatype'		=> 'TEXT',
					'allow_null'	=> true
				),
				'points'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'expiration_time'	=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				)
			),
			'PRIMARY KEY'	=> array('id'),
		);

		$db->create_table('warning_types', $schema) or error('Unable to create table '.$db->prefix.'warning_types.', __FILE__, __LINE__, $db->error());
	}

	if (!$db->table_exists('warning_levels'))
	{
		$schema = array(
			'FIELDS'		=> array(
				'id'			=> array(
					'datatype'		=> 'SERIAL',
					'allow_null'	=> false
				),
				'points'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				),
				'method'		=> array(
					'datatype'		=> 'VARCHAR(50)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'message'		=> array(
					'datatype'		=> 'VARCHAR(255)',
					'allow_null'	=> false,
					'default'		=> '\'\''
				),
				'period'		=> array(
					'datatype'		=> 'INT(10) UNSIGNED',
					'allow_null'	=> false,
					'default'		=> '0'
				)
			),
			'PRIMARY KEY'	=> array('id'),
		);

		$db->create_table('warning_levels', $schema) or error('Unable to create table '.$db->prefix.'warning_levels.', __FILE__, __LINE__, $db->error());
	}


	// Insert new config option o_warnings_enabled
	if (!array_key_exists('o_warnings_enabled', $pun_config))
		$db->query('INSERT INTO '.$db->prefix.'config (conf_name, conf_value) VALUES (\'o_warnings_enabled\', \'1\')') or error('Unable to insert config value \'o_warnings_enabled\'', __FILE__, __LINE__, $db->error());

	// Insert new config option o_warnings_custom
	if (!array_key_exists('o_warnings_custom', $pun_config))
		$db->query('INSERT INTO '.$db->prefix.'config (conf_name, conf_value) VALUES (\'o_warnings_custom\', \'1\')') or error('Unable to insert config value \'o_warnings_custom\'', __FILE__, __LINE__, $db->error());

	// Insert new config option o_warnings_see_status
	if (!array_key_exists('o_warnings_see_status', $pun_config))
		$db->query('INSERT INTO '.$db->prefix.'config (conf_name, conf_value) VALUES (\'o_warnings_see_status\', \'mods\')') or error('Unable to insert config value \'o_warnings_see_status\'', __FILE__, __LINE__, $db->error());

	// Insert new config option o_warnings_mod_add
	if (!array_key_exists('o_warnings_mod_add', $pun_config))
		$db->query('INSERT INTO '.$db->prefix.'config (conf_name, conf_value) VALUES (\'o_warnings_mod_add\', \'1\')') or error('Unable to insert config value \'o_warnings_mod_add\'', __FILE__, __LINE__, $db->error());

	// Insert new config option o_warnings_mod_remove
	if (!array_key_exists('o_warnings_mod_remove', $pun_config))
		$db->query('INSERT INTO '.$db->prefix.'config (conf_name, conf_value) VALUES (\'o_warnings_mod_remove\', \'0\')') or error('Unable to insert config value \'o_warnings_mod_remove\'', __FILE__, __LINE__, $db->error());


	if ($db_type == 'pgsql' || $db_type == 'sqlite')
		$db->end_transaction();

	// Regenerate the config cache
	if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
		require PUN_ROOT.'include/cache.php';

	generate_config_cache();
}

// This following function will be called when the user presses the "Restore" button (only if $mod_restore is true (see above))
function restore()
{
	global $db, $db_type, $pun_config;

	$db->drop_table('warnings') or error('Unable to remove table', __FILE__, __LINE__, $db->error());
	$db->drop_table('warning_types') or error('Unable to remove table', __FILE__, __LINE__, $db->error());
	$db->drop_table('warning_levels') or error('Unable to remove table', __FILE__, __LINE__, $db->error());
	$db->drop_field('posts', 'warning') or error('Unable to drop column "warning" from table "posts"', __FILE__, __LINE__, $db->error());


	$like_command = ($db_type == 'pgsql') ? 'ILIKE' : 'LIKE';
	$db->query('DELETE FROM '.$db->prefix.'config WHERE conf_name '.$like_command.' \'o_warnings%\'') or error('Unable to remove config entries', __FILE__, __LINE__, $db->error());

	if ($db_type == 'pgsql' || $db_type == 'sqlite')
		$db->end_transaction();

	// Regenerate the config cache
	if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
		require PUN_ROOT.'include/cache.php';

	generate_config_cache();
}

/***********************************************************************/

// DO NOT EDIT ANYTHING BELOW THIS LINE!


// Circumvent maintenance mode
define('PUN_TURN_OFF_MAINT', 1);
define('PUN_ROOT', './');
require PUN_ROOT.'include/common.php';

// We want the complete error message if the script fails
if (!defined('PUN_DEBUG'))
	define('PUN_DEBUG', 1);

$version = explode(".", $pun_config['o_cur_version']);
// Make sure we are running a FluxBB version that this mod works with
if ($version[0].'.'.$version[1] != '1.5')
	exit('You are running a version of FluxBB ('.$pun_config['o_cur_version'].') that this mod does not support. This mod supports FluxBB versions: 1.5.x');

$style = (isset($pun_user)) ? $pun_user['style'] : $pun_config['o_default_style'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo pun_htmlspecialchars($mod_title) ?> installation</title>
<link rel="stylesheet" type="text/css" href="style/<?php echo $style.'.css' ?>" />
</head>
<body>

<div id="punwrap">
<div id="puninstall" class="pun" style="margin: 10% 20% auto 20%">

<?php

if (isset($_POST['form_sent']))
{
	if (isset($_POST['install']))
	{
		// Run the install function (defined above)
		install();

?>
<div class="block">
	<h2><span>Installation successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>Your database has been successfully prepared for <?php echo pun_htmlspecialchars($mod_title) ?>. See readme.txt for further instructions.</p>
		</div>
	</div>
</div>
<?php

	}
	else
	{
		// Run the restore function (defined above)
		restore();

?>
<div class="block">
	<h2><span>Restore successful</span></h2>
	<div class="box">
		<div class="inbox">
			<p>Your database has been successfully restored.</p>
		</div>
	</div>
</div>
<?php

	}
}
else
{

?>
<div class="blockform">
	<h2><span>Mod installation</span></h2>
	<div class="box">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?foo=bar">
			<div><input type="hidden" name="form_sent" value="1" /></div>
			<div class="inform">
				<p>This script will update your database to work with the following modification:</p>
				<p><strong>Mod title:</strong> <?php echo pun_htmlspecialchars($mod_title.' '.$mod_version) ?></p>
				<p><strong>Author:</strong> <?php echo pun_htmlspecialchars($author) ?> (<a href="mailto:<?php echo pun_htmlspecialchars($author_email) ?>"><?php echo pun_htmlspecialchars($author_email) ?></a>)</p>
				<p><strong>Disclaimer:</strong> Mods are not officially supported by FluxBB. Mods generally can't be uninstalled without running SQL queries manually against the database. Make backups of all data you deem necessary before installing.</p>
<?php if ($mod_restore): ?>
				<p>If you've previously installed this mod and would like to uninstall it, you can click the Restore button below to restore the database.</p>
<?php endif; ?>
<?php if ($version_warning): ?>
				<p style="color: #a00"><strong>Warning:</strong> The mod you are about to install was not made specifically to support your current version of FluxBB (<?php echo $pun_config['o_cur_version']; ?>). This mod supports FluxBB versions: <?php echo pun_htmlspecialchars(implode(', ', $fluxbb_versions)); ?>. If you are uncertain about installing the mod due to this potential version conflict, contact the mod author.</p>
<?php endif; ?>
			</div>
			<p class="buttons"><input type="submit" name="install" value="Install" /><?php if ($mod_restore): ?><input type="submit" name="restore" value="Restore" /><?php endif; ?></p>
		</form>
	</div>
</div>
<?php

}

?>

</div>
</div>

</body>
</html>

<?php

// End the transaction
$db->end_transaction();

// Close the db connection (and free up any result data)
$db->close();
