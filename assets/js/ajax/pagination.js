if (document.querySelector('.rc_add-car__table')) {
    const tableWrapper = document.querySelector('#wpbody-content')
    const table = document.querySelector('.rc_add-car__table tbody')
    const paginationBtn = document.querySelectorAll('.pagination button')
    paginationBtn.forEach(btn => {
        btn.addEventListener('click', () => {
            tableWrapper.classList.add('loading')
            const page = btn.getAttribute('data-page')
            const data = {
                'action': 'wp_markplace_pagination',
                'page': page,
            }

            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: data,
                type: 'POST',
                success: function (data) {
                    if (data) {
                        table.innerHTML = data
                        rc_removeCar()
                    }
                    tableWrapper.classList.remove('loading')
                    changeCurrentBtn(paginationBtn, btn)
                }
            });
        })
    })


    const changeCurrentBtn = (paginationBtn, currentBtn) => {
        paginationBtn.forEach(btn => {
            btn.classList.remove('current')
        })
        currentBtn.classList.add('current')
    }
}