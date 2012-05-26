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
 * Filename
 *
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_Utility_Filename {
  /**
   * Constructs a file name for a given download record.
   * @var Tx_Downloads_Domain_Model_Download $download The download for which a filename should be constructed.
   * @var bool $clean Should the resulting filename be "cleaned"?
   * @return string The name the for the file for the given download. 
   */
  public static function construct( Tx_Downloads_Domain_Model_Download $download, $clean = true ) {
    // Determine target file name
    $categoryNamePart = "";
    if( null !== $download->getDownloadCategory() ) {
      $categoryNamePart = $download->getDownloadCategory()->getFileNamePart();
    }
    $titleNamePart    = $download->getTitle();
    $filetype_check   = array_reverse( explode( ".", $download->getFileName() ) );
    $fileExtension    = $filetype_check[ 0 ];
    $fileExtension    = strtolower( $fileExtension );
    
    $fileName = $titleNamePart . "." . $fileExtension;
    if( "" !== trim( $categoryNamePart ) ) {
      $fileName = $categoryNamePart . " " . $fileName;
    }
    if( $clean ) {
      $fileName = self::clean( $fileName );
    }
    return $fileName;
  }
  
  /**
   * Take a given name and convert it to a valid file name.
   * Taken from: http://iamcam.wordpress.com/2007/03/20/clean-file-names-using-php-preg_replace/
   * @param string $filename The desired file name
   * @param string $replace The character to replace unwanted characters in the filename with
   * @return string The resulting, valid file name 
   */
  public static function clean( $filename, $replace = "_" ) {
    // Convert string down to ASCII
    $encoded = iconv( "utf-8", "ascii//TRANSLIT", $filename );
    
    // Replace non-ASCII characters?
    $pattern  = "/([[:alnum:]_\.-]*)/";
    $resultingFilename = str_replace( str_split( preg_replace( $pattern, $replace, $encoded ) ), $replace, $encoded );
    
    return $resultingFilename;
  }
}