<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-119386393-1');
</script>

<!-- js -->
<script src="{{ asset('assets/vendors/scripts/core.js') }}"></script>
<script src="{{ asset('assets/vendors/scripts/script.js') }}"></script>
<script src="{{ asset('assets/vendors/scripts/process.js') }}"></script>
<script src="{{ asset('assets/vendors/scripts/layout-settings.js') }}"></script>
<script src="{{ asset('assets/datatables/datatables.min.js') }}"></script> 
<script src="{{ asset('assets/plugin/jquery-steps/jquery.steps.js') }}"></script>

<!-- Moment -->
<script src="{{ asset('assets/plugin/moment/moment.min.js') }}"></script>

<!-- jQuery Validation -->
<script src="{{ asset('assets/plugin/jquery-validation/jquery.validate.js') }}"></script>

<!-- Bootstrap growl -->
<script src="{{ asset('assets/plugin/bootstrap-growl-master/jquery.bootstrap-growl.min.js') }}"></script>

<!-- Sweetalert -->
<!-- <script src="{{ asset('assets/plugin/sweetalert2/sweetalert2.all.js') }}"></script> -->
<script src="{{ asset('assets/plugin/sweetalert2/sweetalert.js') }}"></script>

<script>
    $('.only-string').keypress(function(e) {
        var key = e.keyCode;
        if (key >= 48 && key <= 57) {
            e.preventDefault();
        }
    });

    $('.only-number').keypress(function (e){
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    });

    $('.only-lowercase').bind('keyup', function (e) {
        if (e.which >= 97 && e.which <= 122) {
            var newKey = e.which - 32;
            // I have tried setting those
            e.keyCode = newKey;
            e.charCode = newKey;
        }

        $('.only-lowercase').val(($('.only-lowercase').val()).toLowerCase());
    });

    function logout()
    {
        $('#form-logout').submit();
    }

</script>