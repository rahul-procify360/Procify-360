<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by impress-org on 24-December-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Give\Vendors\StellarWP\Validation;

use Give\Vendors\StellarWP\Validation\Rules\Boolean;
use Give\Vendors\StellarWP\Validation\Rules\Currency;
use Give\Vendors\StellarWP\Validation\Rules\DateTime;
use Give\Vendors\StellarWP\Validation\Rules\Email;
use Give\Vendors\StellarWP\Validation\Rules\Exclude;
use Give\Vendors\StellarWP\Validation\Rules\ExcludeIf;
use Give\Vendors\StellarWP\Validation\Rules\ExcludeUnless;
use Give\Vendors\StellarWP\Validation\Rules\In;
use Give\Vendors\StellarWP\Validation\Rules\InStrict;
use Give\Vendors\StellarWP\Validation\Rules\Integer;
use Give\Vendors\StellarWP\Validation\Rules\Max;
use Give\Vendors\StellarWP\Validation\Rules\Min;
use Give\Vendors\StellarWP\Validation\Rules\Nullable;
use Give\Vendors\StellarWP\Validation\Rules\NullableIf;
use Give\Vendors\StellarWP\Validation\Rules\NullableUnless;
use Give\Vendors\StellarWP\Validation\Rules\Numeric;
use Give\Vendors\StellarWP\Validation\Rules\Optional;
use Give\Vendors\StellarWP\Validation\Rules\OptionalIf;
use Give\Vendors\StellarWP\Validation\Rules\OptionalUnless;
use Give\Vendors\StellarWP\Validation\Rules\Required;
use Give\Vendors\StellarWP\Validation\Rules\Size;

class ServiceProvider
{
    private $validationRules = [
        Required::class,
        Min::class,
        Max::class,
        Size::class,
        Numeric::class,
        In::class,
        InStrict::class,
        Integer::class,
        Email::class,
        Currency::class,
        Exclude::class,
        ExcludeIf::class,
        ExcludeUnless::class,
        Nullable::class,
        NullableIf::class,
        NullableUnless::class,
        Optional::class,
        OptionalIf::class,
        OptionalUnless::class,
        DateTime::class,
        Boolean::class,
    ];

    /**
     * Registers the validation rules registrar with the container
     */
    public function register()
    {
        Config::getServiceContainer()->singleton(ValidationRulesRegistrar::class, function () {
            $register = new ValidationRulesRegistrar();

            foreach ($this->validationRules as $rule) {
                $register->register($rule);
            }

            do_action(Config::getHookPrefix() . 'register_validation_rules', $register);

            return $register;
        });
    }
}
