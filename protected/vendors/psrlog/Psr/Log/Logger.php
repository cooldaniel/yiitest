<?php

namespace Psr\Log;

/**
 * Logger.
 */
class Logger extends AbstractLogger
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $text = $this->interpolate($message, $context);
        echo $level . ': ' . $text;
    }

    /**
     * Interpolates context values into the message placeholders.
     */
    public function interpolate($message, array $context = array())
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }
        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
