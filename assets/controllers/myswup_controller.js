import {Controller} from 'stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('swup:connect', this._onConnect);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('swup:connect', this._onConnect);
    }

    _onConnect(event) {
        //event.detail.swup.on('contentReplaced', init);
        // Swup has just been intialized and you can access details from the event
        //console.log(event.detail.swup); // Swup instance
        //console.log(event.detail.options); // Options used to initialize Swup
    }
}