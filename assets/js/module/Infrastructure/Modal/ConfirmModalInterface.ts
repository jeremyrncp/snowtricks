import {ModalInterface} from "./ModalInterface";

export interface ConfirmModalInterface extends ModalInterface {
    confirmText: string;
    cancelText: string;
    path: string;

    setConfirmText(confirmText: string);
    setCancelText(cancelText: string);
    setPath(path: string);
}