import {SpinnerInterface} from "./SpinnerInterface";

export class Spinner implements SpinnerInterface{

    private spinnerElement: Element;

    hideSpinner() {
        this.spinnerElement.classList.remove('display');
    };
    showSpinner() {
        this.spinnerElement.classList.add('display');
    };
    setSelector(selector: string) {
        const spinnerElement = document.querySelector(selector);

        if (null === spinnerElement) {
            throw new DOMException('This selector ' + selector + 'isn\'t found');
        }

        this.spinnerElement = spinnerElement;
    };
    toggleSpinner() {
        if (this.spinnerElement.classList.contains('display')) {
            this.spinnerElement.classList.remove('display');
        } else {
            this.spinnerElement.classList.add('display');
        }
    };
}