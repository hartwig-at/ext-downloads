<?php
if( !defined( 'TYPO3_MODE' ) ) {
  die( 'Access denied.' );
}
$TCA['tx_downloads_domain_model_downloadcategory'] = array(
  'ctrl' => $TCA['tx_downloads_domain_model_downloadcategory']['ctrl'],
  'interface' => array( 'showRecordFieldList' => 'hidden, starttime, endtime, fe_group, sys_language_uid, l10n_parent, l10n_diffsource' ),
  'types' => array( '1' => array( 'showitem' => 'l10n_parent,l10n_diffsource,name,file_name_part,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;paletteAccess' ) ),
  'palettes' => array( 'paletteAccess' => array(
  'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel,
      endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel,
      --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel,
      --linebreak--,editlock,hidden',
  'canNotCollapse' => TRUE
) ),
  'columns' => array( 'name' => array( 'exclude' => 0,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_downloadcategory.name','config' => array('type' => 'input') ),'file_name_part' => array( 'exclude' => 0,'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_downloadcategory.file_name_part','config' => array('type' => 'input') ),'starttime' => array(	'exclude' => 1,	'l10n_mode' => 'mergeIfNotBlank',	'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',	'config' => array(		'type' => 'input',		'size' => 13,		'max' => 20,		'eval' => 'datetime',		'checkbox' => 0,		'default' => 0,		'range' => array(			'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))		),	),),'endtime' => array(	'exclude' => 1,	'l10n_mode' => 'mergeIfNotBlank',	'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',	'config' => array(		'type' => 'input',		'size' => 13,		'max' => 20,		'eval' => 'datetime',		'checkbox' => 0,		'default' => 0,		'range' => array(			'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))		),	),),'fe_group' => array(  'exclude' => 1,  'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',  'config' => array(    'type' => 'select',    'size' => 5,    'maxitems' => 20,    'items' => array(      array(        'LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login',        -1,      ),      array(        'LLL:EXT:lang/locallang_general.xml:LGL.any_login',        -2,      ),      array(        'LLL:EXT:lang/locallang_general.xml:LGL.usergroups',        '--div--',      ),    ),    'exclusiveKeys' => '-1,-2',    'foreign_table' => 'fe_groups',    'foreign_table_where' => 'ORDER BY fe_groups.title',  ),),'editlock' => array(  'exclude' => 1,  'l10n_mode' => 'mergeIfNotBlank',  'label' => 'LLL:EXT:lang/locallang_tca.xml:editlock',  'config' => array(    'type' => 'check'  )),'hidden' => array(	'exclude' => 1,	'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',	'config' => array(		'type' => 'check',	),),'sys_language_uid' => array(	'exclude' => 1,	'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',	'config' => array(		'type' => 'select',		'foreign_table' => 'sys_language',		'foreign_table_where' => 'ORDER BY sys_language.title',		'items' => array(			array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),			array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)		),	),),'l10n_parent' => array(	'displayCond' => 'FIELD:sys_language_uid:>:0',	'exclude' => 1,	'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',	'config' => array(		'type' => 'select',		'items' => array(			array('', 0),		),		'foreign_table' => 'tx_downloads_domain_model_downloadcategory',		'foreign_table_where' => 'AND tx_downloads_domain_model_downloadcategory.pid=###CURRENT_PID### AND tx_downloads_domain_model_downloadcategory.sys_language_uid IN (-1,0)',	),),'l10n_diffsource' => array(	'config' => array(		'type' => 'passthrough',	),),'t3ver_label' => array(	'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',	'config' => array(		'type' => 'input',		'size' => 30,		'max' => 255,	)),		'sorting' => array(
      'label' => 'sorting',
      'config' => array(
        'type' => 'input'
      )
    ) )
);
?>