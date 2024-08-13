var path = window.location.pathname;
if (path == "/webappcms/distributor") {
    document.addEventListener("DOMContentLoaded", () => {
        jQuery("#datatable-distributor")
            .DataTable({
                responsive: false,
                columns: [
                    { width: "10%" },
                    { width: "20%" },
                    { width: "30%" },
                    { width: "10%" },
                    { width: "5%" },
                ],
            })
            .buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
        document.querySelectorAll(".table .delete-row").forEach((button) => {
            button.addEventListener("click", (e) => {
                const button = e.target.closest(".delete-row");
                const row = e.target.closest("tr");
                const id = button.dataset.id;

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    showConfirmButton: true,
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger m-l-10",
                    },
                    confirmButtonText: "Yes, delete it!",
                }).then((value) => {
                    if (value.isConfirmed) {
                        jQuery.ajax({
                            url: "/webappcms/distributor/destroy/" + id,
                            type: "DELETE",
                            data: {
                                _token: jQuery('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function (data) {
                                if (data.message) {
                                    row.remove();
                                    Swal.fire(
                                        "Deleted!",
                                        "Your data has been deleted.",
                                        "success"
                                    );
                                } else if (data.error) {
                                    Swal.fire(
                                        "Error!",
                                        "There was a problem deleting your data.",
                                        "error"
                                    );
                                }
                            },
                            error: function () {
                                Swal.fire(
                                    "Error!",
                                    "There was a problem with the server.",
                                    "error"
                                );
                            },
                        });
                    }
                });
            });
        });
    });
} else {
    document.addEventListener("DOMContentLoaded", () => {
        const countrySelect = $("#country");
        const provinceSelect = $("#province");
        const citySelect = $("#city");
        const districtSelect = $("#district");
        const subdistrictSelect = $("#subdistrict");
        var provinceFetched, cityFetched, districtFetched, subdistrictFetched;
        const fetchProvince = async (country, trick) => {
            try {
                const response = await axios.get("/fetch/province/" + country);
                provinceFetched = response.data;
                provinceSelect
                    .empty()
                    .prop("disabled", false)
                    .append('<option value="" disabled>Please Select</option>');
                provinceFetched.forEach((element) => {
                    provinceSelect.append(
                        `<option value="${element.value}">${element.label}</option>`
                    );
                });
                citySelect.empty();
                districtSelect.empty();
                subdistrictSelect.empty();
                if (trick) {
                    const provinceValue = $("#province-update").val();
                    provinceSelect.val(provinceValue);
                    const cityValue = $("#city-update").val();
                    const districtValue = $("#district-update").val();

                    fetchCity(provinceValue);
                    fetchDistrict(cityValue);
                    fetchSubdistrict(districtValue, trick);
                }
            } catch (error) {
                console.error("Error when fetching data", error);
            }
        };
        const fetchCity = async (province) => {
            try {
                const response = await axios.get("/fetch/city/" + province);
                cityFetched = response.data;
                citySelect
                    .empty()
                    .prop("disabled", false)
                    .append('<option value="" disabled>Please Select</option>');
                cityFetched.forEach((element) => {
                    citySelect.append(
                        `<option value="${element.value}">${element.label}</option>`
                    );
                });
                districtSelect.empty();
                subdistrictSelect.empty();
            } catch (error) {
                console.error("Error when fetching data");
            }
        };
        const fetchDistrict = async (city) => {
            try {
                const response = await axios.get("/fetch/district/" + city);
                districtFetched = response.data;
                districtSelect
                    .empty()
                    .prop("disabled", false)
                    .append('<option value="" disabled>Please Select</option>');
                districtFetched.forEach((element) => {
                    districtSelect.append(
                        `<option value="${element.value}">${element.label}</option>`
                    );
                });
                subdistrictSelect.empty();
            } catch (error) {
                console.error("Error when fetching data");
            }
        };
        const fetchSubdistrict = async (district, trick) => {
            try {
                const response = await axios.get(
                    "/fetch/subdistrict/" + district
                );
                subdistrictFetched = response.data;
                subdistrictSelect
                    .empty()
                    .prop("disabled", false)
                    .append('<option value="" disabled>Please Select</option>');
                subdistrictFetched.forEach((element) => {
                    subdistrictSelect.append(
                        `<option value="${element.value}">${element.label}</option>`
                    );
                });
                if (trick) {
                    const subdistrictValue = $("#subdistrict-update").val();
                    subdistrictSelect.val(subdistrictValue);
                }
            } catch (error) {
                console.error("Error when fetching data");
            }
        };
        countrySelect.on("change", () => {
            if (countrySelect.val() == "100") {
                fetchProvince(countrySelect.val());
            } else {
                // Reset all selects if country is not 100
                provinceSelect.prop("disabled", true).empty();
                citySelect.prop("disabled", true).empty();
                districtSelect.prop("disabled", true).empty();
                subdistrictSelect.prop("disabled", true).empty();
            }
        });

        provinceSelect.on("change", () => {
            fetchCity(provinceSelect.val());
        });
        citySelect.on("change", () => {
            fetchDistrict(citySelect.val());
        });
        districtSelect.on("change", () => {
            fetchSubdistrict(districtSelect.val());
        });

        // Call the function

        // Trigger changes on the update page
        const pathname = window.location.pathname;
        const basePath = pathname.substring(0, pathname.lastIndexOf("/"));

        if (basePath === "/webappcms/distributor/update") {
            const trickUpdate = basePath === "/webappcms/distributor/update";

            if (countrySelect.val() === "100") {
                fetchProvince(countrySelect.val(), trickUpdate);
            } else {
                provinceSelect.prop("disabled", true).empty();
                citySelect.prop("disabled", true).empty();
                districtSelect.prop("disabled", true).empty();
                subdistrictSelect.prop("disabled", true).empty();
            }
        }

        document.getElementById("back").addEventListener("click", () => {
            window.location.href = "/webappcms/distributor";
        });
    });
    jQuery("#create-distributor").validate({
        ignore: [],
        errorClass: "invalid-feedback animated fadeInDown",
        errorElement: "div",
        errorPlacement: function (e, a) {
            jQuery(a).parents(".form-group > div").append(e);
        },
        highlight: function (e) {
            jQuery(e)
                .closest(".form-group")
                .removeClass("is-invalid")
                .addClass("is-invalid");
            if ($(e).hasClass("select2-hidden-accessible")) {
                $(e).next().find(".select2-selection").addClass("is-invalid");
            }
        },
        unhighlight: function (e) {
            jQuery(e).closest(".form-group").removeClass("is-invalid");
            if ($(e).hasClass("select2-hidden-accessible")) {
                $(e)
                    .next()
                    .find(".select2-selection")
                    .removeClass("is-invalid");
            }
        },
        success: function (e) {
            jQuery(e).closest(".form-group").removeClass("is-invalid"),
                jQuery(e).remove();
        },
        rules: {
            distributor_name: {
                required: true,
            },
            phone: {
                required: true,
            },
            country: {
                required: true,
            },
            address: {
                required: true,
            },
            latitude: {
                required: true,
            },
            longitude: {
                required: true,
            },
        },
        messages: {
            distributor_name: {
                required: "Please enter distributor name",
            },
            phone: {
                required: "Please enter phone number",
            },
            country: {
                required: "Please select country",
            },
            address: {
                required: "Please enter address",
            },
            latitude: {
                required: "Please enter latitude",
            },
            longitude: {
                required: "Please enter longitude",
            },
        },
        submitHandler: function () {
            event.preventDefault();
            const form = document.getElementById("create-distributor");
            let formData = new FormData(form);
            jQuery.ajax({
                url:
                    path == "/webappcms/distributor/create"
                        ? "/webappcms/distributor/store"
                        : "/webappcms/distributor/update",
                type: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": jQuery('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                processData: false,
                contentType: false,
                success: (data) => {
                    if (data.message) {
                        Swal.fire({
                            title: "Save Successfully.",
                            text:
                                path == "/webappcms/distributor/create"
                                    ? "Continue to input another distributor?"
                                    : "Continue to edit?",
                            icon: "success",

                            showCancelButton: true,
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger m-l-10",
                            },
                            confirmButtonText: "Yes Continue",
                            cancelButtonText: "No",
                        }).then((value) => {
                            // if (value.isDenied) {
                            //     window.location.href = "/social-media"; // Ganti dengan URL tujuan Anda
                            // }
                            if (value.isConfirmed) {
                                window.location.reload(); // Ganti dengan URL tujuan Anda
                            }
                            if (value.isDismissed) {
                                window.location.href = "/webappcms/distributor"; // Ganti dengan URL tujuan Anda
                            }
                        });
                    } else if (data.error) {
                        alert(data.error);
                    }
                },
                error: (data) => {
                    alert(data);
                },
            });
        },
    });
}
