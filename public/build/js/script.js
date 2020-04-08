const zoomFontIn = () => {                                                                 //Incrases font size
    document.getElementById("fontManip").style.fontSize = "larger";
    localStorage.setItem("font-size", "larger"); //save item to local storage
}

const zoomFontOut = () => {
    document.getElementById("fontManip").style.fontSize = "initial";                          //Brings font size to default
    localStorage.setItem("font-size", "initial"); //save item to local storage
};

const loadLocalStorage = () => {
    if (localStorage.getItem("font-size") != null) {
        var helpVar = localStorage.getItem("font-size");
        document.getElementById("fontManip").style.fontSize = helpVar;
    }
};


const locate = () => {                     //Locate
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            $.get("https://maps.googleapis.com/maps/api/geocode/json?latlng=" + position.coords.latitude + "," + position.coords.longitude + "&key=AIzaSyCFbZvWZVc9E7lmw4l6DnG-b7W1gwJmCxs&sensor=false", function (data) {

                const currentPostcode = data.results[0].address_components[data.results[0].address_components.length - 1].long_name; //get postcode of the closest records to position (get the last index of //                                                                                                         //    matrixpostcode)
                $('#postcode').val(currentPostcode);
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lng').value = position.coords.longitude;
                $('#postcode').keyup();
            })

        });
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
};

const writePostcode = idContent => {
    var actualPostcode = document.getElementById("toWrite" + idContent);
    document.forms['search']['postcode'].value = actualPostcode.textContent;
    document.forms['search']['lat'].value = actualPostcode.getAttribute('data-lat');
    document.forms['search']['lng'].value = actualPostcode.getAttribute('data-lng');

    $('#postcode').keyup();
};
    

    
    
