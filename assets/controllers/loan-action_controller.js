import { Controller } from '@hotwired/stimulus';

import $ from 'jquery';

export default class extends Controller {
    static targets = ['form'];
    static values = {}

    async deleteConfirmation(event) {
        event.preventDefault();
        this.submit(event.currentTarget.dataset.return_url);
    }

    async submit(returnUrl = null) {
        const Swal = await import ('sweetalert2');
        Swal.default.fire({
            template: '#confirm',
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
                    if (null != returnUrl) {
                        document.location.href=returnUrl;
                    }
                } catch (e) {
                    Swal.default.fire('There was an error!!!: ' + e.responseText);
                }        
            }
        });
    }
}
