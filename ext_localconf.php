<?php
if( !defined( 'TYPO3_MODE' ) ) {
	die( 'Access denied.' );
}
Tx_Extbase_Utility_Extension::configurePlugin(  'downloads',  'Downloads',  array(    'Downloads' => 'list'  ),  array(    'Downloads' => 'download'  ));
Tx_Extbase_Utility_Extension::configurePlugin(  'downloads',  'Stats',  array(    'Stats' => ''  ),  array(    'Stats' => 'show,graphByDate,graphByCount,graphByReferrer'  ));
?>