$('#select-brand').on('change', function(){
    var item = $(this).val();
    $.ajax({
        url: '/admin/car/get-models',
        data: {brand: item},
        type: 'GET',
        success: function(res){
            $('#select-model')
                .find('option')
                .remove()
                .end();
            $.each(res, function(key, value) {
                $('#select-model')
                    .append($("<option></option>")
                        .attr("value",value.id)
                        .text(value.title));
            });
        },
        error: function(){
            console.log('Ошибка получения данных');
        }
    });
});