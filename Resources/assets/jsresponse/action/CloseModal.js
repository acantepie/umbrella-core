import JsResponseAction from "umbrella_core/jsresponse/JsResponseAction";

export default class CloseModal extends JsResponseAction {
    eval(params) {
        let $opened_modal = $('.js-umbrella-modal.show');
        if ($opened_modal.length) {
            $opened_modal.modal('hide');
        }
    }
}