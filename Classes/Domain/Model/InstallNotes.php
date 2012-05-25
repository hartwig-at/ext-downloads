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
class Tx_Downloads_Domain_Model_InstallNotes extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * filetype
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $filetype;

	/**
	 * notes
	 *
	 * @var string
	 */
	protected $notes;

	/**
	 * Returns the filetype
	 *
	 * @return string $filetype
	 */
	public function getFiletype() {
		return $this->filetype;
	}

	/**
	 * Sets the filetype
	 *
	 * @param string $filetype
	 * @return void
	 */
	public function setFiletype($filetype) {
		$this->filetype = $filetype;
	}

	/**
	 * Returns the notes
	 *
	 * @return string $notes
	 */
	public function getNotes() {
		return $this->notes;
	}

	/**
	 * Sets the notes
	 *
	 * @param string $notes
	 * @return void
	 */
	public function setNotes($notes) {
		$this->notes = $notes;
	}

}
?>