const rc_removeCar = () => {
    const tableWrapper = document.querySelector('#wpbody-content')
    const removeBtn = document.querySelectorAll('.remove-car')
    removeBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            tableWrapper.classList.add('loading')
            const id = btn.getAttribute('data-id')
            const data = {
                'action': 'wp_markplace_remove_car',
                'id': id,
            }

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: data,
                type: 'POST',
                success: function (data) {
                    if (data && data == 200) {
                        alert('The car has been successfully removed')
                        btn.parentElement.parentElement.remove()
                        tableWrapper.classList.remove('loading')
                    } else {
                        alert('Error')
                    }
                }
            });
        })
    })
}


if (document.querySelector('.rc_add-car__table')) {
    rc_removeCar()
}


document.querySelector('.checks').addEventListener('click', () => {
    jQuery.ajax({
        url: '/wp-json/wm/v1/add-car-info/{"Peter":65,"Harry":80,"John":78,"Clark":90}',
        type: 'GET',
        success: function (data) {
            console.log(data);
        }
    });
})