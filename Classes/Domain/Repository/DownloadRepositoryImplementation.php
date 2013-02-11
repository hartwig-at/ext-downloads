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
 * Created: 2013-02-11 17:59
 *
 * @author     Oliver Salzburg <oliver.salzburg@hartwig-at.de>, Hartwig Communication & Events
 * @copyright  Copyright (C) 2013, Oliver Salzburg
 * @license    http://opensource.org/licenses/mit-license.php MIT License
 * @package    TYPO3
 * @subpackage tx_downloads
 */
require_once( "DownloadRepository.php" );
class DownloadsDownloadRepositoryImplementation extends Tx_Downloads_Domain_Repository_DownloadRepository {
  private $repository = NULL;

  public function __construct( $repository ) {
    $this->repository = $repository;
  }

  public function findAllWithUid( $uids ) {
    /** @var $query Tx_Extbase_Persistence_QueryInterface */
    $query = $this->repository->createQuery();
    //$query->getQuerySettings()->setRespectStoragePage( false );
    $query->matching( $query->in( "uid", explode( ",", $uids ) ) );

    $query->setOrderings( array(
                               "downloadCategory.sorting" => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING,
                               "title"                    => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING
                          ) );

    $result = $query->execute();
    return $result;
  }

  /**
   * Retrieves all download records that were downloaded in the past 30 days and sorts them by how often they were downloaded.
   * @param $raw bool Should the raw result be returned? Meaning result rows instead of Download records.
   *
   * @return mixed An array of rows or download records.
   */
  public function getTopDownloads( $raw ) {
    $topDownloadQuery = <<< EOS
      SELECT
        COUNT( download ) AS 'downloadsCount',
        tx_downloads_domain_model_download.*
      FROM
        tx_downloads_domain_model_access
      INNER JOIN
        tx_downloads_domain_model_download
      ON (
        tx_downloads_domain_model_download.uid = tx_downloads_domain_model_access.download
      )
      WHERE (
        ( FROM_UNIXTIME( date_time ) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() + INTERVAL 1 DAY )
      )
      GROUP BY
        download
      ORDER BY
        COUNT( download ) DESC
      ;
EOS;

    /** @var $query Tx_Extbase_Persistence_QueryInterface */
    $query = $this->repository->createQuery();
    //$query->setOrderings( array( "COUNT( access.download )", Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING ) );
    if( $raw ) {
      $query->getQuerySettings()->setReturnRawQueryResult( TRUE );
    }
    $query->statement( $topDownloadQuery );

    return $query->execute();
  }
}