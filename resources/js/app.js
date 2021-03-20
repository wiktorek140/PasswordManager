require('./bootstrap');

require('alpinejs');

const destroyButtons = $('table form.destroy-action button[data-confirm]');
destroyButtons.click((event) => {
    event.preventDefault();
    const $this = $(event.target);
    const $destroyButton = $this.is('button') ? $this : $this.closest('button');
    const message = $destroyButton.data('confirm');
    const form = $destroyButton.closest('form');
    if (message && confirm(message)) {
        form.submit();
    }
});

const showButton = $('table div.show-action a');
showButton.click((event) => {
    event.preventDefault();
    const $this = $(event.currentTarget);

    $.ajax($this.attr('href')).done((data) => {
        console.log(data);
        if (data.password) {
            let pass = $this.closest('tr').find('span.password');

            if (pass.text() !== "********") {
                pass.text("********");
            } else {
                pass.text(data.password);
            }
        } else {
            if (!data.error) {
                data.error = "Wystąpił niezidentyfikowany błąd";
            }

            alert(data.error);
        }
    });

    return false;
});
