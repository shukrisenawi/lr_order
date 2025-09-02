import tinymce from 'tinymce/tinymce';

// TinyMCE core
import 'tinymce/themes/silver/theme';

// Core Plugins
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/code';
import 'tinymce/plugins/table';
import 'tinymce/plugins/lists';

// Icons
import 'tinymce/icons/default/icons';

window.initTinyMCE = function(selector, height = 400) {
    tinymce.init({
        selector: selector,
        height: height,
        menubar: true,
        plugins: [
            'link', 'image', 'code', 'table', 'lists'
        ],
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image table | code',
        toolbar_mode: 'sliding',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ],
        image_advtab: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        quickbars_insert_toolbar: 'quickimage quicktable',
        quickbars_image_toolbar: 'alignleft aligncenter alignright | rotateleft rotateright | imageoptions',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_drawer: 'sliding',
        spellchecker_dialog: true,
        spellchecker_whitelist: ['Ephox', 'Moxiecode'],
        tinycomments_mode: 'embedded',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
};