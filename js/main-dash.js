(function ($) {
  "use strict";

  var fullHeight = function () {
    $(".js-fullheight").css("height", $(window).height());
    $(window).resize(function () {
      $(".js-fullheight").css("height", $(window).height());
    });
  };
  fullHeight();

  $("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");
  });
})(jQuery);

// form pengajuan
// Add an event listener to the radio buttons to show/hide the input field
const yesDelegasiRadio = document.getElementById("yesDelegasi");
const namaOrmawaField = document.getElementById("namaOrmawaField");

yesDelegasiRadio.addEventListener("change", function () {
  if (yesDelegasiRadio.checked) {
    namaOrmawaField.style.display = "block";
  } else {
    namaOrmawaField.style.display = "none";
  }
});

// Function to clear the form fields
function clearForm() {
  // Replace 'yourFormId' with the actual ID of your form
  var form = document.getElementById("yourFormId");
  if (form) {
    var elements = form.elements;

    for (var i = 0; i < elements.length; i++) {
      if (elements[i].type !== "button" && elements[i].type !== "submit") {
        elements[i].value = "";
      }
    }
  }
}

// Anggota
function showMembersInput() {
  var jenisKepesertaan = document.getElementById("inputJenisKepesertaan").value;
  var inputJumlahAnggota = document.getElementById("inputJumlahAnggota");

  if (jenisKepesertaan === "kelompok") {
    inputJumlahAnggota.style.display = "block";
  } else {
    inputJumlahAnggota.style.display = "none";
  }
}
// form pengajuan

// Upload IMG
// Get file input and form elements
const fileInput = document.getElementById("fileInput");
const uploadForm = document.getElementById("uploadForm");

// Add event listener to file input
fileInput.addEventListener("change", function () {
  // Handle file upload here
  const file = fileInput.files[0];
  // You can use AJAX or other methods to upload the file to your server
  // Example: You can use the Fetch API to send the file to your server
  // fetch("your_upload_endpoint", {
  //   method: "POST",
  //   body: file,
  // })
  // .then(response => response.json())
  // .then(data => {
  //   // Handle the response from the server
  // })
  console.log("File selected:", file.name);
});
