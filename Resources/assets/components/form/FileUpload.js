import Utils from "umbrella_core/utils/Utils";

export default class FileUpload {

    constructor($elt) {
        this.$view = $elt;

        this.$inputFile = this.$view.find('input.js-umbrella-file');
        this.$inputEntity = this.$view.find('input.js-umbrella-entity');
        this.$inputTxt = this.$view.find('input.js-umbrella-text');
        this.$inputDelete = this.$view.find('input.js-umbrella-delete');

        this.$removeBtn = this.$view.find('.js-umbrella-remove');
        this.$downloadBtn = this.$view.find('.js-umbrella-download');
        this.$browseBtn = this.$view.find('.js-umbrella-browse');

        this.init();
        this.bind();
    }

    init() {

        if (this.$inputEntity.val()) {
            this.$removeBtn.removeClass('d-none');
        } else {
            this.$removeBtn.addClass('d-none');
        }
    }

    bind() {
        this.$browseBtn.on('click', () => {
           this.$inputFile.click();
        });

        this.$inputFile.on('change', () => {
            this.refresh();
        });

        this.$removeBtn.on('click', () => {
           this.clear();
        });
    }

    clear() {
        this.$inputFile.replaceWith(this.$inputFile.val('').clone(true));
        this.$inputFile = this.$view.find('input[type="file"]');
        this.$inputDelete.prop('checked', true);
        this.$downloadBtn.addClass('d-none');
        this.refresh();
    }

    refresh() {
        let files = this.$inputFile[0].files;
        if (files.length > 0) {
            let file = files[0];
            this.$inputTxt.val(file.name + ' (' + Utils.bytes_to_size(file.size) + ')');
            this.$removeBtn.removeClass('d-none');
        } else {
            this.$inputTxt.val('');
            this.$removeBtn.addClass('d-none');
        }
    }

}