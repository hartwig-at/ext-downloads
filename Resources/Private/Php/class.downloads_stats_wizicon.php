<?php
class downloads_stats_wizicon {	public function proc($wizardItems) {		$locallang = $this->includeLocalLang();		$wizardItems['plugins_tx_downloads_stats'] = array(			'icon'		  	=> t3lib_extMgm::extRelPath('downloads') . 'Resources/Public/Icons/ce_wiz_stats.gif',			'title'		  	=> $GLOBALS['LANG']->getLLL('stats_title', $locallang),			'description'	=> $GLOBALS['LANG']->getLLL('stats_plus_wiz_description', $locallang),			'params'	  	=> '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=downloads_stats'		);		return $wizardItems;	}	protected function includeLocalLang() {		$file = t3lib_extMgm::extPath('downloads') . 'Resources/Private/Language/locallang_be.xml';		return t3lib_div::makeInstance('t3lib_l10n_parser_Llxml')->getParsedData($file,$GLOBALS['LANG']->lang);	}}
?>