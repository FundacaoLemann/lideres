Vue.component('vue-multiselect', window.VueMultiselect.default);

var profileFiltersVM = new Vue({
    el: window.profileFilters.formId,
    data: function() {
        return {
            vueModel: window.profileFilters.initialValues
        }
    }
});

jQuery(function () {
    var countrySelect = document.querySelector('select#field_812');
    var stateField = document.querySelector('.field_813');
    var cityField = document.querySelector('.field_814');

    countrySelect.addEventListener('change', function () {
        if (countrySelect.value === 'Brasil' || countrySelect.value === '') {
            stateField.style.display = '';
            cityField.style.display = '';
        } else {
            stateField.style.display = 'none';
            cityField.style.display = 'none';
        }
    });
});