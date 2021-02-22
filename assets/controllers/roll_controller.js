import {Controller} from 'stimulus';

const httpRequest = new XMLHttpRequest();

export default class extends Controller {
    static targets = ["result"]
    static values = {
        expression: String
    }

    roll(event) {
        var self = this;
        self.resultTarget.innerText = '';
        httpRequest.open('GET', '/en/roll?e='+ encodeURIComponent(this.expressionValue), true);
        httpRequest.send();


        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    const $resp = JSON.parse(httpRequest.responseText);
                    self.resultTarget.title     = $resp['details'];
                    self.resultTarget.innerText = $resp['result'];
                } else {
                    self.resultTarget.innerText = '!';
                }
            }
        };
    }
}