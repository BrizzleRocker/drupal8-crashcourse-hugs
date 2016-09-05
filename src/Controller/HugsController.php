<?php

namespace Drupal\hugs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hugs\HugTracker;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\NodeInterface;

class HugsController extends ControllerBase {
  /**
   * @var \Drupal\hugs\HugTracker
   */
  protected $hugTracker;

  public function __construct(HugTracker $tracker) {
    $this->hugTracker = $tracker;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('hugs.hug_tracker'));
  }

  public function hug($to, $from, $count) {
    // implement the hug tracker
    $this->hugTracker->addHug($to);
    // check for default count and return the hug page
    if (!$count) {
      $count = $this->config('hugs.settings')->get('default_count');
    }
    // build the return array
    $return = [
      '#theme'  => 'hug_page',
      '#from'   => $from,
      '#to'     => $to,
      '#count'  => $count,
    ];

    return $return;
  }

  public function nodeHug(NodeInterface $node) {
    if ($node->isPublished()) {
      // These are the same!
      //$body = $node->body->value;
      //$body = $node->body[0]->value;
      // But we really want...
      $formatted = $node->body->processed;

      $terms = [];
      foreach ($node->field_tags as $tag) {
        $terms[] = $tag->entity->label();
      }

      $message = $this->t('Everyone hug @name because @reasons!', [
        '@name' => $node->getOwner()->label(),
        '@reasons' => implode(', ', $terms),
      ]);

      // this should be in a template file!
      return [
        '#title' => $node->label() . ' (' . $node->bundle() . ')',
        '#markup' => $message . $formatted,
      ];
    }
    return $this->t('Not published');
  }
}
