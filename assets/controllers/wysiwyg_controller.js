import {Controller} from 'stimulus';
import BalloonEditor from '@ckeditor/ckeditor5-build-balloon';

export default class extends Controller {
    editor;

    connect() {
        const content = this.element.querySelector('div.wysiwyg_content');

        BalloonEditor
            .create(content)
            .then(new_editor => {
                this.editor = new_editor;
            })
            .catch(error => {
            });

    }

    disconnect() {
        this.editor.destroy();
    }

    submit(event) {
        event.preventDefault();
        this.element.querySelector('textarea').textContent = this.editor.getData();
        this.element.submit();
    }
}