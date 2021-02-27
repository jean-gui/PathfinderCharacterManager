import {Controller} from 'stimulus';

const httpRequest = new XMLHttpRequest();

export default class extends Controller {
    static targets = ["result"]
    static values = {
        expression: String,
        type: String
    }

    customRoll(event) {
        event.preventDefault();
        var self = this;
        httpRequest.open(event.target.method, event.target.action, true);
        httpRequest.send(new FormData(event.target));

        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    self.resultTarget.innerHTML = httpRequest.responseText;
                } else {
                    self.resultTarget.innerText = '!';
                }
            }
        };
    }

    roll(event) {
        const self = this;
        let characterId = null;
        let locale = 'en';
        const pieces = window.location.pathname.split('/');
        if (pieces.length > 3 && pieces[2] === 'characters') {
            characterId = parseInt(pieces[3]);
            locale = pieces[1];
        }
        self.resultTarget.innerText = '';
        const formData = new FormData();
        formData.append('form[expression]', this.expressionValue);
        formData.append('form[type]', this.typeValue);
        httpRequest.open('POST', '/' + locale + '/characters/' + characterId + '/roll', true);
        httpRequest.setRequestHeader('Accept', 'application/json');
        httpRequest.send(formData);

        httpRequest.onreadystatechange = function () {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    const response = JSON.parse(httpRequest.responseText);
                    self.resultTarget.title = '';
                    self.resultTarget.innerText = '';
                    let separator = '; ';
                    response.forEach(function (element, idx, array) {
                        if (idx === array.length -1) {
                            separator = '';
                        }
                        self.resultTarget.innerText += element.result + separator;
                        self.resultTarget.title += element.details + separator;
                    });
                } else {
                    self.resultTarget.innerText = '!';
                }
            }
        };
    }
}