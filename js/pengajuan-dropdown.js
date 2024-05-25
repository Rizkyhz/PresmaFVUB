function updateBidangMinat() {
  var bidangMinatDropdown = document.getElementById("inputBidangMinat");
  var jenisKejuaraanDropdown = document.getElementById("inputJenisKejuaraan");

  // Clear existing options
  jenisKejuaraanDropdown.innerHTML = "";

  var selectedBidangMinat = bidangMinatDropdown.value;

  var optionValues = {
    Sains: 1,
    "Riset dan Inovasi": 2,
    Teknologi: 3,
    Olahraga: 4,
    "Bahasa dan Literasi": 5,
    Seni: 6,
    MTQ: 7,
    "Inovasi Wirausaha Digital": 8,
    "Inovasi Wirausaha Non-Digital": 9,
  };

  var options = [];

  if (selectedBidangMinat === "PenalarandanKreatifitas") {
    options = ["Sains", "Riset dan Inovasi", "Teknologi"];
  } else if (selectedBidangMinat === "SeniMinatdanPrestasi") {
    options = ["Olahraga", "Bahasa dan Literasi", "Seni", "MTQ"];
  } else if (selectedBidangMinat === "Kewirausahaan") {
    options = ["Inovasi Wirausaha Digital", "Inovasi Wirausaha Non-Digital"];
  }

  // Add options to the second dropdown
  for (var i = 0; i < options.length; i++) {
    var option = document.createElement("option");
    option.value = optionValues[options[i]]; // Use the corresponding value from optionValues
    option.text = options[i];
    jenisKejuaraanDropdown.add(option);
  }
}

$(document).ready(function () {
  $("input[type=radio][name=delegasiOrmawa]").change(function () {
    if (this.value == "1") {
      $("#namaOrmawa").show();
    } else if (this.value == "0") {
      $("#namaOrmawa").hide();
    }
  });
});
