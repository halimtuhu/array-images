Nova.booting((Vue, router) => {
    Vue.component('index-array-images', require('./components/IndexField'));
    Vue.component('detail-array-images', require('./components/DetailField'));
    Vue.component('form-array-images', require('./components/FormField'));
})
