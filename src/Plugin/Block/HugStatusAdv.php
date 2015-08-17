<?php

/**
 * @file
 * Contains \Drupal\hugs\Plugin\Block\HugStatusAdv
 */

namespace Drupal\hugs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Reports on hugability status but is configurable
 *
 * @Block(
 *   id = "hugs_status_adv",
 *   admin_label = @Translation("Hug status (advanced)")
 * )
 */
class HugStatusAdv extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['hugs_enabled' => 1];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['enable_hugging'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hugging enabled'),
      '#description' => $this->t('Enables or disables the advanced hug message.'),
      '#default_value' => $this->configuration['hugs_enabled'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['hugs_enabled'] = $form_state->getValue('enable_hugging');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $message = $this->configuration['hugs_enabled'] ? $this->t('Now accepting hugs') : $this->t('No hugs :-(');

    return [
      '#type' => 'markup',
      '#markup' => $message . ' on this site.'
    ];
  }

}
