
function warning(key, redirect) {
    swal({
        title: "¿Está seguro?",
        text: "Una vez borrado, no podrá recuperarlo",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//localhost:8000/'+ redirect + '/destroy/' + key;
      }});
}

function warningContact(key, redirect) {
    swal({
        title: "¿Está seguro?",
        text: "Una vez borrado, no podrá recuperarlo",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//localhost:8000/'+ redirect + '/delete_contact/' + key;
      }});
}

function warningSendEmails(key) {
    swal({
        title: "¿Está seguro?",
        text: "Esta acción podría demorar unos minutos",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//localhost:8000/aviso/send_email/' + key;
      }});
}

function warningSendEmailsReporte() {
    swal({
        title: "¿Está seguro?",
        text: "Esta acción podría demorar unos minutos",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//localhost:8000/reporte/send_email';
      }});
}

function warningDomicile(key, redirect) {
    swal({
        title: "¿Está seguro?",
        text: "Una vez borrado, no podrá recuperarlo",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//localhost:8000/'+ redirect + '/delete_domicile/' + key;
      }});
}

function warningBackup() {
    swal({
        title: "¿Está seguro? Ésta acción podría demorar unos minutos",
        text: "No utilice el sistema hasta que se complete el proceso.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        closeModal: false,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            swal.stopLoading(),
            window.location.href = '//localhost:8000/admin/backup';
      }});
}

function acercaDe(){
    swal({
        html: true,
        title: "Acerca del sistema",
        text: "Proyecto desarrollado con fines académicos correspondiente a la carrera Analisis de Sistemas para aprobar la cátedra Taller de Integración de la Facultad de Ciencia y Tecnología - UADER. \n Autores: Basgall Facundo Tomás, Cascone María Belén, Ernst Gotte Bernardita.",
        icon: "info",
      });

}
