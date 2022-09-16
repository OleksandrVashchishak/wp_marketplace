if (document.querySelector('.rc_add-car__wrapper')) {
    const submit = document.querySelector('.rc_add-car__wrapper button')
    const tableWrapper = document.querySelector('body')
    submit.addEventListener('click', () => {
        tableWrapper.classList.add('loading')
        const brand = document.querySelector('.rc_add-car__brand')
        const model = document.querySelector('.rc_add-car__model')
        const year = document.querySelector('.rc_add-car__year')
        const mileage = document.querySelector('.rc_add-car__mileage')
        const price = document.querySelector('.rc_add-car__price')
        const data = {
            'action': 'wp_markplace_create_new_rent',
            'brand': brand.value,
            'model': model.value,
            'year': year.value,
            'mileage': mileage.value,
            'price': price.value,
        }

        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: data,
            type: 'POST',
            success: function (data) {
                if (data && data == 200) {
                    alert('The car has been successfully added')

                    brand.value = ''
                    model.value = ''
                    year.value = ''
                    mileage.value = ''
                    price.value = ''

                    tableWrapper.classList.remove('loading')
                } else {
                    alert('Error')
                }
            }
        });
    })
}