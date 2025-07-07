<template>
    <div class="flex items-center justify-start">
        <div v-if="field.links && field.links.length > 0" class="inline-flex gap-1 flex-wrap">
            <a
                v-for="(link, index) in visibleLinks"
                :key="`${field.attribute}-link-${index}`"
                :href="link.url"
                :class="getLinkClasses(link.style)"
                :target="link.openInNewTab ? '_blank' : undefined"
                :rel="link.openInNewTab ? 'noopener noreferrer' : undefined"
                @click.stop
            >
                <span v-html="link.icon" class="flex-shrink-0"></span>
                <span class="max-md:hidden">{{ link.label }}</span>
            </a>
            <a
                href="#"
                v-if="hasMoreLinks"
                :class="getLinkClasses()"
                @click.prevent
            >
                +{{ remainingCount }}
            </a>
        </div>
        <span v-else class="text-gray-400 dark:text-gray-500 text-xs">
          —
        </span>
    </div>
</template>

<script>
/**
 * @typedef {Object} Link
 * @property {string} type
 * @property {string} url
 * @property {string} label
 * @property {string} [icon]
 * @property {string} [style]
 * @property {boolean} openInNewTab
 */

/**
 * @typedef {Object} FieldData
 * @property {string} attribute
 * @property {Link[]} links
 */
export default {
    props: {
        resourceName: {
            type: String,
            required: true,
        },
        /**
         * @param {FieldData} field
         */
        field: {
            type: Object,
            required: true,
            validator: (field) => {
                return (
                    typeof field === 'object' &&
                    typeof field.attribute === 'string' &&
                    Array.isArray(field.links)
                );
            },
        },
    },

    computed: {
        maxVisibleLinks() {
            return 2
        },

        visibleLinks() {
            return this.field.links?.slice(0, this.maxVisibleLinks) || []
        },

        hasMoreLinks() {
            return (this.field.links?.length || 0) > this.maxVisibleLinks
        },

        remainingCount() {
            return this.field.links.length - this.maxVisibleLinks
        },
    },

    methods: {
        /**
         * @param {string} style
         * @returns {string}
         */
        getLinkClasses(style) {
            const linkClass = typeof style === 'string'
                ? style
                : 'bg-gray-100 text-gray-600 ring-gray-500/10';
            return [
                'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                linkClass,
                'no-underline',
            ]
                .filter(Boolean)
                .join(' ')
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
