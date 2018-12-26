import {Spinner} from "./module/spinner";
import {ConfirmationWithRedirection} from "./module/ConfirmationWithRedirection";
import {SwalConfirmAndRedirectionModal} from "./module/Infrastructure/Modal/SwalConfirmAndRedirectionModal";

const $ = require('jquery');

const selectorBtnMoreTricks = '#moreTricks';
const selectorContainerListTricks = '#listTricks';
const selectorSpinner = '#spinner';
const selectorDeleteWithConfirmationModal = '.delete-with-confirmation';

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


    const deleteTricks = document.querySelectorAll(selectorDeleteWithConfirmationModal);
    const confirmAndRedirectionModal = new SwalConfirmAndRedirectionModal();

    Array.from(deleteTricks).forEach(trick => {
        trick.addEventListener('click', function(event) {
            event.stopImmediatePropagation();
            event.stopPropagation();

            let path = trick.getAttribute('data-path');

            let confirmationWithRedirection = new ConfirmationWithRedirection(confirmAndRedirectionModal);
            confirmationWithRedirection.showConfirmAndRedirectModal(
                'Delete trick',
                'Do you really want delete this trick and related medias ?',
                'No',
                'Yes',
                path
            );
        });
    });
})();