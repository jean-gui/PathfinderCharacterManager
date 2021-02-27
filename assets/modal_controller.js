import {Controller} from 'stimulus';

export default class extends Controller {
    connect() {
        //$('[data-toggle=modal]').click(function (event) {event.preventDefault(); console.log('lol'); return false;});
        //$('[data-toggle=modal]').modal();
    }

    disconnect() {
        $('[data-toggle=modal]').modal('dispose');
    }
}