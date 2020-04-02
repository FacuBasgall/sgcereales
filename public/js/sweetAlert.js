
function warning(key, redirect) {
    swal({
        title: "¿Está seguro?",
        text: "Una vez borrado, no podrá recuperarlo",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
            window.location.href = '//127.0.0.1:8000/'+ redirect + '/destroy/' + key;
      }});
}

function failEdit(key, redirect, estado) {
  if(estado == 1){
  swal({
    title: "No se puede editar",
    text: "Este aviso está Terminado",
    icon: "error",
  })}else{
      window.location.href = '//127.0.0.1:8000/' + redirect + '/edit/' + key;
  };
}