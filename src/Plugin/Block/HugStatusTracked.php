<?php

/**
 * @file
 * Contains \Drupal\hugs\Plugin\Block\HugStatusTracked
 */

namespace Drupal\hugs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\hugs\HugTracker;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on hugability status with Tracking information
 *
 * @Block(
 *   id = "hugs_status_tracked",
 *   admin_label = @Translation("Hug status (tracked)")
 * )
 */
class HugStatusTracked extends BlockBase implements ContainerFactoryPluginInterface {
  protected $hugTracker;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, HugTracker $hugTracker) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->hugTracker = $hugTracker;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('hugs.hug_tracker')
    );
  }
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
    $message = $this->t('No hugs :-(');
    if ($this->configuration['hugs_enabled']) {
      $message = $this->t('@to was the last person hugged', [
        '@to' => $this->hugTracker->getLastRecipient()
      ]);
    }
    return ['#markup' => $message];
  }
  // ...not sure what goes here
}