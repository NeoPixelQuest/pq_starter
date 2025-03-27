<?php

namespace Drupal\pq_starter_admin\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class AdminRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('content_moderation.admin_moderated_content')) {
      $collection->remove('content_moderation.admin_moderated_content');
    }
  }

}
