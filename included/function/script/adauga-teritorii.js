var preventSign = 0;

function readTable(){
   if(preventSign == 0){
        preventSign = 1
        $('#loading-id').removeClass('dis-none')

        $.ajax({
            type: "POST",
            url: "../../../included/function/exe/adauga-teritorii.php",
            data: {'check-table':'true'},
            success: function (result) {
                insertInTable(result)
                preventSign = 0
                setTimeout(function() {
                    $('#loading-id').addClass('dis-none');
                }, 1000);
            }
        })
    }
}

function insertInTable(result){
    try{
        var citireArray = JSON.parse(result);
        var newArray = '';
        for (let index = 0; index < citireArray.length; index++) {
            if(index % 2 === 0){
                var clasaPara = ''
            }
            else{
                var clasaPara = 'marcheaza'
            }
            newArray += '<div class="rand-tabel ' + clasaPara + '">' +
                '<div class="valori">' + citireArray[index]['nume'] + '</div>' +
                '<div class="valori">' + citireArray[index]['link'] + '</div>' +
                '<div class="valori">' + citireArray[index]['detalii'] + '</div>' +
                '<div class="valori">' + citireArray[index]['status'] + '</div>'
                + '</div>';
        }
        $('#date-tabel').html(newArray)
        document.getElementById('teritorii').reset();
    }
    catch{
        if(result == '<div class="centrare-mesaj">Tabel gol</div>'){
            $('#date-tabel').html(result)
        }
        else{
            if(result.length > 1){
                alert(result)
            }
            else{
                $('#date-tabel').html('<div class="centrare-mesaj">Tabel gol</div>')
            }
        }
    }
}

$(document).ready(function () {
    readTable()
    $('#teritorii').submit(function (event) {
        event.preventDefault();
        if(preventSign == 0){
            preventSign = 1
            $('#loading-id').removeClass('dis-none')
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "../../../included/function/exe/adauga-teritorii.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    insertInTable(result)
                    preventSign = 0
                    setTimeout(function() {
                        $('#loading-id').addClass('dis-none');
                    }, 1000);
                }
            })
        }
    })
})