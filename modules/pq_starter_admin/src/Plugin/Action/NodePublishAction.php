<?php

namespace Drupal\pq_starter_admin\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\pq_starter_admin\ContentModeration;

/**
 * An example action covering most of the possible options.
 *
 * If type is left empty, action will be selectable for all
 * entity types.
 *
 * @Action(
 *   id = "pq_node_publish_action",
 *   label = @Translation("Publish content"),
 *   type = "node",
 *   confirm = TRUE,
 * )
 */

class NodePublishAction extends ActionBase {
  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL): string {
    /*
     * All config resides in $this->configuration.
     * Passed view rows will be available in $this->context.
     * Data about the view used to select results and optionally
     * the batch context are available in $this->context or externally
     * through the public getContext() method.
     * The entire ViewExecutable object  with selected result
     * rows is available in $this->view or externally through
     * the public getView() method.
     */

    $user = \Drupal::currentUser();

    if ($user->hasPermission('moderated content bulk publish')) {
      \Drupal::logger('pq_starter_admin')->notice("Executing publishing of ".$entity->label());

      $moderation = new ContentModeration($entity);
      $entity = $moderation->transitionTo('published');

      // Something went wrong during the transition, and the entity wasn't returned.
      if (!$entity) {
        return $this->errorMessage();
      }

      // Check if the Node didn't get updated and published.
      if (!$entity->isPublished()) {
        return $this->errorMessage();
      }

      return sprintf('Example action (configuration: %s)', print_r($this->configuration, TRUE));
    }
    else {
      \Drupal::messenger()->addWarning(t("You don't have access to execute this operation!"));
    }

    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    if ($object->getEntityTypeId() === 'node') {
      $moderation_info = \Drupal::service('content_moderation.moderation_information');
      // Moderated Entities will return AccessResult::forbidden for attemps
      // to edit $object->status.
      // @see content_moderation_entity_field_access
      if ($moderation_info->isModeratedEntity($object)) {
        $access = $object->access('update', $account, TRUE)
          ->andIf($object->moderation_state->access('edit', $account, TRUE));
      }
      else {
        $access = $object->access('update', $account, TRUE)
          ->andIf($object->status->access('edit', $account, TRUE));
      }
    }
    else {
      $access = AccessResult::forbidden()->setReason('The chosen Action only acts on entities of type node')->setCacheMaxAge(0);
    }
    return $return_as_object ? $access : $access->isAllowed();
  }

  private function errorMessage() {
    $msg = "Something went wrong, the entity must be published by this point. Review your content moderation configuration make sure you have published state which sets current revision and try again.";
    \Drupal::Messenger()->addError(mb_convert_encoding($msg, 'UTF-8'));
    \Drupal::logger('moderated_content_bulk_publish')->warning($msg);
    return $msg;
  }
}
