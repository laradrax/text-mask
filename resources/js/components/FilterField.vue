<template>
    <FilterContainer>
        <span>{{ filter.name }}</span>
        <template #filter>
            <input
                :id="filter.field.uniqueKey || filter.filterKey"
                :dusk="filter.field.attribute"
                type="text"
                class="w-full form-control form-input form-input-bordered"
                :placeholder="filter.field.placeholder || filter.name"
                v-model="value"
                v-maska="maskOptions"
                @input="handleChange"
                @keydown.enter.prevent="emitChange"
            />
        </template>
    </FilterContainer>
</template>

<script>
import debounce from "lodash/debounce";
import { vMaska } from "maska/vue";
import { createMaskOptions } from "../helpers/maska";

export default {
    emits: ["change"],

    directives: {
        maska: vMaska,
    },

    props: {
        resourceName: { type: String, required: true },
        filterKey: { type: String, required: true },
    },

    data: () => ({
        value: "",
        debouncedEmitChange: null,
    }),

    created() {
        // Debounce the change emitter
        this.debouncedEmitChange = debounce(() => this.emitChange(), 500);

        // Set the initial value from the store
        this.setCurrentFilterValue();

        // Register listener for filter reset event
        Nova.$on("filter-reset", this.handleFilterReset);
    },

    beforeUnmount() {
        // Unregister listener
        Nova.$off("filter-reset", this.handleFilterReset);
        // Cancel any pending debounced calls
        if (this.debouncedEmitChange) {
            this.debouncedEmitChange.cancel();
        }
    },

    methods: {
        /**
         * Set the current value from the Vuex store.
         */
        setCurrentFilterValue() {
            this.value = this.filter?.currentValue ?? "";
        },

        /**
         * Handle the input event.
         * Update the local value and trigger the debounced change emitter.
         */
        handleChange() {
            this.debouncedEmitChange();
        },

        /**
         * Emit the change event to Nova.
         */
        emitChange() {
            this.$emit("change", {
                filterClass: this.filterKey,
                value: this.value,
            });
        },

        /**
         * Handle the filter-reset event.
         */
        handleFilterReset() {
            this.value = this.filter?.initialValue ?? "";
            this.emitChange();
        },
    },

    computed: {
        /**
         * Get the filter definition from the Vuex store.
         */
        filter() {
            return this.$store.getters[`${this.resourceName}/getFilter`](
                this.filterKey
            );
        },

        /**
         * Get the field definition associated with the filter.
         */
        field() {
            // Important: Access field properties via this.filter.field
            return this.filter?.field;
        },

        /**
         * Build the options object for the v-maska directive.
         * Uses the helper and field properties from the filter definition.
         */
        maskOptions() {
            // Ensure field exists before creating options
            return this.field ? createMaskOptions(this.field) : {};
        },
    },
};
</script>
