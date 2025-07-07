<template>
    <div :class="containerClasses">
        <template v-if="hasLinks">
            <div :class="wrapperClasses">
                <a
                    v-for="(link, idx) in visibleLinks"
                    :key="`${field.attribute}-link-${idx}`"
                    :href="link.url"
                    :class="linkClasses(link.color)"
                    :target="link.openInNewTab ? '_blank' : null"
                    :rel="link.openInNewTab ? 'noopener noreferrer' : null"
                    @click.stop
                >
                    <span v-if="link.icon" v-html="link.icon" class="flex-shrink-0"/>
                    <span class="max-md:hidden">{{ link.label }}</span>
                </a>
                <a
                    v-if="hasMoreLinks"
                    href="#"
                    :class="linkClasses()"
                    @click.prevent
                >
                    +{{ remainingCount }}
                </a>
            </div>
        </template>
        <span v-else class="text-gray-400 dark:text-gray-500 text-xs">—</span>
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
        alignClass() {
            return this.field.align || 'justify-start'
        },
        containerClasses() {
            return ['flex', 'items-center', this.alignClass]
        },
        wrapperClasses() {
            return ['inline-flex', this.alignClass, 'gap-1', 'flex-wrap']
        },
        maxVisibleLinks() {
            return 2
        },
        visibleLinks() {
            return this.field.links?.slice(0, this.maxVisibleLinks) || []
        },
        hasLinks() {
            return (this.field.links?.length || 0) > 0
        },
        hasMoreLinks() {
            return (this.field.links?.length || 0) > this.maxVisibleLinks
        },
        remainingCount() {
            return (this.field.links?.length || 0) - this.maxVisibleLinks
        },
    },

    methods: {
        /**
         * Returns classes for the link based on the provided color.
         * @param {string} color
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
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.1);
}

@media (prefers-color-scheme: dark) {
    a:not(:disabled):hover {
        opacity: 0.8;
        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
    }
}
</style>
