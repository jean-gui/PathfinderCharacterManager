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