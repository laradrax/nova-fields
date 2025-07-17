<template>
    <div :class="containerClasses">
        <template v-if="hasLinks">
            <div :class="wrapperClasses">
                <a
                    v-for="(link, idx) in field.links"
                    :key="`${field.attribute}-link-${idx}`"
                    :href="link.url"
                    :class="linkClasses(link.color)"
                    :target="link.openInNewTab ? '_blank' : null"
                    :rel="link.openInNewTab ? 'noopener noreferrer' : null"
                >
                    <span v-if="link.icon" v-html="link.icon" class="flex-shrink-0"/>
                    <span>{{ link.label }}</span>
                </a>
            </div>
        </template>
        <span v-else class="text-gray-400 dark:text-gray-500 text-xs italic">
          {{ noActionText }}
        </span>
    </div>
</template>

<script>
const DEFAULT_LINK_CLASS = 'bg-gray-100 text-gray-600 ring-gray-500/10'

/**
 * @typedef {Object} Link
 * @property {string} type
 * @property {string} url
 * @property {string} label
 * @property {string} [icon]
 * @property {string} [color]
 * @property {boolean} openInNewTab
 */

/**
 * @typedef {Object} FieldData
 * @property {string} attribute
 * @property {Link[]} links
 */

export default {
    props: {
        resourceName: {type: String, required: true},
        /** @type {FieldData} */
        field: {
            type: Object,
            required: true,
            validator: f =>
                typeof f?.attribute === 'string' && Array.isArray(f?.links),
        },
    },

    computed: {
        noActionText() {
            return this.__('No :attribute available', {
                attribute: this.field.name,
            });
        },

        hasLinks() {
            return Array.isArray(this.field.links) && this.field.links.length > 0
        },

        alignClass() {
            return this.field.align || 'justify-center'
        },

        containerClasses() {
            return ['flex', 'items-center', this.alignClass, 'py-3']
        },

        wrapperClasses() {
            return ['inline-flex', this.alignClass, 'gap-2', 'flex-wrap']
        },
    },

    methods: {
        /**
         * @param {string} color
         * @returns {Array<string>}
         */
        linkClasses(color) {
            return [
                'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset no-underline',
                color || DEFAULT_LINK_CLASS,
            ]
        },
    },
}
</script>

<style scoped>
a:not(:disabled):hover {
    opacity: 0.8;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}
</style>
