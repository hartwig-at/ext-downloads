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
 * Created: 2013-02-11 17:53
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2013, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
require_once( "AccessRepository.php" );
class DownloadsAccessRepositoryImplementation extends Tx_Downloads_Domain_Repository_AccessRepository {
  private $repository = NULL;

  public function __construct( $repository ) {
    $this->repository = $repository;
  }

  public function getSortedStatistics() {

    /** @var $query Tx_Extbase_Persistence_QueryInterface */
    $query = $this->repository->createQuery();
    return $query->matching( $query->logicalNot( $query->equals( "feUser", 0 ) ) )->setOrderings( array( "dateTime" => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING ) )->execute();
  }

  /**
   * @return array An array that contains the amount of downloads on each of the past 30 days
   */
  public function getDailyDownloadCount() {
    $downloadCountQuery = <<< EOS
      SELECT
        COUNT( * ) AS 'count'
      FROM
        tx_downloads_domain_model_access
      WHERE (
        FROM_UNIXTIME( date_time ) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() + INTERVAL 1 DAY
      )
      GROUP BY
        DAY( FROM_UNIXTIME( date_time ) )
      ORDER BY
		    date_time ASC
      ;
EOS;

    /** @var $query Tx_Extbase_Persistence_QueryInterface */
    $query = $this->repository->createQuery();
    $query->getQuerySettings()->setReturnRawQueryResult( TRUE );
    $result = $query->statement( $downloadCountQuery )->execute();

    if( count( $result < 30 ) ) {
      $result = array_pad( $result, -31, array( "count" => 0 ) );
    }

    return $result;
  }

  public function getTopReferrer() {
    $topReferrerQuery = <<< EOS
      SELECT
        tx_downloads_domain_model_access.*
      FROM
        tx_downloads_domain_model_access
      INNER JOIN
        tx_downloads_domain_model_download
      ON (
        tx_downloads_domain_model_download.uid = tx_downloads_domain_model_access.download
      )
      WHERE (
        ( FROM_UNIXTIME( date_time ) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() + INTERVAL 1 DAY )
        AND ( referrer NOT LIKE "http://www.haseke.de%" )
      )
      ORDER BY
		    date_time ASC
      ;
EOS;

    /** @var $query Tx_Extbase_Persistence_Query */
    $query  = $this->repository->createQuery();
    $result = $query->statement( $topReferrerQuery )->execute();

    return $result;
  }
}