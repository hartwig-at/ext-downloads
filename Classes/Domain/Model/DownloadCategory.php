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
 *
 *
 * @package downloads
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Downloads_Domain_Model_DownloadCategory extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The name of the category
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $name;
  
  /**
   * The name part this category provides to contained links.
   * @var string
   * @novalidate
   */
  protected $fileNamePart;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
	}

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
  
  /**
   * Returns the fileNamePart
   *
   * @return string $fileNamePart
   */
  public function getFileNamePart() {
    return $this->fileNamePart;
  }

  /**
   * Sets the fileNamePart
   *
   * @param string $fileNamePart
   * @return void
   */
  public function setFileNamePart($fileNamePart) {
    $this->fileNamePart = $fileNamePart;
  }
}
?>