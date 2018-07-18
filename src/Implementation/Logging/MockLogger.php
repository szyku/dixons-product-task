<?php declare(strict_types=1);


namespace Dixons\Implementation\Logging;


use Psr\Log\LoggerInterface;

final class MockLogger implements LoggerInterface
{
    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        // Intentionally does nothing
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        // Intentionally does nothing
    }

}