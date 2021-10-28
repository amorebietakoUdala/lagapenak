import {
    Controller
} from 'stimulus';

export default class extends Controller {
    static targets = [];
    static values = {
        locale: String,
    };

    locale = null;

    changeLocale(event) {
        event.preventDefault();
        if (this.localeValue === event.currentTarget.innerHTML) {
            return;
        } else {
            this.locale = event.currentTarget.innerHTML;
            let location = window.location.href;
            let location_new = location.replace("/" + this.localeValue + "/", "/" + event.currentTarget.innerHTML + "/");
            window.location.href = location_new;
        }
    }
}