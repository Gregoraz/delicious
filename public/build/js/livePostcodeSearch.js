$(document).ready(() => {
    $('#location').width($('#fasearch').width()); //Set width of first icon like the second one
    $("#result").width($('#postcode2').width()); //set proposed results width like the input search
    $('#result').show();

    loadData();

    $('#postcode').on('change paste keyup', (event) => {
        console.log('event: ', event);
        let postcodeVal = $('#postcode').val();

        if(postcodeVal != '')
        {
            loadData(postcodeVal);
        }
        else
        {
            loadData();
        }

        if(postcodeVal.length == 4 && postcodeVal.charAt(3) != ' ') {   //WHEN 4rd character is not space, then add space after 3rd character

            let helper = '';
            helper = postcodeVal.substr(0,3);
            helper += ' ';
            helper += postcodeVal.charAt(3);
            $('#postcode').val(helper);
            $('#postcode').keyup();
        }


    });
});

const loadData = (query) => {
    $.ajax({
        url:"/postcodesearch",
        method:"POST",
        data:{postcode:query},
        success:function(data)
        {
            $('#result').html(data);
        }
    });
}
