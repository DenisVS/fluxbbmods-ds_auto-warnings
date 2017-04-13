<?php
//$Id: footer_links.php 2 2017-04-13 16:06:22Z denis $
if ($footer_style != 'warnings') {
?>
			<dl id="searchlinks" class="conl">
				<dt><strong>Warning links</strong></dt>
<?php
echo "\t\t\t\t\t\t".'<dd><a href="warnings.php">'.$lang_warnings['Show warning types'].'</a></dd>'."\n";

if ($pun_user['is_admmod'])
	echo "\t\t\t\t\t\t".'<dd><a href="warnings.php?action=show_recent">'.$lang_warnings['Show recent warnings'].'</a></dd>'."\n";
?>
			</dl>
<?php
}
