<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/js/detect.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/js/vertical-menu.js') }}"></script>
<!-- Select2 js -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<!-- Tagsinput js -->
<script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-tagsinput/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-form-select.js') }}"></script>
<!-- Parsley js -->
<script src="{{ asset('assets/plugins/validatejs/validate.min.js') }}"></script>
<!-- Sweet-Alert js -->
<!-- <script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.all.min.js"></script>
<!-- <script src="{{ asset('assets/js/custom/custom-sweet-alert.js') }}"></script> -->
<!-- Core js -->
<script src="{{ asset('assets/js/core.js') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('logout').addEventListener('click', () => {
            $.ajax({
                url: '/webappcms/logout',
                type: 'POST',
                data: {
                    _token: jQuery('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: () => {
                    console.log('Logged out')
                    window.location.href = '/webappcms/login'
                },
                error: () => {
                    alert('Something went wrong')
                }
            });
        })
    })
</script>
