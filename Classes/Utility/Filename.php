<?php
/**
 * Copyright (C) 2012, Oliver Salzburg
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * Created: 2013-05-25 18:01
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2012, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
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
    $titleNamePart  = $download->getTitle();
    $filetype_check = array_reverse( explode( ".", $download->getFileName() ) );
    $fileExtension  = $filetype_check[ 0 ];
    $fileExtension  = strtolower( $fileExtension );

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
    $pattern           = "/([[:alnum:]_\.-]*)/";
    $resultingFilename = str_replace( str_split( preg_replace( $pattern, $replace, $encoded ) ), $replace, $encoded );

    return $resultingFilename;
  }
}