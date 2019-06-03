Vue.component('vue-multiselect', window.VueMultiselect.default);

var profileFiltersVM = new Vue({
    el: window.profileFilters.formId,
    data: function() {
        return {
            vueModel: window.profileFilters.initialValues
        }
    }
});