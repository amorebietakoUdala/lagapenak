import { Controller } from 'stimulus';

import '../js/common/datepicker';
import '../js/common/select2';

import $ from 'jquery';

export default class extends Controller {
    static targets = [];
    static values = {}

    connect() {
        const options = {
            format: "yyyy-mm-dd",
            language: global.locale,
            weekStart: 1
        }
        $('.js-datepicker').datepicker(options);
        $('.js-askedBySelect').select2();
    }
}
