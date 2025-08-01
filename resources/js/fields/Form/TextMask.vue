<template>
    <DefaultField
        :field="currentField"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <input
                :id="currentField.uniqueKey"
                :dusk="field.attribute"
                :disabled="currentlyIsReadonly"
                :autocomplete="currentField.autocomplete"
                v-maska="maskOptions"
                v-model="value"
                @maska="onMaskaEvent"
                v-bind="extraAttributes"
                class="w-full form-control form-input form-control-bordered"
                :class="errorClasses"
            />
        </template>
    </DefaultField>
</template>

<script>
import {DependentFormField, HandlesValidationErrors} from "laravel-nova";
import {vMaska} from "maska/vue";
import {createMaskOptions} from "@/helpers/maska";

export default {
    mixins: [DependentFormField, HandlesValidationErrors],

    directives: {
        maska: vMaska,
    },

    props: ["resourceName", "resourceId", "field"],

    data() {
        return {
            eventDetail: {
                masked: "",
                unmasked: "",
                completed: false,
            },
        };
    },

    computed: {
        /**
         * Build the options object for the v-maska directive.
         */
        maskOptions() {
            // Uses the helper to generate options based on field metadata
            return createMaskOptions(this.currentField);
        },

        /**
         * Get the *minimal* default attributes for the input field.
         * Simplified specifically for TextMask.
         */
        defaultAttributes() {
            return {
                type: "text",
                placeholder: this.currentField.placeholder || this.field.name,
            };
        },

        /**
         * Get the extra attributes for the input field.
         * Merges minimal defaults with user-defined extraAttributes.
         */
        extraAttributes() {
            // Spread defaultAttributes first, then user-defined extras
            // This allows user extras (like a different 'type' or 'placeholder') to override defaults if needed.
            return {
                ...this.defaultAttributes,
                ...this.currentField.extraAttributes,
            };
        },
    },

    methods: {
        /**
         * Set the initial value for the field.
         * Called by Nova (via DependentFormField mixin).
         */
        setInitialValue() {
            this.value = this.currentField.value || "";

            if (this.value) {
                this.eventDetail["completed"] = true;
            }
        },

        /**
         * Handle the Maska event to capture the mask details.
         */
        onMaskaEvent(event) {
            this.eventDetail = event.detail;
        },

        /**
         * Record a validation error for the field.
         * @param {string} message The validation error message.
         */
        recordError(message) {
            this.errors.record({[this.validationKey]: [message]});
        },

        /**
         * Fill the given FormData object with the field's internal value.
         * Called by Nova when submitting the form.
         */
        fill(formData) {
            if (this.currentField.fillRequired && this.currentField.mask && !this.eventDetail.completed) {
                const message = this.__('The :attribute field is incomplete', {
                    attribute: this.field.name,
                });
                this.recordError(message);
                throw {
                    field: this.field.attribute,
                    message: message,
                };
            }

            let valueToFill = this.value || '';

            // Determine if the raw (unmasked) value should be sent.
            // The 'raw' meta defaults to false if not explicitly set to false in PHP.
            const sendRawValue = this.currentField.raw ?? false;

            // Use the unmasked value if 'raw' is true AND an unmasked value exists from the mask event.
            if (sendRawValue && typeof this.eventDetail.unmasked === "string") {
                valueToFill = this.eventDetail.unmasked;
            }

            this.fillIfVisible(formData, this.field.attribute, valueToFill);
        },
    },
};
</script>
