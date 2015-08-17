<?php

/**
 * @file
 * Contains \Drupal\hugs\Plugin\Block\HugStatusSimple
 */

namespace Drupal\hugs\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Reports on hugability status.
 *
 * @Block(
 *   id = "hugs_status_simple",
 *   admin_label = @Translation("Hug status (simple)")
 * )
 */
class HugStatusSimple extends BlockBase {
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('This is a hug-enabled site'),
    ];
  }
}

