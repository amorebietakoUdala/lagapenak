import { Controller } from 'stimulus';
import { useDispatch } from 'stimulus-use';
import Translator from 'bazinga-translator';
const translations = require('../../public/translations/'+Translator.locale+'.json');

import $ from 'jquery';

export default class extends Controller {
    static targets = ['form', 'token'];
    static values = {}

    connect() {
        useDispatch(this);
        Translator.fromJSON(translations);
    }

    async deleteConfirmation(event) {
        event.preventDefault();
        const confirmationText=Translator.trans('message.deleteConfirmationText');
        this.submit(confirmationText, event.currentTarget.dataset.return_url);
    }

    async loanConfirmation(event) {
        event.preventDefault();
        const confirmationText=Translator.trans('message.loanConfirmationText');
        this.submitForm(event,confirmationText);
    }

    async returnConfirmation(event) {
        event.preventDefault();
        const confirmationText=Translator.trans('message.returnConfirmationText');
        this.submitForm(event,confirmationText);
    }

    async submitForm(event, confirmationText) {
        this.tokenTarget.value=event.currentTarget.dataset.csrf_token;
        this.formTarget.action=event.currentTarget.dataset.url;
        this.submit(confirmationText);
    }

    async submit(confirmationText, returnUrl = null) {
        const Swal = await import ('sweetalert2');
        Swal.default.fire({
            template: '#confirmation-template',
            html: confirmationText,
        }).then(async(result) => {
            if (result.value) {
                const $form = $(this.formTarget);
                try {
                    await $.ajax({
                        url: $form.prop('action'),
                        method: $form.prop('method'),
                        data: $form.serialize(),
                    });
                    this.dispatch('success');
                    if (null !== returnUrl) {
                        document.location.href=returnUrl;
                    }
                } catch (e) {
                    Swal.default.fire('There was an error!!!: ' + e.responseText);
                }        
            }
        });
    }
}
