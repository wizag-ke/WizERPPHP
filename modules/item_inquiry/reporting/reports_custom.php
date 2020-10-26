<?php

global $reports;

//$path_to_root = "..";

$reports->addReport(RC_INVENTORY, "1001", _('Inquired Items Report'),
	array(	_('Start Date') => 'DATEBEGINM',
		_('End Date') => 'DATEENDM',
		_('Orientation') => 'ORIENTATION',
		_('Destination') => 'DESTINATION'));
?>
