<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <span v-if="field.value !== null && field.value !== ''">{{ maskedValue }}</span>
            <span v-else>&mdash;</span>
        </template>
    </PanelItem>
</template>

<script>
import {Mask} from 'maska';
import {createMaskOptions} from '../helpers/maska';

export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

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
                console.error(`[${this.field.attribute}] Error creating Maska instance for DetailField:`, error, this.field);
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

            if (this.masker && value !== null && typeof value !== 'undefined') {
                try {
                    return this.masker.masked(String(value));
                } catch (error) {
                    console.error(`[${this.field.attribute}] Error applying mask to value "${value}" in DetailField:`, error);
                }
            }
            // Return original value if no masker or value is null/undefined
            return value;
        },
    },
};
</script>
