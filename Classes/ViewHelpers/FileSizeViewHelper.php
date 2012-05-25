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
 * ViewHelper to convert a byte-based file size in "human readable" format
 *
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_ViewHelpers_FileSizeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

  /**
   * Renders a byte-based file size in "human readable" format
   *
   * @param int $bytes The number of bytes that should be converted to human-readable format.
   * @param int $precision How many digits to use after the decimal.
   * @return string The bytes in human-readable format.
   */
  public function render( $bytes, $precision = 2 ) {
    return self::bytesToSize( $bytes, $precision );
  }
  
  /**
   * Render bytes as human readable string.
   * Taken from: http://codeaid.net/php/convert-size-in-bytes-to-a-human-readable-format-(php)
   * @param integer $bytes The number of bytes that should be converted to human-readable format.
   * @param integer $precision How many digits to use after the decimal.
   */
  public static function bytesToSize( $bytes, $precision = 2 ) {
    if( !is_int( $bytes ) ) return "null";
    
    // We're not using the TYPO3 internal method for now as we want to render with fractions
    //return t3lib_div::formatSize( $bytes );
    
    $kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;
   
    if( ( $bytes >= 0 ) && ( $bytes < $kilobyte ) ) {
      return $bytes . " B";
 
    } elseif( ( $bytes >= $kilobyte ) && ( $bytes < $megabyte ) ) {
      return round( $bytes / $kilobyte, $precision ) . " KB";
 
    } elseif( ( $bytes >= $megabyte ) && ( $bytes < $gigabyte ) ) {
      return round( $bytes / $megabyte, $precision ) . " MB";
 
    } elseif( ( $bytes >= $gigabyte ) && ( $bytes < $terabyte ) ) {
      return round( $bytes / $gigabyte, $precision ) . " GB";
 
    } elseif( $bytes >= $terabyte ) {
      return round( $bytes / $terabyte, $precision ) . " TB";
      
    } else {
      return $bytes . " B";
    }
  }

}

?>