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
 * SortedDirectoryIterator
 * Original implementation from: http://stackoverflow.com/a/6572417/259953
 * @package TYPO3
 * @subpackage tx_downloads
 */
class Tx_Downloads_Utility_SortedDirectoryIterator implements IteratorAggregate {
  private $_storage;

  public function __construct( $path ) {
    $this->_storage = new ArrayObject();

    $files = new DirectoryIterator( $path );
    foreach( $files as $file ) {
      $this->_storage->offsetSet( $file->getFilename(), $file->getFileInfo() );
    }
    $this->_storage->uksort(
      function( $a, $b ) {
        return strcasecmp( $a, $b );
      }
    );
  }

  public function getIterator() {
    return $this->_storage->getIterator();
  }

}
?>
