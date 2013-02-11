<?php
/**
 * Copyright (C) 2013, Oliver Salzburg
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * Created: 2013-02-11 17:44
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2013, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
require_once( "StatsController.php" );
class DownloadsStatsControllerImplementation extends Tx_Downloads_Controller_StatsController {

  /**
   * controller
   * @var Tx_Downloads_Controller_StatsController
   */
  private $controller = NULL;

  /***
   * @var Tx_Downloads_Service_TimerService
   */
  private $timerService = NULL;

  public function __construct( $interface ) {
    $this->controller = $interface;

    $this->timerService = t3lib_div::makeInstance( "Tx_Downloads_Service_TimerService" );
  }

  /**
   * Shows the download statistics
   */
  public function showAction() {
    $marker = $this->timerService->getTimeMarker();

    $downloadCounts = $this->controller->accessRepository->getDailyDownloadCount();
    $graphingData   = "";
    foreach( $downloadCounts as $download ) {
      $graphingData .= $download[ 'count' ] . ",";
    }
    $graphingData = substr( $graphingData, 0, -1 );

    $accesses = $this->controller->accessRepository->getSortedStatistics();
    $this->controller->view->assign( "accesses", $accesses );

    $this->controller->view->assign( "graphingData", $graphingData );

    $this->controller->view->assign( "perf", $this->timerService->getTimeDiff( $marker ) );
  }

  public function graphByDateAction() {
    $marker = $this->timerService->getTimeMarker();

    // First things first. Get unique graph ID
    $graphId = self::getUniqueGraphId();
    $this->controller->view->assign( "graphId", $graphId );

    $downloadCounts = $this->controller->accessRepository->getDailyDownloadCount();
    $graphingData   = "";
    foreach( $downloadCounts as $download ) {
      $graphingData .= $download[ 'count' ] . ",";
    }
    $graphingData = substr( $graphingData, 0, -1 );
    $this->controller->view->assign( "graphingData", $graphingData );

    $this->controller->view->assign( "perf", $this->timerService->getTimeDiff( $marker ) );
  }

  public function graphByCountAction() {
    $marker = $this->timerService->getTimeMarker();

    // First things first. Get unique graph ID
    $graphId = self::getUniqueGraphId();
    $this->controller->view->assign( "graphId", $graphId );

    // Grab the top downloads (raw, because we want to use custom COUNT() results)
    $topDownloads = $this->controller->downloadRepository->getTopDownloads( true );

    // Build the graph data that is passed to graphael
    $graphingData = "";
    foreach( $topDownloads as $download ) {
      $graphingData .= $download[ 'downloadsCount' ] . ",";
    }
    $graphingData = substr( $graphingData, 0, -1 );

    $this->controller->view->assign( "graphingData", $graphingData );

    // Get "translated" downloads
    $downloads = $this->controller->downloadRepository->getTopDownloads( false );
    $this->controller->view->assign( "downloads", $downloads );

    // Now we build the labels that will be used in the legend of the graph
    $graphingLabels = "";
    foreach( $downloads as $download ) {
      $graphingLabels .= Tx_Downloads_Utility_Filename::construct( $download ) . ",";
    }
    $graphingLabels = substr( $graphingLabels, 0, -1 );

    $this->controller->view->assign( "graphingLabels", $graphingLabels );

    $this->controller->view->assign( "perf", $this->timerService->getTimeDiff( $marker ) );
  }

  public function graphByReferrerAction() {
    $marker = $this->timerService->getTimeMarker();

    // First things first. Get unique graph ID
    $graphId = self::getUniqueGraphId();
    $this->controller->view->assign( "graphId", $graphId );

    // Grab the top referrers
    $referrer = $this->controller->accessRepository->getTopReferrer();
    $domains  = array();

    /** @var $ref Tx_Downloads_Domain_Model_Access */
    foreach( $referrer as $ref ) {
      $urlParts = parse_url( $ref->getReferrer() );
      $host     = $urlParts[ "host" ];
      if( "www.haseke.de" == $host ) {
        $host = "intern";
        // We'll ignore these for now.
        continue;
      }
      if( "" == $host ) {
        $host = "unbekannt";
        // Ignore these as well for now.
        continue;
      }
      ++$domains[ $host ];
    }

    // Build the graph data that is passed to graphael
    $graphingData = "";
    foreach( $domains as $host => $count ) {
      $graphingData .= $count . ",";
    }
    $graphingData = substr( $graphingData, 0, -1 );

    $this->controller->view->assign( "graphingData", $graphingData );

    // Now we build the labels that will be used in the legend of the graph
    $graphingLabels = "";
    foreach( $domains as $host => $count ) {
      $graphingLabels .= $host . ",";
    }
    $graphingLabels = substr( $graphingLabels, 0, -1 );

    $this->controller->view->assign( "graphingLabels", $graphingLabels );

    $this->controller->view->assign( "perf", $this->timerService->getTimeDiff( $marker ) );
  }

  private function getUniqueGraphId() {
    return uniqid();
  }
}