<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by impress-org on 24-December-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Give\Vendors\StellarWP\Validation\Rules;

use Closure;

class InStrict extends In
{
    /**
     * @since 1.2.0
     */
    public static function id(): string
    {
        return 'inStrict';
    }

    /**
     * @since 1.2.0
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        if (!in_array($value, $this->acceptedValues, true)) {
            $fail(sprintf(__('%s must be one of %s', 'give'), '{field}', implode(', ', $this->acceptedValues)));
        }
    }
}
