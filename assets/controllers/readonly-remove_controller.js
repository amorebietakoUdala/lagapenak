import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

   connect() {
      // We do this to avoid autocompletion from the browser. We put readonly by default on html and remove it here
      this.element.removeAttribute('readonly');
   }
}