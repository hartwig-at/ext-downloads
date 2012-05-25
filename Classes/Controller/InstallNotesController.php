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
class Tx_Downloads_Controller_InstallNotesController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * installNotesRepository
	 *
	 * @var Tx_Downloads_Domain_Repository_InstallNotesRepository
	 */
	protected $installNotesRepository;

	/**
	 * injectInstallNotesRepository
	 *
	 * @param Tx_Downloads_Domain_Repository_InstallNotesRepository $installNotesRepository
	 * @return void
	 */
	public function injectInstallNotesRepository(Tx_Downloads_Domain_Repository_InstallNotesRepository $installNotesRepository) {
		$this->installNotesRepository = $installNotesRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$installNotess = $this->installNotesRepository->findAll();
		$this->view->assign('installNotess', $installNotess);
	}

	/**
	 * action show
	 *
	 * @param $installNotes
	 * @return void
	 */
	public function showAction(Tx_Downloads_Domain_Model_InstallNotes $installNotes) {
		$this->view->assign('installNotes', $installNotes);
	}

	/**
	 * action new
	 *
	 * @param $newInstallNotes
	 * @dontvalidate $newInstallNotes
	 * @return void
	 */
	public function newAction(Tx_Downloads_Domain_Model_InstallNotes $newInstallNotes = NULL) {
		$this->view->assign('newInstallNotes', $newInstallNotes);
	}

	/**
	 * action create
	 *
	 * @param $newInstallNotes
	 * @return void
	 */
	public function createAction(Tx_Downloads_Domain_Model_InstallNotes $newInstallNotes) {
		$this->installNotesRepository->add($newInstallNotes);
		$this->flashMessageContainer->add('Your new InstallNotes was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param $installNotes
	 * @return void
	 */
	public function editAction(Tx_Downloads_Domain_Model_InstallNotes $installNotes) {
		$this->view->assign('installNotes', $installNotes);
	}

	/**
	 * action update
	 *
	 * @param $installNotes
	 * @return void
	 */
	public function updateAction(Tx_Downloads_Domain_Model_InstallNotes $installNotes) {
		$this->installNotesRepository->update($installNotes);
		$this->flashMessageContainer->add('Your InstallNotes was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param $installNotes
	 * @return void
	 */
	public function deleteAction(Tx_Downloads_Domain_Model_InstallNotes $installNotes) {
		$this->installNotesRepository->remove($installNotes);
		$this->flashMessageContainer->add('Your InstallNotes was removed.');
		$this->redirect('list');
	}

}
?>