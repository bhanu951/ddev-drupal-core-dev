<?php
#ddev-generated

namespace DrupalCoreDev\Command;

use Symfony\Component\Console\Command\Command;

/**
 * Base class for our commands.
 */
abstract class CommandBase extends Command {

  /**
   * Gets the project web root from the DDEV environment variable.
   *
   * @return string
   *   The web root relative to the project root.
   */
  protected function getWebRoot(): string {
    return getenv('DDEV_DOCROOT');
  }

}