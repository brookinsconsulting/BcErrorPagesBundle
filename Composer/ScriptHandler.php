<?php
/**
 * File containing the ScriptHandler class part of the BcErrorPagesBundle package.
 *
 * @copyright Copyright (C) Brookins Consulting. All rights reserved.
 * @license For full copyright and license information view LICENSE and COPYRIGHT.md file distributed with this source code.
 * @version //autogentag//
 */

namespace BrookinsConsulting\BcErrorPagesBundle\Composer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as ComposerScriptHandler;
use Composer\Script\Event;

class ScriptHandler extends ComposerScriptHandler {


    /**
     * Call the bc:errorpages:install command of the BC Error Pages Bundle.
     *
     * @param $event Event A instance
     */
    public static function installErrorPagesInApp(Event $event)
    {
        $options = self::getOptions($event);
        $consoleDir = self::getConsoleDir($event, '');

        if (null === $consoleDir) {
            return;
        }

        static::executeCommand($event, $consoleDir, 'bc:ep:install --relative', $options['process-timeout']);
    }

}