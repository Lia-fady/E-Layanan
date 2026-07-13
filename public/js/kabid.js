(function (window, $) {
  "use strict";

  function initEditPenempatanModal() {
    if (typeof $ === "undefined") return;
    $("#modalEditPenempatan").on("show.bs.modal", function (event) {
      var button = $(event.relatedTarget);
      var id = button.data("id") || "";
      var status = button.data("status") || "";
      var catatan = button.data("catatan") || "";
      $("#modal_id_penempatan").val(id);
      $("#modal_status_penempatan").val(status);
      $("#modal_catatan").val(catatan);
    });
  }

  $(document).ready(function () {
    initEditPenempatanModal();
    initPenilaianModal();
    initKomponenModal();
  });

  function initPenilaianModal() {
    if (typeof $ === "undefined") return;
    $(document).on("show.bs.modal", "#modalPenilaian", function (event) {
      var button = $(event.relatedTarget);
      var id_penilaian = button.data("id-penilaian") || "";
      var id_penempatan = button.data("id-penempatan") || "";
      var id_komponen = button.data("id-komponen") || "";
      var nilai = button.data("nilai") || "";
      var komponen = button.data("komponen") || "";

      $("#modal_penempatan_id").val(id_penempatan);
      $("#modal_komponen_id").val(id_komponen);
      $("#modal_komponen_name").val(komponen);
      $("#modal_nilai").val(nilai);
    });
  }

  function initKomponenModal() {
    if (typeof $ === "undefined") return;
    $(document).on("show.bs.modal", "#modalKomponen", function (event) {
      var button = $(event.relatedTarget);
      $("#modal_komponen_id").val(button.data("id") || "");
      $("#modal_komponen_nama").val(button.data("nama") || "");
      $("#modal_komponen_status").val(button.data("status") || "1");
    });
  }
})(window, window.jQuery);
