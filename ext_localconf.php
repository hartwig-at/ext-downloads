<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Downloads',
	array(
		'Download' => 'list',
		/*'DownloadCategory' => 'list, show, new, create, edit, update, delete',
		'InstallNotes' => 'list, show, new, create, edit, update, delete',*/
		
	),
	// non-cacheable actions
	array(
		'Download' => 'download',
		/*'DownloadCategory' => 'create, update, delete',
		'InstallNotes' => 'create, update, delete',*/
		
	)
);

?>