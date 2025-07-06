import kebabCase from 'lodash/kebabCase'

Nova.booting(
    /**
     * @param {NovaApp} app
     */
    (app) => {
        registerFields(app)
    }
)

/**
 * @param {NovaApp} app
 * @param {string} type
 * @param {__WebpackModuleApi.RequireContext} requireComponent
 */
function registerComponents(app, type, requireComponent) {
    requireComponent.keys().forEach(fileName => {
        const componentConfig = requireComponent(fileName)

        const componentFileName = fileName.split('/').pop().replace(/\.\w+$/, '')
        const componentName = kebabCase(type+componentFileName)

        app.component(
            componentName,
            componentConfig.default || componentConfig
        )
    })
}

/**
 * @param {NovaApp} app
 */
function registerFields(app) {
    registerComponents(
        app,
        'Index',
        require.context(`./fields/Index`, true, /[A-Z]\w+\.(vue)$/)
    )
    registerComponents(
        app,
        'Detail',
        require.context(`./fields/Detail`, true, /[A-Z]\w+\.(vue)$/)
    )
    registerComponents(
        app,
        'Form',
        require.context(`./fields/Form`, true, /[A-Z]\w+\.(vue)$/)
    )
    registerComponents(
        app,
        'Filter',
        require.context(`./fields/Filter`, true, /[A-Z]\w+\.(vue)$/)
    )
    registerComponents(
        app,
        'Preview',
        require.context(`./fields/Preview`, true, /[A-Z]\w+\.(vue)$/)
    )
}
