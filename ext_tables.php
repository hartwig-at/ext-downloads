<?php
if( !defined( 'TYPO3_MODE' ) ) {
	die( 'Access denied.' );
}
t3lib_extMgm::addStaticFile('downloads', 'Configuration/TypoScript/downloads', 'Downloads List');
if( TYPO3_MODE == 'BE' ) {  $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['downloads_downloads_wizicon'] =    t3lib_extMgm::extPath('downloads') . 'Resources/Private/Php/class.downloads_downloads_wizicon.php';}
t3lib_extMgm::addStaticFile('downloads', 'Configuration/TypoScript/stats', 'Download Statistics');
if( TYPO3_MODE == 'BE' ) {  $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['downloads_stats_wizicon'] =    t3lib_extMgm::extPath('downloads') . 'Resources/Private/Php/class.downloads_stats_wizicon.php';}
Tx_Extbase_Utility_Extension::registerPlugin(
  'downloads',
  'Downloads',
  'LLL:EXT:downloads/Resources/Private/Language/locallang_be.xml:downloads_title'
);
$TCA['tt_content']['types']['list']['subtypes_addlist']['downloads_downloads'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('downloads_downloads', 'FILE:EXT:downloads/Configuration/FlexForms/flexform_downloads.xml');
Tx_Extbase_Utility_Extension::registerPlugin(
  'downloads',
  'Stats',
  'LLL:EXT:downloads/Resources/Private/Language/locallang_be.xml:stats_title'
);
$TCA['tt_content']['types']['list']['subtypes_addlist']['downloads_stats'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue('downloads_stats', 'FILE:EXT:downloads/Configuration/FlexForms/flexform_stats.xml');
if( TYPO3_MODE === 'BE' ) {
  Tx_Extbase_Utility_Extension::registerModule(
    'downloads',
    'web',
    'downloads_import',
    '',
    array(
          'Import' => 'index,listCategories,listInstallNotes,enumDirectory,importEntityAsDownload'
    ),
    array(
      'access' => 'user,group',
      'icon'   => 'EXT:downloads/ext_icon.gif',
      'labels' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_import.xml',
    )
  );
}
$TCA['tx_downloads_domain_model_download'] = array(
  'ctrl' => array(
    'title'                    => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download',
    'label'                    => 'title',
    'label_alt'                => 'filename',
    'label_userFunc'           => 'Tx_Downloads_Hooks_Labels->getUserLabelDownload',
    'dividers2tabs'            => TRUE,
    'tstamp'                   => 'tstamp',
    'crdate'                   => 'crdate',
    'cruser_id'                => 'cruser_id',
    'delete'                   => 'deleted',
    'enablecolumns'            => array(
      'disabled'  => 'hidden',
      'starttime' => 'starttime',
      'endtime'   => 'endtime',
      'fe_group'  => 'fe_group'
    ),
    'editlock'                 => 'editlock',
    'versioningWS'             => 2,
    'versioning_followPages'   => TRUE,
    'origUid'                  => 't3_origuid',
    'languageField'            => 'sys_language_uid',
    'transOrigPointerField'    => 'l10n_parent',
    'transOrigDiffSourceField' => 'l10n_diffsource',
    'dynamicConfigFile'        => t3lib_extMgm::extPath( 'downloads' ) . 'Configuration/TCA/Download.php',
    'iconfile'                 => t3lib_extMgm::extRelPath( 'downloads' ) . 'Resources/Public/Icons/tx_downloads_domain_model_download.png',
    'thumbnail'                => 'filename',
    'searchFields'             => 'title,filename,qualifier'
  )
);
$TCA['tx_downloads_domain_model_downloadcategory'] = array(
  'ctrl' => array(
    'title'                    => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_downloadcategory',
    'label'                    => 'name',
    'dividers2tabs'            => TRUE,
    'tstamp'                   => 'tstamp',
    'crdate'                   => 'crdate',
    'cruser_id'                => 'cruser_id',
    'delete'                   => 'deleted',
    'enablecolumns'            => array(
      'disabled'  => 'hidden',
      'starttime' => 'starttime',
      'endtime'   => 'endtime',
      'fe_group'  => 'fe_group'
    ),
    'editlock'                 => 'editlock',
    'versioningWS'             => 2,
    'versioning_followPages'   => TRUE,
    'origUid'                  => 't3_origuid',
    'languageField'            => 'sys_language_uid',
    'transOrigPointerField'    => 'l10n_parent',
    'transOrigDiffSourceField' => 'l10n_diffsource',
'default_sortby'           => 'ORDER BY sorting',
'sortby'                   => 'sorting',
    'dynamicConfigFile'        => t3lib_extMgm::extPath( 'downloads' ) . 'Configuration/TCA/DownloadCategory.php',
    'iconfile'                 => t3lib_extMgm::extRelPath( 'downloads' ) . 'Resources/Public/Icons/tx_downloads_domain_model_downloadcategory.png',
  )
);
$TCA['tx_downloads_domain_model_installnote'] = array(
  'ctrl' => array(
    'title'                    => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_installnote',
    'label'                    => 'filetype',
    'dividers2tabs'            => TRUE,
    'tstamp'                   => 'tstamp',
    'crdate'                   => 'crdate',
    'cruser_id'                => 'cruser_id',
    'delete'                   => 'deleted',
    'enablecolumns'            => array(
      'disabled'  => 'hidden',
      'starttime' => 'starttime',
      'endtime'   => 'endtime',
      'fe_group'  => 'fe_group'
    ),
    'editlock'                 => 'editlock',
    'versioningWS'             => 2,
    'versioning_followPages'   => TRUE,
    'origUid'                  => 't3_origuid',
    'languageField'            => 'sys_language_uid',
    'transOrigPointerField'    => 'l10n_parent',
    'transOrigDiffSourceField' => 'l10n_diffsource',
    'dynamicConfigFile'        => t3lib_extMgm::extPath( 'downloads' ) . 'Configuration/TCA/InstallNote.php',
    'iconfile'                 => t3lib_extMgm::extRelPath( 'downloads' ) . 'Resources/Public/Icons/tx_downloads_domain_model_installnote.png',
  )
);
$TCA['tx_downloads_domain_model_access'] = array(
  'ctrl' => array(
    'title'                    => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_access',
    'label'                    => '',
'hideTable'=>1,
    'dividers2tabs'            => TRUE,
    'dynamicConfigFile'        => t3lib_extMgm::extPath( 'downloads' ) . 'Configuration/TCA/Access.php',
    'iconfile'                 => t3lib_extMgm::extRelPath( 'downloads' ) . 'Resources/Public/Icons/tx_downloads_domain_model_access.png',
  )
);
t3lib_div::requireOnce( t3lib_extMgm::extPath( 'downloads' ) . 'Classes/Hooks/Labels.php' );
t3lib_extMgm::addStaticFile('downloads', 'Configuration/TypoScript', 'Downloads Base');
?>