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
 * Userfunc to encode speaking URLs
 * This removes repeated identifiers that aren't really required to qualify a download instruction
 * Taken from: http://www.t3node.com/blog/hiding-repeated-segments-with-realurl/
 *
 * @author Oliver Salzburg <oliver@hartwig-at.de>, Hartwig Communication & Events
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_Hooks_RealUrl {
  
  public static function encode( &$params, &$ref ) {
    if( FALSE === strpos( $params[ "URL" ], "download/Download/download/" ) ) return;
    
    // Fix excessive download identifiers
    $params['URL'] = str_replace( "download/Download/download/", "download/", $params[ "URL"] );
    
    $assumedSuffix = ".html";
    $assumedSuffixOffset = strlen( $params[ "URL" ] ) - strlen( $assumedSuffix );
    // Does the URL end with the assumed suffix?
    if( strrpos( $params[ "URL" ], $assumedSuffix ) == $assumedSuffixOffset ) {
      $params[ "URL" ] = substr( $params[ "URL" ], 0, $assumedSuffixOffset );
    }
  }
  
  public static function decode( &$params, &$ref ) {
    if( FALSE === strpos( $params[ "URL" ], "download/" ) ) return;
    
    // Add back controller and action identifiers
    $params[ "URL" ] = str_replace( "download/", "download/Download/download/", $params[ "URL" ] );
    
    $assumedSuffix = ".html";
    $assumedSuffixOffset = strlen( $params[ "URL" ] ) - strlen( $assumedSuffix );
    // Does the URL end with the assumed suffix?
    if( strrpos( $params[ "URL" ], $assumedSuffix ) != $assumedSuffixOffset ) {
      $params[ "URL" ] .= $assumedSuffix;
    }
  }
}
?>