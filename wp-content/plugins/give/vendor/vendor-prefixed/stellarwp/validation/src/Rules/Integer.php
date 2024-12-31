<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by impress-org on 24-December-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Give\Vendors\StellarWP\Validation\Rules;

use Closure;
use Give\Vendors\StellarWP\Validation\Contracts\Sanitizer;
use Give\Vendors\StellarWP\Validation\Contracts\ValidatesOnFrontEnd;
use Give\Vendors\StellarWP\Validation\Contracts\ValidationRule;

class Integer implements ValidationRule, ValidatesOnFrontEnd, Sanitizer
{
    /**
     * @inheritDoc
     */
    public static function id(): string
    {
        return 'integer';
    }

    /**
     * @inheritDoc
     */
    public static function fromString(string $options = null): ValidationRule
    {
        return new self();
    }

    /**
     * @inheritDoc
     */
    public function sanitize($value)
    {
        return (int)$value;
    }

    /**
     * @inheritDoc
     */
    public function serializeOption()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        if (is_bool($value) || false === filter_var($value, FILTER_VALIDATE_INT)) {
            $fail(sprintf(__('%s must be an integer', 'give'), '{field}'));
        }
    }
}
