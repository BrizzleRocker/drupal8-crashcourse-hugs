<?php

namespace Drupal\hugs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hugs\HugTracker;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HugsController extends ControllerBase {
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

}
