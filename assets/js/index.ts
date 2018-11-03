import {Spinner} from "./module/spinner";

const $ = require('jquery');

const selectorBtnMoreTricks = '#moreTricks';
const selectorContainerListTricks = '#listTricks';
const selectorSpinner = '#spinner';

module.exports = (function() {
    const btnMoreTricks = document.querySelector(selectorBtnMoreTricks);
    const spinner = new Spinner();
          spinner.setSelector(selectorSpinner);

    btnMoreTricks.addEventListener('click', function (event) {
        const length = 10 + Number(btnMoreTricks.getAttribute('data-length'));
                        btnMoreTricks.setAttribute('data-length', String(length));

        spinner.showSpinner();

        $.ajax({
            'data': {
                'end':  length
            },
            'url': '/api/ressources/tricks',
            'complete': function() {
                spinner.hideSpinner();
            },
            'success': function(res) {
                const tricksContainer = document.querySelector(selectorContainerListTricks);
                      tricksContainer.innerHTML = res;
            },
            'error': function(xhr, status, error) {
                alert('An error has occurred during tricks recuperation ' + status);
            }
        });
    });
})();