<?php
$EM_CONF[$_EXTKEY] = array(
  'title'            => 'Downloads',
  'description'      => 'A very simple way to include downloads on your site.',
  'category'         => 'fe',
  'author'           => 'Oliver Salzburg',
  'author_email'     => 'oliver@hartwig-at.de',
  'author_company'   => 'Hartwig Communication & Events',
  'shy'              => '',
  'priority'         => '',
  'module'           => '',
  'state'            => 'experimental',
  'internal'         => '',
  'uploadfolder'     => '0',
  'createDirs'       => '',
  'modify_tables'    => '',
  'clearCacheOnLoad' => 0,
  'lockType'         => '',
  'version'          => '0.1.1',
  'constraints'      => array(
    'depends'   => array(
      'extbase' => '1.3.0',
      'fluid'   => '1.3.0',
    ),
    'conflicts' => array(
    ),
    'suggests'  => array(
    ),
  ),
);
?>