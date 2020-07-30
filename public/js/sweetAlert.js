
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
