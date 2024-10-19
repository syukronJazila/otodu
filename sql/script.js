$(document).ready(function(){

    $('#keyword').on('keyup', function(){
    
        $('#loading').show();

        /* Ajax jquery menggunakan load
        $('#container').load('mahasiswa.php?keyword=' + $('#keyword').val());
        */

        $.get("mahasiswa.php?keyword=" + $('#keyword').val(), function (data) {
            $('#container').html(data);
            $('#loading').hide();
        });
    });
});