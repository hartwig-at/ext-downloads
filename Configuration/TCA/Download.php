<?php
if( !defined( "TYPO3_MODE" ) ) {
	die( "Access denied." );
}

$TCA['tx_downloads_domain_model_download'] = array(
	'ctrl' => $TCA['tx_downloads_domain_model_download']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, starttime, endtime, fe_group, title, download_category, file_name, description, install_notes, qualifier',
	),
	'types' => array(
		'1' => array(
		  'showitem' => 
		    'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, download_category, qualifier, file_name, description, install_notes,
		    --div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;paletteAccess'
		),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'paletteAccess' => array(
      'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel,
          endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel,
          --linebreak--, fe_group;LLL:EXT:cms/locallang_ttc.xml:fe_group_formlabel,
          --linebreak--,editlock,',
      'canNotCollapse' => TRUE,
    )
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_downloads_domain_model_download',
				'foreign_table_where' => 'AND tx_downloads_domain_model_download.pid=###CURRENT_PID### AND tx_downloads_domain_model_download.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
    'fe_group' => array(
      'exclude' => 1,
      'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
      'config' => array(
        'type' => 'select',
        'size' => 5,
        'maxitems' => 20,
        'items' => array(
          array(
            'LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login',
            -1,
          ),
          array(
            'LLL:EXT:lang/locallang_general.xml:LGL.any_login',
            -2,
          ),
          array(
            'LLL:EXT:lang/locallang_general.xml:LGL.usergroups',
            '--div--',
          ),
        ),
        'exclusiveKeys' => '-1,-2',
        'foreign_table' => 'fe_groups',
        'foreign_table_where' => 'ORDER BY fe_groups.title',
      ),
    ),
    'editlock' => array(
      'exclude' => 1,
      'l10n_mode' => 'mergeIfNotBlank',
      'label' => 'LLL:EXT:lang/locallang_tca.xml:editlock',
      'config' => array(
        'type' => 'check'
      )
    ),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'download_category' => array(
      'exclude' => 0,
      /*
      'l10n_mode'    => 'exclude',
      'l10n_display' => 'defaultAsReadonly',
      */
     'l10n_mode' => 'mergeIfNotBlank',
      'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download.download_category',
      'config' => array(
        'type' => 'select',
        'foreign_table' => 'tx_downloads_domain_model_downloadcategory',
        /*'foreign_table_where' => 'AND tx_downloads_domain_model_downloadcategory.sys_language_uid=###REC_FIELD_sys_language_uid### ORDER BY tx_downloads_domain_model_downloadcategory.sorting',*/
        'foreign_table_where' => 'AND tx_downloads_domain_model_downloadcategory.sys_language_uid=0 ORDER BY tx_downloads_domain_model_downloadcategory.sorting',
        'size' => 1,
        'minitems' => 0,
        'maxitems' => 1,
      ),
    ),
    'qualifier' => array(
      'exclude' => 0,
      'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download.qualifier',
      'config' => array(
        'type' => 'input',
        'size' => 30,
        'eval' => 'trim'
      ),
    ),
		'file_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download.file_name',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file_reference',
				/*'uploadfolder' => 'uploads/tx_downloads',*/
				'allowed' => '*',
				'disallowed' => 'php',
				'size' => 5,
			),
		),
		'description' => array(
      'exclude' => 0,
      'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download.description',
      'config' => array(
        'type' => 'text',
        'cols' => 40,
        'rows' => 15,
        'eval' => 'trim',
        'wizards' => array(
          'RTE' => array(
            'icon' => 'wizard_rte2.gif',
            'notNewRecords'=> 1,
            'RTEonly' => 1,
            'script' => 'wizard_rte.php',
            'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
            'type' => 'script'
          )
        )
      ),
      'defaultExtras' => 'richtext[]',
    ),
		'install_notes' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:downloads/Resources/Private/Language/locallang_db.xml:tx_downloads_domain_model_download.install_notes',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_downloads_domain_model_installnotes',
				'foreign_table_where' => 'AND tx_downloads_domain_model_installnotes.sys_language_uid = 0',
				'minitems' => 0,
				'maxitems' => 1,
			),
		)
	),
);

?>