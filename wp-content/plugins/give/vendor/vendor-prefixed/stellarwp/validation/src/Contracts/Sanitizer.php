<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by impress-org on 24-December-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Give\Vendors\StellarWP\Validation\Contracts;

/**
 * Intended to be used as part of a Validation Rule to sanitize data after it is validated.
 *
 * @since 1.0.0
 */
interface Sanitizer
{
    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function sanitize($value);
}
