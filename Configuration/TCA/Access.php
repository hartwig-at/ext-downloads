<?php
if( !defined( 'TYPO3_MODE' ) ) {
  die( 'Access denied.' );
}
$TCA['tx_downloads_domain_model_access'] = array(
  'ctrl' => $TCA['tx_downloads_domain_model_access']['ctrl'],
  'interface' => array( 'showRecordFieldList' => '' ),
  'types' => array(  ),
  'palettes' => array(  ),
  'columns' => array( 'fe_user' => array( 'exclude' => 1,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_access.fe_user','config' => array('foreign_table' => 'Tx_Extbase_Domain_Model_FrontendUser','foreign_table_where' => 'AND Tx_Extbase_Domain_Model_FrontendUser.sys_language_uid=0','allowed' => 'Tx_Extbase_Domain_Model_FrontendUser','type' => 'input') ),'ip_address' => array( 'exclude' => 1,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_access.ip_address','config' => array('type' => 'input') ),'referrer' => array( 'exclude' => 1,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_access.referrer','config' => array('type' => 'input') ),'date_time' => array( 'exclude' => 1,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_access.date_time','config' => array('type' => 'input') ),'download' => array( 'exclude' => 1,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_access.download','config' => array('foreign_table' => 'tx_downloads_domain_model_download','foreign_table_where' => 'AND tx_downloads_domain_model_download.sys_language_uid=0','allowed' => 'tx_downloads_domain_model_download','type' => 'input') ) )
);
?>