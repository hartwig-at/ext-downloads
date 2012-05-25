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
class Tx_Downloads_Controller_DownloadCategoryController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * downloadCategoryRepository
	 *
	 * @var Tx_Downloads_Domain_Repository_DownloadCategoryRepository
	 */
	protected $downloadCategoryRepository;

	/**
	 * injectDownloadCategoryRepository
	 *
	 * @param Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository
	 * @return void
	 */
	public function injectDownloadCategoryRepository(Tx_Downloads_Domain_Repository_DownloadCategoryRepository $downloadCategoryRepository) {
		$this->downloadCategoryRepository = $downloadCategoryRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$downloadCategories = $this->downloadCategoryRepository->findAll();
		$this->view->assign('downloadCategories', $downloadCategories);
	}

	/**
	 * action show
	 *
	 * @param $downloadCategory
	 * @return void
	 */
	public function showAction(Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory) {
		$this->view->assign('downloadCategory', $downloadCategory);
	}

	/**
	 * action new
	 *
	 * @param $newDownloadCategory
	 * @dontvalidate $newDownloadCategory
	 * @return void
	 */
	public function newAction(Tx_Downloads_Domain_Model_DownloadCategory $newDownloadCategory = NULL) {
		if ($newDownloadCategory == NULL) { // workaround for fluid bug ##5636
			$newDownloadCategory = t3lib_div::makeInstance('Tx_Downloads_Domain_Model_DownloadCategory');
		}
		$this->view->assign('newDownloadCategory', $newDownloadCategory);
	}

	/**
	 * action create
	 *
	 * @param $newDownloadCategory
	 * @return void
	 */
	public function createAction(Tx_Downloads_Domain_Model_DownloadCategory $newDownloadCategory) {
		$this->downloadCategoryRepository->add($newDownloadCategory);
		$this->flashMessageContainer->add('Your new DownloadCategory was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param $downloadCategory
	 * @return void
	 */
	public function editAction(Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory) {
		$this->view->assign('downloadCategory', $downloadCategory);
	}

	/**
	 * action update
	 *
	 * @param $downloadCategory
	 * @return void
	 */
	public function updateAction(Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory) {
		$this->downloadCategoryRepository->update($downloadCategory);
		$this->flashMessageContainer->add('Your DownloadCategory was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param $downloadCategory
	 * @return void
	 */
	public function deleteAction(Tx_Downloads_Domain_Model_DownloadCategory $downloadCategory) {
		$this->downloadCategoryRepository->remove($downloadCategory);
		$this->flashMessageContainer->add('Your DownloadCategory was removed.');
		$this->redirect('list');
	}

}
?>