import Translator from 'bazinga-translator';
const translations = require('../../../public/translations/'+Translator.locale+'.json');

export async function showAlert (title, html, confirmationButtonText, cancelButtonText, confirmURL) {
    const Swal = await import('sweetalert2');
    Swal.default.fire({
        title: title,
        html: html,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: cancelButtonText,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirmationButtonText,
    }).then( function (result) {
    if (result.value) {
        document.location.href=confirmURL;
    }
    });
}

export function createConfirmationAlert(confirmURL) {
    Translator.fromJSON(translations);
    
    showAlert(
		Translator.trans('message.confirmationTitle'), 
		Translator.trans('message.deleteConfirmationDetail'), 
		Translator.trans('btn.accept'), 
		Translator.trans('btn.cancel'), 
		confirmURL
	);
}