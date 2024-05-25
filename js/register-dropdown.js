document
  .getElementById("inputDepartemen")
  .addEventListener("change", function () {
    var departemenId = this.value;
    var prodiDropdown = document.getElementById("id_prodi_mahasiswa");
    prodiDropdown.innerHTML = "";

    $.ajax({
      url: "../mahasiswa/controller/get_prodi.php",
      method: "POST",
      data: {
        id_departemen: departemenId,
      },
      dataType: "json",
      success: function (response) {
        response.forEach(function (prodi) {
          var option = document.createElement("option");
          option.value = prodi.id_prodi;
          option.text = prodi.nama_prodi;
          prodiDropdown.appendChild(option);
        });
      },
      error: function () {
        console.error("Error while fetching program studi data.");
      },
    });
  });
