import {Controller} from 'stimulus';
import $ from 'jquery';

export default class extends Controller {
    get wrapper() {
        return $(this.element);
    }

    add(event) {
        var wrapper = this.wrapper;

        event.preventDefault();

        // Get the data-prototype explained earlier
        var prototype = wrapper.data('prototype');
        // get the new index
        var index = wrapper.data('index');
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);
        // increase the index with one for the next item
        wrapper.data('index', index + 1);
        // Display the form in the page before the "new" link
        $(event.target).before(newForm);
    }

    remove(event) {
        event.preventDefault();
        event.target.closest('.js-group-item')
            .fadeOut()
            .remove();
    }
}