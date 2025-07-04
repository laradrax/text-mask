<?php

namespace Laradrax\TextMask;

use Illuminate\Support\Stringable;
use Laravel\Nova\Contracts\FilterableField;
use Laravel\Nova\Fields\Copyable;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\FieldFilterable;
use Laravel\Nova\Fields\Filters\Filter;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class TextMask extends Field implements FilterableField
{
    use Copyable;
    use FieldFilterable;
    use SupportsDependentFields;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'text-mask';

    /**
     * Make the field filter.
     *
     * @return Filter
     */
    protected function makeFilter(NovaRequest $request)
    {
        return new TextMaskFilter($this);
    }

    /**
     * Set if the value should be raw.
     */
    public function raw(bool $raw = true): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $raw,
        ]);
    }

    /**
     * Set the mask for the field.
     */
    public function mask(Stringable|string|null $mask): TextMask
    {
        if ($mask !== null) {
            $mask = str($mask)->trim();
        }

        return $this->withMeta([
            __FUNCTION__ => $mask,
        ]);
    }

    /**
     * Set custom tokens for the mask.
     *
     * @param  array<string, array<string, string|bool>>  $tokens  Custom tokens in format ['X' => ['pattern' => '\d', 'optional' => false]]
     */
    public function tokens(array $tokens): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $tokens,
        ]);
    }

    /**
     * Eager mode will show static characters before you type them,
     * e.g. when you type `1`, eager mask `#-#` will show `1-` and non-eager will show `1`
     */
    public function eager(bool $eager = true): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $eager,
        ]);
    }

    /**
     * In reversed mode mask will grow backwards, e.g. for numbers
     */
    public function reversed(bool $reversed = false): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $reversed,
        ]);
    }
}
