$(document).ready(function () {
  $("#tabla_listado").DataTable({
    responsive: true,
    pageLength: 3,
    order: [[0, "desc"]],
    columnDefs: [{ width: "65%", targets: 1 }],
    language: {
      url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
    },
  });

  $(".btn_ver_revision").click(function (e) {
    e.preventDefault();

    let cod_rev = $(this).attr("cod_rev");
    let cod_maquina = $(this).attr("cod_maqui");

    location.href = "ver_revision.php?rev=" + cod_rev + "&maq=" + cod_maquina;
  });

  $(".btn_ver_incidencia").click(function (e) {
    e.preventDefault();

    let cod_maquina = $(this).attr("cod_maqui");
    let cod_inci = $(this).attr("cod_inc");

    console.log(cod_inci + "don " + cod_maquina);

    location.href =
      "ver_incidencia.php?maq=" + cod_maquina + "&inc=" + cod_inci;
  });

  $("#tabla_listado_inc").DataTable({
    pageLength: 3,
    order: [[0, "desc"]],
    language: {
      url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
    },
  });

  $(".btn_ver_revision").click(function (e) {
    e.preventDefault();

    let cod_rev = $(this).attr("cod_rev");
    let cod_maquina = $(this).attr("cod_maqui");

    location.href = "ver_revision.php?rev=" + cod_rev + "&maq=" + cod_maquina;
  });
});
