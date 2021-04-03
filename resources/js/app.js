require('./bootstrap');

require('alpinejs');

function isWriteMode() {
    var mode = $('#changeMode');
    return mode.data('mode') === 'write';
}

function changeButtons(mode) {
    let trashButton = $('i.fa-trash'),
    editButton = $('i.fa-edit'),
    modeButton = $('#changeMode');

    if (mode === 'read') {
        trashButton.css('color', '#606060');
        modeButton.text("Read Mode");
        modeButton.css('background-color', 'rgb(31, 41, 55)');
        editButton.css('color', '#606060');
    }
    if (mode === 'write') {
        trashButton.css('color', '#e3342f');
        editButton.css('color', 'rgb(59, 130, 246)');
        modeButton.text("Edit Mode");
        modeButton.css('background-color', '#670e0e');
    }
}
changeButtons('read');

const modeButton = $('#changeMode');
modeButton.click((event) => {
    const $this = $(event.target);
    var mode = $this.data('mode');

    if (mode === 'read') {
        $this.data('mode', 'write');
        mode = 'write'
    } else {
        $this.data('mode', 'read');
        mode = 'read';
    }

    changeButtons(mode);
    return true;
});

const destroyButtons = $('table form.destroy-action button[data-confirm]');
destroyButtons.click((event) => {
    event.preventDefault();
    if (!isWriteMode()) {
        alert("Funkja niedostepna! Włącz tryb edycji danych aby móc usunąć element");
        return false;
    }
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

const editButton = $('table div.edit-action a');
editButton.click((event) => {
    if (!isWriteMode()) {
        event.preventDefault();
        alert("Funkja niedostepna! Włącz tryb edycji danych aby móc usunąć element");
        return false;
    }
    return true;
});

const shareButton = $('table a.share-password');
shareButton.click((event) => {
    event.preventDefault();
    const $this = $(event.currentTarget);
    $.ajax($this.attr('href')).done((data) => {
        if (data.password) {
            navigator.clipboard.writeText(data.password).then(r => console.log("Copied" + r));
        } else {
            if (!data.error) {
                data.error = "Wystąpił niezidentyfikowany błąd";
            }
            alert(data.error);
        }
    });

    return false;
});

