$(document).ready(function () {

    $("#registerForm").validate({
        rules: {
            name : {
                required: true
            },    
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },

        messages: {
            name : {
                required: "Please enter your name."
            },
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email."
            },
            password: {
                required: "Please enter your password."
            },
            password_confirmation: {
                required: "Please confirm your password.",
                equalTo: "Passwords do not match."
            }
        },

        errorElement: "div",

        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            error.insertAfter(element);
        },

        highlight: function (element) {
            $(element).addClass("is-invalid");
        },

        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
        submitHandler: function (form) {

            $("#registerAlert").addClass("d-none").text("");

            $.ajax({
                url: REGISTER,
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",

                success: function (response) {
                    window.location.href = response.redirect;
                },

                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (field, messages) {
                            var input = $('[name="' + field + '"]');
                            input.addClass("is-invalid");

                            $('<div class="invalid-feedback d-block server-error"></div>')
                                .text(messages[0])
                                .insertAfter(input);
                        });
                    }
                }
            });
        }
    });

    
    $("#registerForm input").on("input", function () {
        $(this).removeClass("is-invalid");
        $(this).siblings(".server-error").remove();
    });

});
