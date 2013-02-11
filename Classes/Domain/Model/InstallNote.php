<?php
class Tx_Downloads_Domain_Model_InstallNote extends Tx_Extbase_DomainObject_AbstractEntity {
/**
* filetype
* @var string
*/
protected $filetype;
/**
* notes
* @var string
*/
protected $notes;
public function getT3ManagedFields() {	 return $this->t3ManagedFields;}public function setT3ManagedFields( $t3ManagedFields ) {	 $this->t3ManagedFields = $t3ManagedFields;}
public function getFiletype() {	 return $this->filetype;}public function setFiletype( $filetype ) {	 $this->filetype = $filetype;}
public function getNotes() {	 return $this->notes;}public function setNotes( $notes ) {	 $this->notes = $notes;}
public function getT3CommonFields() {	 return $this->t3CommonFields;}public function setT3CommonFields( $t3CommonFields ) {	 $this->t3CommonFields = $t3CommonFields;}
public function getT3VersioningFields() {	 return $this->t3VersioningFields;}public function setT3VersioningFields( $t3VersioningFields ) {	 $this->t3VersioningFields = $t3VersioningFields;}
public function getT3TranslationFields() {	 return $this->t3TranslationFields;}public function setT3TranslationFields( $t3TranslationFields ) {	 $this->t3TranslationFields = $t3TranslationFields;}
}
?>