<?php

namespace Drupal\preprocess_event_dispatcher\Variables;

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
  public function userIsAnonymous() {
    return $this->getAccount()->isAnonymous();
  }

  /**
   * Get the user account.
   *
   * @return \Drupal\user\Entity\User
   *   The user account.
   */
  public function getAccount() {
    return $this->variables['account'];
  }

}
