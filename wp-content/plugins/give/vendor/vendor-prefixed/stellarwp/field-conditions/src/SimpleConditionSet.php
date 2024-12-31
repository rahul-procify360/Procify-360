<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by impress-org on 24-December-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Give\Vendors\StellarWP\FieldConditions;

use ArrayIterator;
use Give\Vendors\StellarWP\FieldConditions\Concerns\HasConditions;
use Give\Vendors\StellarWP\FieldConditions\Contracts\ConditionSet;

/**
 * @implements ConditionSet<FieldCondition>
 * @uses HasConditions<FieldCondition>
 */
class SimpleConditionSet implements ConditionSet
{
    use HasConditions;

    /**
     * @since 1.0.0
     *
     * @param FieldCondition ...$conditions
     *
     * @return void
     */
    public function __construct(...$conditions)
    {
        $this->validateConditions($conditions);
        $this->conditions = $conditions;
    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->conditions);
    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function jsonSerialize(): array
    {
        return array_map(
            static function (FieldCondition $condition) {
                return $condition->jsonSerialize();
            },
            $this->conditions
        );
    }

    /**
     * @inheritDoc
     */
    protected static function getBaseConditionClass(): string
    {
        return FieldCondition::class;
    }
}
