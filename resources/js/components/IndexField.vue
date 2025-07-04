<template>
    <div :class="`text-${field.textAlign}`">
        <template v-if="fieldHasValue">
            <CopyButton
                v-if="field.copyable"
                :text="field.value"
                @click.prevent.stop="copy"
                v-tooltip="__('Copy to clipboard')"
                class="mr-1"
            >
                <span ref="theFieldValue">{{ maskedValue }}</span>
            </CopyButton>
            <span v-else-if="!field.copyable" class="whitespace-nowrap">
        {{ maskedValue }}
      </span>
        </template>
        <p v-else>&mdash;</p>
    </div>
</template>

<script>
import { CopiesToClipboard, FieldValue } from "laravel-nova";
import { Mask } from "maska";
import { createMaskOptions } from "../helpers/maska";

export default {
    mixins: [CopiesToClipboard, FieldValue],

    props: ["resourceName", "field"],

    data() {
        return {
            masker: null,
        };
    },

    created() {
        // Initialize the masker only if a mask is defined for the field
        if (this.field.mask) {
            try {
                const options = createMaskOptions(this.field);
                this.masker = new Mask(options);
            } catch (error) {
                console.error(
                    `[${this.field.attribute}] Error creating Maska instance for IndexField:`,
                    error,
                    this.field
                );
            }
        }
    },

    computed: {
        /**
         * Computes the masked value for display.
         * Returns the original value if no mask is defined or if masking fails.
         */
        maskedValue() {
            const value = this.field.value;

            if (this.masker && value !== null && typeof value !== "undefined") {
                try {
                    return this.masker.masked(String(value));
                } catch (error) {
                    console.error(
                        `[${this.field.attribute}] Error applying mask to value "${value}" in IndexField:`,
                        error
                    );
                }
            }
            // Return original value if no masker or value is null/undefined
            return value;
        },
    },

    methods: {
        /**
         * Copy the field's *original* value to the clipboard.
         * The CopiesToClipboard mixin provides copyValueToClipboard.
         * Nova's CopyButton component uses the :text prop directly,
         * but having this method ensures clarity if the button implementation changes.
         */
        copy() {
            // Pass the *original* field value, not the masked one or fieldValue (which might be modified by displayUsing).
            this.copyValueToClipboard(this.field.value);
        },
    },
};
</script>
