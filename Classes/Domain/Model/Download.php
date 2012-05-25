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
class Tx_Downloads_Domain_Model_Download extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * fileName
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $fileName;
  
  /**
   * downloadCategory
   *
   * @var Tx_Downloads_Domain_Model_DownloadCategory
   */
  protected $downloadCategory;
  
  /**
   * qualifier
   * 
   * @var string
   */
  protected $qualifier;
  
  /**
   * The text that link to the file (usually the file name).
   *
   * @var string
   * @validate NotEmpty
   */
  protected $linkText;
  
  /**
   * fileSize
   *
   * @var int
   * @validate NotEmpty
   */
  protected $fileSize;
  
  /**
   * The type of the file (usually the file extension)
   *
   * @var string
   * @validate NotEmpty
   */
  protected $fileType;
  
  /**
   * The time the file was last modified
   * @var integer
   * @validate NotEmpty
   */
  protected $fileTime;
  
  /**
   * A short descriptive text accompanying the download.
   *
   * @var string
   * @validate Text
   */
  protected $description;

	/**
	 * installNotes
	 *
	 * @var Tx_Downloads_Domain_Model_InstallNotes
	 */
	protected $installNotes;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the fileName
	 *
	 * @return string $fileName
	 */
	public function getFileName() {
		return $this->fileName;
	}

	/**
	 * Sets the fileName
	 *
	 * @param string $fileName
	 * @return void
	 */
	public function setFileName($fileName) {
		$this->fileName = $fileName;
	}
  
  /**
   * Returns the downloadCategory
   *
   * @return Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory
   */
  public function getDownloadCategory() {
    return $this->downloadCategory;
  }

  /**
   * Sets the downloadCategory
   *
   * @param Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory
   * @return void
   */
  public function setDownloadCategory(Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory) {
    $this->downloadCategory = $downloadCategory;
  }
  
  /**
   * Returns the qualifier
   *
   * @return string $qualifier
   */
  public function getQualifier() {
    return $this->qualifier;
  }

  /**
   * Sets the qualifier
   *
   * @param string $qualifier
   * @return void
   */
  public function setQualifier( $qualifier ) {
    $this->qualifier = $qualifier;
  }
  
  /**
   * Returns the fileType
   *
   * @return string $fileTyüe
   */
  public function getFileType() {
    return $this->fileType;
  }

  /**
   * Sets the fileType
   *
   * @param string $fileType
   * @return void
   */
  public function setFileType($fileType) {
    $this->fileType = $fileType;
  }
  
  /**
   * Returns the description
   *
   * @return string $description
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Sets the description
   *
   * @param string $description
   * @return void
   */
  public function setDescription($description) {
    $this->description = $description;
  }
  
  /**
   * Returns the linkTExt
   *
   * @return string $linkTExt
   */
  public function getLinkText() {
    return $this->linkText;
  }

  /**
   * Sets the linkText
   *
   * @param string $linkText
   * @return void
   */
  public function setLinkText($linkText) {
    $this->linkText = $linkText;
  }
  
  /**
   * Returns the fileSize
   *
   * @return string $fileSize
   */
  public function getFileSize() {
    return $this->fileSize;
  }

  /**
   * Sets the fileSize
   *
   * @param string $fileSize
   * @return void
   */
  public function setFileSize($fileSize) {
    $this->fileSize = $fileSize;
  }

  /**
   * Returns the fileTime
   *
   * @return integer $fileTime
   */
  public function getFileTime() {
    return $this->fileTime;
  }

  /**
   * Sets the fileTime
   *
   * @param integer $fileTime
   * @return void
   */
  public function setFileTime( $fileTime ) {
    $this->fileTime = $fileTime;
  }
  
	/**
	 * Returns the installNotes
	 *
	 * @return Tx_Downloads_Domain_Model_InstallNotes $installNotes
	 */
	public function getInstallNotes() {
		return $this->installNotes;
	}

	/**
	 * Sets the installNotes
	 *
	 * @param Tx_Downloads_Domain_Model_InstallNotes $installNotes
	 * @return void
	 */
	public function setInstallNotes(Tx_Downloads_Domain_Model_InstallNotes $installNotes) {
		$this->installNotes = $installNotes;
	}

}
?>