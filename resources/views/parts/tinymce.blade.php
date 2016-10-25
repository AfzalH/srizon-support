<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
{{--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>--}}
<script src="{{asset('js/tinymce-placeholder.js')}}"></script>
<script>
    $(document).ready(function () {
        init_tinymce();

        $('.popup-with-form').click(function () {
            tinymce.remove();
            init_tinymce();
        });

    });


    function init_tinymce(){
        tinymce.init({
            selector: '.txt-editor',
            menubar: false,
            statusbar: false,
            plugins: 'placeholder autoresize image link code',
            autoresize_bottom_margin: 0,
            browser_spellcheck: true,
            toolbar: 'styleselect | bold italic | bullist numlist | link image | code'
        });
    }

    function init_tinymce_without_popup(){
        tinymce.init({
            selector: '.txt-editor',
            menubar: false,
            statusbar: false,
            plugins: 'placeholder autoresize image link code',
            autoresize_bottom_margin: 0,
            browser_spellcheck: true,
            toolbar: 'styleselect | bold italic | bullist numlist'
        });
    }
</script>