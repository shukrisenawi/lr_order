import tinymce from 'tinymce/tinymce';

// TinyMCE core
import 'tinymce/themes/silver/theme';

// Core Plugins
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/code';
import 'tinymce/plugins/table';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/codesample';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/media';
import 'tinymce/plugins/preview';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/charmap';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/autosave';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/help';

// Icons
import 'tinymce/icons/default/icons';

window.initTinyMCE = function(selector, height = 400) {
    tinymce.init({
        selector: selector,
        height: height,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
            'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
            'table', 'help', 'wordcount', 'codesample', 'emoticons',
            'directionality',
            'autosave'
        ],
        toolbar1: 'undo redo | formatselect | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
        toolbar2: 'link image media table | codesample | emoticons charmap | anchor | insertdatetime',
        toolbar3: 'visualblocks visualchars | searchreplace | fullscreen preview | code help | save',
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
        // Enhanced image handling
        image_caption: true,
        image_advtab: true,
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_url: '/admin/upload-image',
        images_upload_credentials: true,

        // Code sample configuration for syntax highlighting
        codesample_languages: [
            {text: 'HTML/XML', value: 'markup'},
            {text: 'JavaScript', value: 'javascript'},
            {text: 'CSS', value: 'css'},
            {text: 'PHP', value: 'php'},
            {text: 'Blade', value: 'blade'},
            {text: 'JSON', value: 'json'},
            {text: 'SQL', value: 'sql'},
            {text: 'Bash', value: 'bash'},
            {text: 'Python', value: 'python'},
            {text: 'Java', value: 'java'},
            {text: 'C#', value: 'csharp'},
            {text: 'C++', value: 'cpp'}
        ],

        // Enhanced toolbar and features
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        quickbars_insert_toolbar: 'quickimage quicktable codesample',
        quickbars_image_toolbar: 'alignleft aligncenter alignright | rotateleft rotateright | imageoptions',
        noneditable_noneditable_class: 'mceNonEditable',
        toolbar_drawer: 'sliding',

        // Advanced paste options
        paste_data_images: true,
        paste_as_text: false,
        paste_webkit_styles: 'all',
        paste_retain_style_properties: 'all',


        // Enhanced content styling
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css'
        ],

        // Code sample styling
        codesample_content_css: '//cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism.min.css',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; line-height:1.6; } .mce-content-body[data-mce-placeholder]:not(.mce-visualblocks)::before { color: #888; }',

        // Advanced features
        contextmenu: 'link image table configurepermanentpen',
        elementpath: true,
        resize: true,
        statusbar: true,

        // Autosave
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: 'tinymce-autosave-{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',

        // Enhanced file picker for images
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
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
};