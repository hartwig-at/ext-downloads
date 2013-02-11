<?php
if( !defined( 'TYPO3_MODE' ) ) {
	die( 'Access denied.' );
}
Tx_Extbase_Utility_Extension::configurePlugin(  'downloads',  'Downloads',  array(    'Downloads' => 'list,download'  ),  array(    'Downloads' => ''  ));
Tx_Extbase_Utility_Extension::configurePlugin(  'downloads',  'Stats',  array(    'Stats' => 'show,graphByDate,graphByCount,graphByReferrer'  ),  array(    'Stats' => ''  ));
?>