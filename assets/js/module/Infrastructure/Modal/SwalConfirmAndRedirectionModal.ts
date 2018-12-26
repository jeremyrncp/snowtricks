import {ConfirmModalInterface} from "./ConfirmModalInterface";
import swal from "sweetalert2";

export class SwalConfirmAndRedirectionModal implements ConfirmModalInterface {
    cancelText: string;
    confirmText: string;
    description: string;
    path: string;
    title: string;

    setCancelText(cancelText: string) {
        this.cancelText = cancelText;
    }

    setConfirmText(confirmText: string) {
        this.confirmText = confirmText;
    }

    setDescription(description: string) {
        this.description = description;
    }

    setPath(path: string) {
        this.path = path;
    }

    setTitle(title: string) {
        this.title = title;
    }

    verifAttributes() {
        if (
            this.description === undefined ||
            this.cancelText === undefined ||
            this.confirmText === undefined ||
            this.path === undefined ||
            this.title === undefined
        ) {
            throw  "You must defined all parameters before use show method";
        }
    }

    show() {
        this.verifAttributes();

        swal({
            title: this.title,
            text: this.description,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: this.confirmText
        }).then((result) => {
            if (result.value) {
                window.location.href = this.path;
            }
        })
    }
}