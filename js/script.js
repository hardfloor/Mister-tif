$("#contact-form").submit(function (e) {
  e.preventDefault();

  $("#sendalert").text("Envoi en cours...");
  var postdata = $("#contact-form").serialize();

  $.ajax({
    type: "POST",
    url: "php/contact.php",
    data: postdata,
    success: function (result) {
      if (result === "success") {
        $("#sendalert").text("Votre message a bien été envoyé");

        $("#firstname + .alert").html("");
        $("#email + .alert").html("");
        $("#subject + .alert").html("");
        $("#message + .alert").html("");

        $("#contact-form")[0].reset();
      } else if (result === "error") {
        $("#sendalert").text("Une erreur est survenue");
      } else {
        $("#sendalert").text("");
        const errors = JSON.parse(result);

        if (errors.firstnameError) {
          $("#firstname + .alert").html(errors.firstnameError);
        }

        if (errors.emailError) {
          $("#email + .alert").html(errors.emailError);
        }

        if (errors.subjectError) {
          $("#subject + .alert").html(errors.subjectError);
        }

        if (errors.messageError) {
          $("#message + .alert").html(errors.messageError);
        }
      }
    },
  });
});
