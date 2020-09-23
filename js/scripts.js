'use strict';

const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());;

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {
      
      $("#product_id").val($(evt.target).data('id'));
      
      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      const popupEnd = document.querySelector('.shop-page__popup-end');

      buttonOrder.addEventListener('click', (evt) => {

        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('[required]'));

        inputs.forEach(inp => {

          if (!!inp.value) {

            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => !!inp.value)) {
          $.ajax({
            method: "POST",
            url: "/make_order.php",
            data: new FormData($('.js-order')[0]),
            processData: false,
            contentType: false,
          })
          .done(function( response ) {
            if(response.status == 'success') {
              evt.preventDefault();

              toggleHidden(shopOrder, popupEnd);

              popupEnd.classList.add('fade');
              setTimeout(() => popupEnd.classList.remove('fade'), 1000);

              window.scroll(0, 0);

              const buttonEnd = popupEnd.querySelector('.button');

              buttonEnd.addEventListener('click', () => {


                popupEnd.classList.add('fade-reverse');

                setTimeout(() => {

                  popupEnd.classList.remove('fade-reverse');

                  toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

                }, 1000);

              });

            } else {
              alert(response.data);
              window.scroll(0, 0);
              evt.preventDefault();
            }
          });
          evt.preventDefault();
        } else {
          window.scroll(0, 0);
          evt.preventDefault();
        }
      });
    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {

    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

        const status = evt.target.previousElementSibling;
        let status_value = (status.classList && status.classList.contains('order-item__info--no'))
        $.ajax({
          method: "POST",
          url: "/admin/order_toggle.php",
          data: {'status': status_value ? 1 : 0, 'id': $(status).data('id')},
        })
        .done(function( response ) {
          if(response.status == 'success') {
            status.textContent = status_value ? 'Выполнено' : 'Не выполнено';
            
            status.classList.toggle('order-item__info--no');
            status.classList.toggle('order-item__info--yes');
          } else {
            alert(response.data);
          }
        });

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#photo');

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

  const removeButton = document.querySelector('.add-list__item--active');
  if (removeButton) {
      removeButton.addEventListener('click', evt => {
        addList.removeChild(evt.target);
        addInput.value = '';
        checkList(addList, addButton);
      });
  }

  const popupEnd = document.querySelector('.page-add__popup-end');

  const button_add = document.querySelector('.button_add');
  if (button_add) {
      button_add.addEventListener('click', (evt) => {
        const formData = new FormData($("form")[0]);
        evt.preventDefault();
        $.ajax({
          method: "POST",
          url: "/admin/ajax_add.php",
          data: formData,
          processData: false,
          contentType: false,
        })
        .done(function( response ) {
          if(response.status == 'success') {
            form.hidden = true;
            popupEnd.hidden = false;
            window.setTimeout(function(){
              window.location.href = "/admin/products";
            }, 2000);
          } else {
            alert(response.data);
          }
        });

      })

  }

  const button_edit = document.querySelector('.button_edit');
  if (button_edit) {
      button_edit.addEventListener('click', (evt) => {
        const formData = new FormData($("form")[0]);
        evt.preventDefault();
        $.ajax({
          method: "POST",
          url: "/admin/ajax_edit.php?id=" + $(button_edit).data('id'),
          data: formData,
          processData: false,
          contentType: false,
        })
        .done(function( response ) {
          if(response.status == 'success') {
            form.hidden = true;
            popupEnd.hidden = false;
            window.setTimeout(function(){
              window.location.href = "/admin/products";
            }, 2000);
          } else {
            alert(response.data);
          }
        });

      })
  }

}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {
      $.ajax({
        method: "POST",
        url: "/admin/ajax_delete.php",
        data: { id: $(target).data('id') }
      })
      .done(function( response ) {
        if(response.status == 'success') {
          productsList.removeChild(target.parentElement);
        } else {
          alert(response.data);
        }
      });
    }

  });

}

// jquery range maxmin
if (document.querySelector('.shop-page')) {

  $('.range__line').slider({
    min: $(".range__line").data('min'),
    max: $(".range__line").data('max'),
    values: [$("#min_price").val(), $("#max_price").val()],
    range: true,
    stop: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

      $('#min_price').val($('.range__line').slider('values', 0));
      $('#max_price').val($('.range__line').slider('values', 1));

    },
    slide: function(event, ui) {

      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

      $('#min_price').val($('.range__line').slider('values', 0));
      $('#max_price').val($('.range__line').slider('values', 1));

    }
  });

  $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
  $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');

}

const change_order_column = (that) => {
    document.cookie = "order_column=" + that.options[that.selectedIndex].value + "; path=/; max-age=" + (60*60*24*30);
    document.location.reload(true);
};

const change_order_by = (that) => {
    document.cookie = "order_by=" + that.options[that.selectedIndex].value + "; path=/; max-age=" + (60*60*24*30);
    document.location.reload(true);
};

$(".button_continue").on("click", () => document.location.reload(true))
