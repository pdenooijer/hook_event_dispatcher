<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

use Drupal\user\UserInterface;

/**
 * Class UsernameEventVariables.
 */
class UsernameEventVariables extends AbstractEventVariables {

  /**
   * Whether the user is anonymous or not.
   *
   * @return bool
   *   Is it?
   */
  public function userIsAnonymous(): bool {
    return $this->getAccount()->isAnonymous();
  }

  /**
   * Get the user account.
   *
   * @return \Drupal\user\UserInterface
   *   The user account.
   */
  public function getAccount(): UserInterface {
    return $this->variables['account'];
  }

}
