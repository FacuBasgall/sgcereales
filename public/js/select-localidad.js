$(document).ready(function() {
    $('#provincia').on('change', function() {
        var provincia_id = $(this).val();
        if ($.trim(provincia_id) != '') {
            $.get('getLocalidades', {
                provincia_id: provincia_id
            }, function(localidades) {
                $('#localidad').empty();
                $('#localidad').append("<option value=''>Seleccione</option>");
                $.each(localidades, function(id, nombre) {
                    $('#localidad').append("<option value='" + id + "'>" + nombre + "</option>");
                });
            });
        }
    });
});
