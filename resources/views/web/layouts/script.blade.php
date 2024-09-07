<!-- Vendor JS Files -->
<script src="{{ asset('assets/web/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/web/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/web/vendor/magnific/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/web/vendor/owl-carousel/owl.carousel.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/web/vendor/slick/slick.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/web/js/main.js') }}?v=<?php echo rand(); ?>"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        // Function to initialize dropdown and set up click handlers
        // const initializeAllRemove = () => {
        //     document.querySelectorAll('.dropdown-toggle').forEach((dropdown) => {
        //         dropdown.classList.remove('show')
        //     })
        //     document.querySelectorAll('.dropdown-menu').forEach((dropdown) => {
        //         dropdown.classList.remove('show')
        //     })
        // }

        function checkAnotherDropdown(excepted, exceptedTwo) {
            document.querySelectorAll('.dropdown-toggle.show').forEach((dropdown) => {
                if (dropdown != excepted) dropdown.classList.remove('show')
            })
            document.querySelectorAll('.dropdown-menu.show').forEach((dropdown) => {
                if (dropdown != exceptedTwo) dropdown.classList.remove('show')
            })
        }


        function initializeDropdown(headerId, footerId) {
            const headerElement = document.getElementById(headerId);
            const footerElement = document.getElementById(footerId);

            if (headerElement) {
                const excepted = headerElement.querySelector('.nav-link')
                const exceptedTwo = headerElement.querySelector('.dropdown-menu')
                const dropdown = new bootstrap.Dropdown(headerElement.querySelector('.nav-link'));
                headerElement.querySelector('.nav-link').addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropdown.toggle();
                    checkAnotherDropdown(excepted, exceptedTwo) //except this dropdown
                    // if (excepted.classList.contains('show')) {
                    //     document.addEventListener('click', initializeAllRemove)
                    // } else {
                    //     document.removeEventListener('click', initializeAllRemove)
                    // }
                });
            }

            if (footerElement) {
                const excepted = headerElement.querySelector('.nav-link')
                const exceptedTwo = headerElement.querySelector('.dropdown-menu')
                footerElement.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // prevents
                    if (headerElement) {
                        const dropdown = new bootstrap.Dropdown(headerElement.querySelector('.nav-link'));
                        dropdown.toggle();
                        checkAnotherDropdown(excepted, exceptedTwo) //except this dropdown
                        // if (excepted.classList.contains('show')) {
                        //     document.addEventListener('click', initializeAllRemove)
                        // } else {
                        //     document.removeEventListener('click', initializeAllRemove)
                        // }
                    }
                });
            }
        }

        // Initialize dropdowns for each section
        initializeDropdown('companyHeader', 'companyFooter');
        initializeDropdown('produkHeader', 'produkFooter');
        initializeDropdown('newsHeader', 'newsFooter');
        // initializeDropdown('languageHeader', 'languageFooter');
    });
</script>