<?php

declare(strict_types=1);

namespace ElForastero\Transliterate;

/**
 * Class Transformer.
 *
 * @author Eugene Dzhumak <elforastero@ya.ru>
 *
 * @version 1.0.0
 */
final class Transformer
{
    /**
     * @var array
     */
    private static $stack = [];

    /**
     * Add the callback into the stack.
     *
     * @param callable $callback
     */
    public static function register(callable $callback): void
    {
        self::$stack[] = $callback;
    }

    /**
     * Get an array of all registered callbacks.
     *
     * @return array<callable>
     */
    public static function getAll(): array
    {
        return self::$stack;
    }

    /**
     * Override closures stack.
     * For testing purposes only.
     *
     * @param array $stack
     */
    public static function override(array $stack): void
    {
        self::$stack = $stack;
    }
}
