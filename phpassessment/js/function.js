
function toggle(source) {
  checkboxes = document.getElementsByName('approve[]');
  for(var i in checkboxes)
    checkboxes[i].checked = source.checked; 
}

function myFunction(lat, lng) {            
    //var address= "null"; 
    var latlng = new google.maps.LatLng(lat, lng);
    // This is making the Geocode request
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status !== google.maps.GeocoderStatus.OK) {
            alert(status);
        }
        // This is checking to see if the Geocode Status is OK before proceeding
        if (status == google.maps.GeocoderStatus.OK) {
            //console.log(results);
            var address = (results[0].formatted_address);    
            //alert(address);
            document.getElementById('add').value=address;         
            //return address.value;            
        }
    });       
    //return address;                // Function returns the product of a and b       
}

/*
function getReverseGeocodingData(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    // This is making the Geocode request
    var geocoder = new google.maps.Geocoder();
     
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status !== google.maps.GeocoderStatus.OK) {
            alert(status);
        }
        // This is checking to see if the Geocode Status is OK before proceeding
        if (status == google.maps.GeocoderStatus.OK) {
            //console.log(results);
            var address = (results[0].formatted_address);
            //alert(address);
            return address.value;
        }
    });        
}

*/