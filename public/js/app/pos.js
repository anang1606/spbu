var _token = 'all',
    _uuid = 'all'

const categoryBtn = document.querySelectorAll(".btn-category")
const brandBtn = document.querySelectorAll(".btn-brand")

const setActive = () => {
    const dataTd = document.querySelectorAll('[data-td="product"]')
    const productActive = document.querySelectorAll('.product-custom-card.active')
    productActive.forEach((active) => {
        active.classList.remove('active')
    })
    dataTd.forEach((td) => {
        const productList = document.querySelectorAll('[active-list="' + td.getAttribute('data-active') + '"]')
        if(productList.length > 0)
            productList[0].classList.add('active')
    })
}

if (categoryBtn.length > 0) {
    categoryBtn.forEach((btn) => {
        btn.addEventListener("click", (evnt) => {
            const activeFilterCategory = document.querySelectorAll(
                ".btn-category.button-list__item-active"
            );
            activeFilterCategory[0].classList.remove(
                "button-list__item-active"
            );
            btn.classList.add("button-list__item-active")
            _token = btn.getAttribute('data-category')
            getProduct()
        });
    });
}
if (brandBtn.length > 0) {
    brandBtn.forEach((btn) => {
        btn.addEventListener("click", (evnt) => {
            const activeFilterBrand = document.querySelectorAll(
                ".btn-brand.button-list__item-active"
            );
            activeFilterBrand[0].classList.remove(
                "button-list__item-active"
            );
            btn.classList.add("button-list__item-active")
            _uuid = btn.getAttribute('data-brand')
            getProduct()
        });
    });
}
const getProduct = () => {
    axios({
        method: "POST",
        url: "/pos/product-api",
        data: {
            _token: btoa(_token),
            _uuid: btoa(_uuid),
        },
    })
        .then((response) => {
            const result = response.data
            // mengambil kontainer tujuan
            const container = document.getElementById('product-container');

            // Menghapus semua isi dari container
            container.innerHTML = '';

            // mengambil template element
            const template = document.getElementById('product-product');
            const templateNoFound = document.getElementById('filter-not-found');

            container.innerHTML = ''
            if (result.length > 0) {
                container.innerHTML = '<div class="product-list-block pt-1 scollable"><div class="d-flex flex-wrap product-list-block__product-block" id="product-section"></div></div>'
                const productSection = document.getElementById('product-section')
                const items = result.map(product => {
                    // membuat salinan template
                    const clone = template.content.cloneNode(true);
                    const url = atob(clone.querySelector('[data-template="image"]').getAttribute('data-url'))

                    clone.querySelector('[data-template="name"]').textContent = product.name;
                    clone.querySelector('[data-template="conten"]').setAttribute('data-product', product.code + ` (${product.name})`);
                    clone.querySelector('[data-template="conten"]').setAttribute('active-list', product.code);
                    clone.querySelector('[data-template="code"]').textContent = product.code;
                    clone.querySelector('[data-template="image"]').setAttribute('src', url + '/' + product.base_image);

                    return clone;
                })
                productSection.append(...items)
                setTimeout(() => {
                    setActive()
                }, 450);
            } else {
                container.append(templateNoFound.content.cloneNode(true))
            }
        })
        .catch((err) => console.log(err))
};

$(document).ready(function () {
    getProduct()
    localStorage.clear()
    function timer() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var sec = currentTime.getSeconds();

        var dd = String(currentTime.getDate()).padStart(2, '0');
        var mm = String(currentTime.getMonth() + 1).padStart(2, '0');
        var yyyy = currentTime.getFullYear();

        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (sec < 10) {
            sec = "0" + sec;
        }
        var t_date = dd + '-' + mm + '-' + yyyy;
        var t_str = hours + ":" + minutes + ":" + sec + " ";

        document.getElementById('time_now').value = t_date + ' ' + t_str;
        setTimeout(timer, 1000);
    };
    timer();
});

window.addEventListener('keydown', (e) => {
    // if (e.keyCode === 113) {
    //     modalSearch()
    // }

    // if ($('#search-details-modal').hasClass('show') && tableFocus === false) {
    //     if (e.keyCode === 40) {
    //         $("tr[tabindex=0]").focus();
    //         countTr = document.querySelectorAll('#table-search-product .modal-search-tr').length
    //         setTimeout(() => {
    //             tableFocus = true
    //         }, 250)
    //     }
    // }

    if (e.keyCode === 45) {
        $('#cash-btn').trigger('click')
    }
    if (e.keyCode === 120) {
        $('#cancel-btn').trigger('click')
    }
    if (e.keyCode === 119) {
        $('#draft-btn').trigger('click')
    }

    if ($('#add-payment').hasClass('show')) {
        if (e.keyCode === 13) {
            $('#submit-btn').click()
        }
    }

    // if ($('#modal-faktur').hasClass('show')) {
    //     if (e.keyCode === 13) {
    //         $('#print-faktur-button').click()
    //     }
    // }

    // if ($('#search-details-modal').hasClass('show') && tableFocus === true) {
    //     if (e.keyCode === 40) {
    //         var idx = ($("tr:focus").attr("tabindex")) ? $("tr:focus").attr("tabindex") : -1;
    //         idx++;

    //         if (idx > countTr) {
    //             idx = 0;
    //         }

    //         $("tr[tabindex=" + idx + "]").focus();
    //     }

    //     if (e.keyCode === 38) {
    //         var idx = $("tr:focus").attr("tabindex");
    //         idx--;

    //         if (idx < 0) {
    //             idx = countTr;
    //         }

    //         $("tr[tabindex=" + idx + "]").focus();

    //         if (idx === countTr) {
    //             $("#input_search_modal").focus();
    //         }
    //     }
    // }

});
