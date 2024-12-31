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
use Give\Vendors\StellarWP\Validation\Commands\SkipValidationRules;
use Give\Vendors\StellarWP\Validation\Rules\Abstracts\ConditionalRule;

/**
 * The value is nullable if the conditions pass.
 *
 * @since 1.2.0
 */
class NullableIf extends ConditionalRule
{
    /**
     * {@inheritDoc}
     *
     * @since 1.2.0
     */
    public static function id(): string
    {
        return 'nullableIf';
    }

    /**
     * {@inheritDoc}
     *
     * @since 1.2.0
     */
    public function __invoke($value, Closure $fail, string $key, array $values)
    {
        if ($value === null && $this->conditions->passes($values)) {
            return new SkipValidationRules();
        }
    }
}
