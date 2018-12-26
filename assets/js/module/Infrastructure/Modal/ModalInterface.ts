export interface ModalInterface {
    title: string;
    description: string;

    setTitle(title: string);
    setDescription(description: string);
    show();
}