<?php
class Tx_Downloads_Domain_Model_DownloadCategory extends Tx_Extbase_DomainObject_AbstractEntity {
/**
* name
* @var string
*/
protected $name;
/**
* fileNamePart
* @var string
*/
protected $fileNamePart;
public function getT3ManagedFields() {	 return $this->t3ManagedFields;}public function setT3ManagedFields( $t3ManagedFields ) {	 $this->t3ManagedFields = $t3ManagedFields;}
public function getT3Sortable() {	 return $this->t3Sortable;}public function setT3Sortable( $t3Sortable ) {	 $this->t3Sortable = $t3Sortable;}
public function getName() {	 return $this->name;}public function setName( $name ) {	 $this->name = $name;}
public function getFileNamePart() {	 return $this->fileNamePart;}public function setFileNamePart( $fileNamePart ) {	 $this->fileNamePart = $fileNamePart;}
public function getT3CommonFields() {	 return $this->t3CommonFields;}public function setT3CommonFields( $t3CommonFields ) {	 $this->t3CommonFields = $t3CommonFields;}
public function getT3VersioningFields() {	 return $this->t3VersioningFields;}public function setT3VersioningFields( $t3VersioningFields ) {	 $this->t3VersioningFields = $t3VersioningFields;}
public function getT3TranslationFields() {	 return $this->t3TranslationFields;}public function setT3TranslationFields( $t3TranslationFields ) {	 $this->t3TranslationFields = $t3TranslationFields;}
}
?>