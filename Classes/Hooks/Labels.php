<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Oliver Salzburg <oliver@hartwig-at.de>, Hartwig Communication & Events
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * Userfunc to get alternative label
 *
 * @author Oliver Salzburg <oliver@hartwig-at.de>, Hartwig Communication & Events
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_Hooks_Labels {
  /**
   * Retrieve the label for a download record.
   * Internally uses the filename construction approach.
   * This way, the names in the frontend match the backend.
   * 
   * @param array $params
   * @param mixed $pObj
   */
  public static function getUserLabelDownload( array &$params, &$pObj ) {
    // Get some extbase going
    $bootstrap = new Tx_Extbase_Core_Bootstrap();
    $bootstrap->initialize( 
      array( 
        "extensionName" => "downloads", 
        "pluginName"    => "Downloads",
        "persistence."  => array(
          "storagePid" => $params[ "row" ][ "pid" ]
        ) 
      )
    );
    
    // Get our repository to get the "real" (persistence) object
    $repository = t3lib_div::makeInstance( "Tx_Downloads_Domain_Repository_DownloadRepository" );
    $item = $repository->findByUid( $params[ "row" ][ "uid" ] );
    
    // Item not found? Weird. But let's stick with the input data then
    if( null == $item ) return;
    
    // Fix the title
    $params[ "title" ] = Tx_Downloads_Utility_Filename::construct( $item, false );
  }
}

if( defined( "TYPO3_MODE" ) && $TYPO3_CONF_VARS[ TYPO3_MODE ][ "XCLASS" ][ "ext/downloads/Classes/Hooks/Labels.php" ] ) {
  require_once( $TYPO3_CONF_VARS[ TYPO3_MODE ][ "XCLASS" ][ "ext/downloads/Classes/Hooks/Labels.php" ] );
}

?>