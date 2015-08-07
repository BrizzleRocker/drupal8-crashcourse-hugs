<?php

namespace Drupal\hugs\Controller;

use Drupal\Core\Controller\ControllerBase;

class HugsController extends ControllerBase {

  public function hug($to, $from) {
    $message = array(
        '#theme'=> 'hug_page',    
        '#from' => $from,
        '#to' => $to,
    );

    return $message;
  }

}
