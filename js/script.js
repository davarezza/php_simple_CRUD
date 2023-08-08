$(document).ready(function() {
    
    // event ketika keyword ditulis
    $('#keyword').keyup(function() {
        $('#container').load('ajax/siswa.php?keyword=' + $('#keyword').val())
    });

});