<?php

namespace Drupal\freedom_group\Service;

interface GroupPagesInterface {

  public function isGroupPage();

  public function isGroupCanonical();

  public function getPageInfo();

  /**
   * @return \Drupal\group\Entity\GroupInterface
   */
  public function getGroup();
}
