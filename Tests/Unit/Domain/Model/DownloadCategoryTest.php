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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Downloads_Domain_Model_DownloadCategory.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Downloads
 *
 * @author Oliver Salzburg <oliver@hartwig-at.de>
 */
class Tx_Downloads_Domain_Model_DownloadCategoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Downloads_Domain_Model_DownloadCategory
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Downloads_Domain_Model_DownloadCategory();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getAutoCollectReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getAutoCollect()
		);
	}

	/**
	 * @test
	 */
	public function setAutoCollectForBooleanSetsAutoCollect() { 
		$this->fixture->setAutoCollect(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getAutoCollect()
		);
	}
	
	/**
	 * @test
	 */
	public function getCollectTagReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCollectTagForStringSetsCollectTag() { 
		$this->fixture->setCollectTag('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCollectTag()
		);
	}
	
	/**
	 * @test
	 */
	public function getContainedDownloadsReturnsInitialValueForObjectStorageContainingTx_Downloads_Domain_Model_Download() { 
		$newObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getContainedDownloads()
		);
	}

	/**
	 * @test
	 */
	public function setContainedDownloadsForObjectStorageContainingTx_Downloads_Domain_Model_DownloadSetsContainedDownloads() { 
		$containedDownload = new Tx_Downloads_Domain_Model_Download();
		$objectStorageHoldingExactlyOneContainedDownloads = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneContainedDownloads->attach($containedDownload);
		$this->fixture->setContainedDownloads($objectStorageHoldingExactlyOneContainedDownloads);

		$this->assertSame(
			$objectStorageHoldingExactlyOneContainedDownloads,
			$this->fixture->getContainedDownloads()
		);
	}
	
	/**
	 * @test
	 */
	public function addContainedDownloadToObjectStorageHoldingContainedDownloads() {
		$containedDownload = new Tx_Downloads_Domain_Model_Download();
		$objectStorageHoldingExactlyOneContainedDownload = new Tx_Extbase_Persistence_ObjectStorage();
		$objectStorageHoldingExactlyOneContainedDownload->attach($containedDownload);
		$this->fixture->addContainedDownload($containedDownload);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneContainedDownload,
			$this->fixture->getContainedDownloads()
		);
	}

	/**
	 * @test
	 */
	public function removeContainedDownloadFromObjectStorageHoldingContainedDownloads() {
		$containedDownload = new Tx_Downloads_Domain_Model_Download();
		$localObjectStorage = new Tx_Extbase_Persistence_ObjectStorage();
		$localObjectStorage->attach($containedDownload);
		$localObjectStorage->detach($containedDownload);
		$this->fixture->addContainedDownload($containedDownload);
		$this->fixture->removeContainedDownload($containedDownload);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getContainedDownloads()
		);
	}
	
}
?>