const $ = require('jquery');

const selectorBtnMoreTricks = '#moreTricks';
const selectorContainerListTricks = '#listTricks';

module.exports = (function() {
    const btnMoreTricks = document.querySelector(selectorBtnMoreTricks);

    btnMoreTricks.addEventListener('click', function (event) {
        const length = 10 + Number(btnMoreTricks.getAttribute('data-length'));
        $.ajax({
            'data': {
                'end':  length
            },
            'url': '/api/ressources/tricks',
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