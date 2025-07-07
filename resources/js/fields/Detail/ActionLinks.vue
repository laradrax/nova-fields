<template>
    <div class="flex items-center justify-center py-3">
        <div v-if="Array.isArray(field.links) && field.links.length > 0" class="inline-flex gap-2 flex-wrap">
            <a
                v-for="(link, index) in field.links"
                :key="`${field.attribute}-link-${index}`"
                :href="link.url"
                :class="getLinkClasses(link.style)"
                :target="link.openInNewTab ? '_blank' : undefined"
                :rel="link.openInNewTab ? 'noopener noreferrer' : undefined"
            >
                <span v-if="link.icon" v-html="link.icon" class="flex-shrink-0"></span>
                <span>{{ link.label }}</span>
            </a>
        </div>
        <span v-else class="text-gray-400 dark:text-gray-500 text-xs italic">
            {{ __('No actions available') }}
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
};
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
