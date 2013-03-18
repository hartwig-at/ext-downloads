downloads
=========

`downloads` is an extension for [TYPO3](http://typo3.org/) which presents files as links on a website.

Features include:

- 4.5 LTS compatibility
    `downloads` is developed primarily with LTS deployments in mind.

- Import local files as download records
    Recursively loads all files in your *download* folder into *download records* by using the supplied BE module.
    These records represent a single download on your site.

- Automatic filename construction
    Filenames are automatically constructed based on a few simple rules.
    This guarantees consistent naming of your downloads.

- Downloads respect FE user access rights
    Access to any single download (or a whole category) can be restricted through the usual TYPO3 methods.

- Full multi-language support
    Depending on the language the user has chosen, he can be supplied with an alternative file.

realurl
-------

	$TYPO3_CONF_VARS[ "EXTCONF" ][ "realurl" ] = array(
	  "encodeSpURL_postProc" => array( "EXT:downloads/Classes/Hooks/RealUrl.php:&Tx_Downloads_Hooks_RealUrl->encode" ),
	  "decodeSpURL_preProc"  => array( "EXT:downloads/Classes/Hooks/RealUrl.php:&Tx_Downloads_Hooks_RealUrl->decode" )
	);

    $TYPO3_CONF_VARS['EXTCONF']['realurl']['BASECONFIG'] = array(
      'postVarSets' => array(   
        '_DEFAULT' => array(
          'download' => array(
            array(
              'GETvar' => 'tx_downloads_downloads[controller]'
            ),
            array(
              'GETvar' => 'tx_downloads_downloads[action]'
            ),
            array(
              'GETvar' => 'tx_downloads_downloads[id]'
            ),
            array(
              'GETvar' => 'tx_downloads_downloads[filename]'
            ),
          ),
         ...

Statistics
----------
To use the statistics, you'll want to set the **Record Type** of your user records to `Tx_Extbase_Domain_Model_FrontendUser`. Also make sure to provide the IDs of your user storage folder *with* the ID of your download storage folder. For example:

    plugin.tx_downloads.persistence.storagePid = 19,29,102