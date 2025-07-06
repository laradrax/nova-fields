<template>
    <div class="flex items-center justify-start">
        <div v-if="field.links && field.links.length > 0" class="inline-flex gap-1 flex-wrap">
            <a
                v-for="(link, index) in visibleLinks"
                :key="`${field.attribute}-link-${index}`"
                :href="link.url"
                :class="getLinkClasses(link)"
                :target="link.openInNewTab ? '_blank' : undefined"
                :rel="link.openInNewTab ? 'noopener noreferrer' : undefined"
                class="inline-flex items-center gap-0.5 rounded-full px-2 py-0.5 text-[10px] font-medium transition-all duration-150 no-underline"
                @click.stop
            >
                <span v-html="link.icon" class="flex-shrink-0"></span>
                <span class="max-md:hidden">{{ link.label }}</span>
            </a>
            <span
                v-if="hasMoreLinks"
                class="text-[10px] text-gray-400 dark:text-gray-500 px-1"
            >
        +{{ remainingCount }}
      </span>
        </div>
        <span v-else class="text-gray-400 dark:text-gray-500 text-xs">
      —
    </span>
    </div>
</template>

<script>
export default {
    props: {
        resourceName: {
            type: String,
            required: true,
        },
        field: {
            type: Object,
            required: true,
        },
    },

    computed: {
        maxVisibleLinks() {
            // Show fewer links on index to save space
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
        getLinkClasses(link) {
            return [
                link.style || '',
                'hover:scale-105',
            ].filter(Boolean).join(' ')
        },
    },
}
</script>

<style scoped>
:deep(svg) {
    width: 0.625rem;
    height: 0.625rem;
}

/* Smaller badges for index view */
a {
    font-size: 0.625rem;
    line-height: 1rem;
}

/* Prevent row click when clicking badges */
a:hover {
    z-index: 10;
}
</style>
