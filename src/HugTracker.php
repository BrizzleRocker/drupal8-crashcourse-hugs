<?php

/**
 * Hug Tracker Service
 * 
 * @file
 * 
 */
namespace Drupal\hugs;

use Drupal\Core\State\StateInterface;

class HugTracker {

  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  public function addHug($target_name) {
    $this->state->set('hugs.last_recipient', $target_name);
    return $this;
  }

  public function getLastRecipient() {
    return $this->state->get('hugs.last_recipient');
  }
}
