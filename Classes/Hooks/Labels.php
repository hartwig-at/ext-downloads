<?php
require_once('DownloadsHooksLabelsImplementation.php');
class Tx_Downloads_Hooks_Labels {
private $implementation;
private function getImplementation() {
  if( null == $this->implementation ) {
    $this->implementation = new DownloadsHooksLabelsImplementation($this);
  }
  return $this->implementation;
}
public static function getUserLabelDownload( array &$params, &$pObj ) { return DownloadsHooksLabelsImplementation::getUserLabelDownload( $params, $pObj ); }
}
?>