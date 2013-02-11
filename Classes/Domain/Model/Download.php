<?php
class Tx_Downloads_Domain_Model_Download extends Tx_Extbase_DomainObject_AbstractEntity {
/**
* title
* @var string
*/
protected $title;
/**
* filename
* @var string
*/
protected $filename;
/**
* downloadCategory
* @var Tx_Downloads_Domain_Model_DownloadCategory
*/
protected $downloadCategory;
/**
* qualifier
* @var string
*/
protected $qualifier;
/**
* description
* @var string
*/
protected $description;
/**
* installNote
* @var Tx_Downloads_Domain_Model_InstallNote
*/
protected $installNote;
/**
* fileSize
* @var int
*/
protected $fileSize;
/**
* fileType
* @var string
*/
protected $fileType;
/**
* fileTime
* @var string
*/
protected $fileTime;
public function getT3ManagedFields() {	 return $this->t3ManagedFields;}public function setT3ManagedFields( $t3ManagedFields ) {	 $this->t3ManagedFields = $t3ManagedFields;}
public function getTitle() {	 return $this->title;}public function setTitle( $title ) {	 $this->title = $title;}
public function getFilename() {	 return $this->filename;}public function setFilename( $filename ) {	 $this->filename = $filename;}
public function getDownloadCategory() {	 return $this->downloadCategory;}public function setDownloadCategory( $downloadCategory ) {	 $this->downloadCategory = $downloadCategory;}
public function getQualifier() {	 return $this->qualifier;}public function setQualifier( $qualifier ) {	 $this->qualifier = $qualifier;}
public function getDescription() {	 return $this->description;}public function setDescription( $description ) {	 $this->description = $description;}
public function getInstallNote() {	 return $this->installNote;}public function setInstallNote( $installNote ) {	 $this->installNote = $installNote;}
public function getFileSize() {	 return $this->fileSize;}public function setFileSize( $fileSize ) {	 $this->fileSize = $fileSize;}
public function getFileType() {	 return $this->fileType;}public function setFileType( $fileType ) {	 $this->fileType = $fileType;}
public function getFileTime() {	 return $this->fileTime;}public function setFileTime( $fileTime ) {	 $this->fileTime = $fileTime;}
public function getT3CommonFields() {	 return $this->t3CommonFields;}public function setT3CommonFields( $t3CommonFields ) {	 $this->t3CommonFields = $t3CommonFields;}
public function getT3VersioningFields() {	 return $this->t3VersioningFields;}public function setT3VersioningFields( $t3VersioningFields ) {	 $this->t3VersioningFields = $t3VersioningFields;}
public function getT3TranslationFields() {	 return $this->t3TranslationFields;}public function setT3TranslationFields( $t3TranslationFields ) {	 $this->t3TranslationFields = $t3TranslationFields;}
}
?>