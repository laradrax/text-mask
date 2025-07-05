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

/**
 * TextMask field for Laravel Nova.
 *
 * Provides input masking functionality using the Maska library.
 * Supports custom masks, tokens, eager mode, reversed mode, and raw value extraction.
 *
 * @author Laradrax
 *
 * @since 1.0.0
 */
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
     * @param  NovaRequest  $request  The Nova request instance
     * @return Filter The filter instance for this field
     */
    protected function makeFilter(NovaRequest $request)
    {
        return new TextMaskFilter($this);
    }

    /**
     * Set if the value should be raw (unmasked) when submitted.
     *
     * When enabled, the field will send the unmasked value to the server
     * instead of the masked display value.
     *
     * @param  bool  $raw  Whether to send raw (unmasked) values
     * @return TextMask The field instance for method chaining
     */
    public function raw(bool $raw = true): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $raw,
        ]);
    }

    /**
     * Set the mask pattern for the field.
     *
     * Supports Maska mask patterns:
     * - # (digit 0-9)
     * - @ (letter a-z, A-Z)
     * - * (alphanumeric)
     *
     * Can also accept JSON arrays for dynamic masks.
     *
     * @param  Stringable|string|null  $mask  The mask pattern or null to disable
     * @return TextMask The field instance for method chaining
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
     * Allows defining custom token patterns beyond the default Maska tokens.
     * Each token should define a 'pattern' (regex) and optionally 'optional' (boolean).
     *
     * @param  array<string, array<string, string|bool>>  $tokens  Custom tokens in format ['X' => ['pattern' => '\d', 'optional' => false]]
     * @return TextMask The field instance for method chaining
     */
    public function tokens(array $tokens): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $tokens,
        ]);
    }

    /**
     * Enable or disable eager mode for the mask.
     *
     * Eager mode will show static characters before you type them.
     * For example, when you type `1` with eager mask `#-#`, it will show `1-`
     * instead of just `1`.
     *
     * @param  bool  $eager  Whether to enable eager mode (default: false)
     * @return TextMask The field instance for method chaining
     */
    public function eager(bool $eager = false): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $eager,
        ]);
    }

    /**
     * Enable or disable reversed mode for the mask.
     *
     * In reversed mode, the mask will grow backwards, which is useful
     * for numeric inputs like currency or numbers.
     *
     * @param  bool  $reversed  Whether to enable reversed mode (default: false)
     * @return TextMask The field instance for method chaining
     */
    public function reversed(bool $reversed = false): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $reversed,
        ]);
    }

    /**
     * Require the mask to be completely filled before submission.
     *
     * When enabled, the field will validate that the mask is completely
     * filled out before allowing form submission.
     *
     * @param  bool  $required  Whether to require complete mask filling (default: true)
     * @return TextMask The field instance for method chaining
     */
    public function fillRequired(bool $required = true): TextMask
    {
        return $this->withMeta([
            __FUNCTION__ => $required,
        ]);
    }
}
