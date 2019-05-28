Vue.component('vue-multiselect', window.VueMultiselect.default);

var profileFiltersVM = new Vue({
    el: window.profileFilters.formId,
    data: function() {
        return {
            vueModel: {},
        }
    },
    methods: {
        updateInput: function(target, value) {
            document.querySelector('input[name="'+target+'"]').value = value;
        }
    }
});