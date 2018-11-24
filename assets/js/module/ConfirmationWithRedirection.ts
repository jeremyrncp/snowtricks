import {ConfirmModalInterface} from "./Infrastructure/Modal/ConfirmModalInterface";

export class ConfirmationWithRedirection {

    confirmModal: ConfirmModalInterface;

    constructor(confirmModal: ConfirmModalInterface) {
        this.confirmModal = confirmModal;
    }

    showConfirmAndRedirectModal(
        title: string,
        description: string,
        cancel: string,
        confirm: string,
        path: string
    ) {
        this.confirmModal.setTitle(title);
        this.confirmModal.setDescription(description);
        this.confirmModal.setCancelText(cancel);
        this.confirmModal.setConfirmText(confirm);
        this.confirmModal.setPath(path);

        this.confirmModal.show();
    }
}