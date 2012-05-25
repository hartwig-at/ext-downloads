<?php
if( !defined( 'TYPO3_MODE' ) ) {
	die( 'Access denied.' );
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Downloads',
	'Downloads'
);

if( TYPO3_MODE === 'BE' ) {
  /**
   * Registers a Backend Module
   */
  Tx_Extbase_Utility_Extension::registerModule(
    $_EXTKEY,
    'tools',           // Make module a submodule of 'tools'
    'tx_downloads_m1', // Submodule key
    '',                // Position
    array(
      'Import' => 'index, listCategories, listInstallNotes, enumDirectory, importEntityAsDownload',
    ),
    array(
      'access' => 'user,group',
      'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
      'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_downloadimportkey.xml',
    )
  );
}

// Alternative labels
t3lib_div::requireOnce( t3lib_extMgm::extPath( $_EXTKEY ) . "Classes/Hooks/Labels.php" );

$pluginSignature = str_replace('_','',$_EXTKEY) . '_' . downloads;
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_' .downloads. '.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Downloads');

t3lib_extMgm::addLLrefForTCAdescr('tx_downloads_domain_model_download', 'EXT:downloads/Resources/Private/Language/locallang_csh_tx_downloads_domain_model_download.xml');
//t3lib_extMgm::allowTableOnStandardPages('tx_downloads_domain_model_download');
$TCA['tx_downloads_domain_model_download'] = array(
	'ctrl' => array(
		'title'	                   => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download',
		'label'                    => 'title',
		'label_alt'                => 'file_name',
		'label_userFunc'           => 'Tx_Downloads_Hooks_Labels->getUserLabelDownload',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'cruser_id'                => 'cruser_id',
		'dividers2tabs'            => TRUE,
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'editlock'                 => 'editlock',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete'                   => 'deleted',
		'enablecolumns'            => array(
			'disabled'  => 'hidden',
			'starttime' => 'starttime',
			'endtime'   => 'endtime',
			'fe_group'  => 'fe_group'
		),
		'dynamicConfigFile'        => t3lib_extMgm::extPath( $_EXTKEY ) . 'Configuration/TCA/Download.php',
		'iconfile'                 => t3lib_extMgm::extRelPath( $_EXTKEY ) . 'Resources/Public/Icons/tx_downloads_domain_model_download.gif',
		'thumbnail'                => 'file_name',
		'searchFields'             => 'title,file_name,qualifier'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_downloads_domain_model_downloadcategory', 'EXT:downloads/Resources/Private/Language/locallang_csh_tx_downloads_domain_model_downloadcategory.xml');
//t3lib_extMgm::allowTableOnStandardPages('tx_downloads_domain_model_downloadcategory');
$TCA['tx_downloads_domain_model_downloadcategory'] = array(
	'ctrl' => array(
		'title'	                   => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_downloadcategory',
		'label'                    => 'name',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'cruser_id'                => 'cruser_id',
		'dividers2tabs'            => TRUE,
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby'           => 'ORDER BY sorting',
    'sortby'                   => 'sorting',
		'delete'                   => 'deleted',
		'enablecolumns'            => array(
			'disabled'  => 'hidden',
			'starttime' => 'starttime',
			'endtime'   => 'endtime',
			'fe_group'  => 'fe_group'
		),
		'dynamicConfigFile'        => t3lib_extMgm::extPath( $_EXTKEY ) . 'Configuration/TCA/DownloadCategory.php',
		'iconfile'                 => t3lib_extMgm::extRelPath( $_EXTKEY ) . 'Resources/Public/Icons/tx_downloads_domain_model_downloadcategory.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_downloads_domain_model_installnotes', 'EXT:downloads/Resources/Private/Language/locallang_csh_tx_downloads_domain_model_installnotes.xml');
//t3lib_extMgm::allowTableOnStandardPages('tx_downloads_domain_model_installnotes');
$TCA['tx_downloads_domain_model_installnotes'] = array(
	'ctrl' => array(
		'title'	                   => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_installnotes',
		'label'                    => 'filetype',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'cruser_id'                => 'cruser_id',
		'dividers2tabs'            => TRUE,
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete'                   => 'deleted',
		'enablecolumns'            => array(
			'disabled'  => 'hidden',
			'starttime' => 'starttime',
			'endtime'   => 'endtime',
		),
		'dynamicConfigFile'        => t3lib_extMgm::extPath( $_EXTKEY ) . 'Configuration/TCA/InstallNotes.php',
		'iconfile'                 => t3lib_extMgm::extRelPath( $_EXTKEY ) . 'Resources/Public/Icons/tx_downloads_domain_model_installnotes.gif'
	),
);

?>