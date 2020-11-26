
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
        title: "¿Está seguro?",
        text: "Esta acción podría demorar unos minutos",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
        closeModal: false,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            swal.stopLoading(),
            window.location.href = '//localhost:8000/config/backup';
      }});
}
