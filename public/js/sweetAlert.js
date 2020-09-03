
function warning(key, redirect) {
    swal({
        title: "¿Está seguro?",
        text: "Una vez borrado, no podrá recuperarlo",
        icon: "warning",
        buttons: ["Cancelar", true],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//127.0.0.1:8000/'+ redirect + '/destroy/' + key;
      }});
}

function warningContact(key, redirect) {
    swal({
        title: "¿Está seguro?",
        text: "Una vez borrado, no podrá recuperarlo",
        icon: "warning",
        buttons: ["Cancelar", true],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//127.0.0.1:8000/'+ redirect + '/delete_contact/' + key;
      }});
}

function warningSendEmails(key) {
    swal({
        title: "¿Está seguro?",
        text: "El Romaneo procedera a enviarse",
        icon: "warning",
        buttons: ["Cancelar", true],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//127.0.0.1:8000/aviso/send_email/' + key;
      }});
}
