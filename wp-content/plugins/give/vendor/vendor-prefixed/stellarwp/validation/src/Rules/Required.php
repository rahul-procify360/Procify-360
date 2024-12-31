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
use Give\Vendors\StellarWP\Validation\Contracts\ValidatesOnFrontEnd;
use Give\Vendors\StellarWP\Validation\Contracts\ValidationRule;

class Required implements ValidationRule, ValidatesOnFrontEnd
{
    /**
     * @inheritDoc
     */
    public static function id(): string
    {
        return 'required';
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
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        if (!isset($values[$key]) || $value === null || $value === '') {
            $fail(sprintf(__('%s is required', 'give'), '{field}'));
        }
    }

    /**
     * @inheritDoc
     */
    public function serializeOption(): bool
    {
        return true;
    }
}
