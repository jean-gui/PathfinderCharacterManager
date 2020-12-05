import {Controller} from 'stimulus';

export default class extends Controller {
    connect() {
        $('.mypopover').popover({
            placement: 'auto',
            html: true,
            container: 'body'
        });
    }

    disconnect() {
        $('.mypopover').popover('dispose');
    }
}