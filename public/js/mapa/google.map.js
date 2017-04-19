/**
 *
 * @type {null}
 */
var google_api = {
    current: {
        position: null,
        address: {
            response: null,
            formatted_address: ""
        }
    }
};

/**
 *
 * @param pos
 */
function showPosition(pos) {
    google_api.current.position = pos;
    //console.debug("Latitude: " + pos.coords.latitude + "Longitude:" + position.coords.longitude);
}

/**
 *
 * @param xhr
 */
function setAddres(xhr) {
    ajaxSetUp.enableToken();
    if ("OK" === xhr.status) {
        google_api.current.address.response = xhr.results;
        google_api.current.address.formatted_address = google_api.current.address.response[2].formatted_address;
        console.debug(google_api.current.address.formatted_address);
    } else {
        console.info("No fue posible geocodificar inversamente");
    }
}

/**
 *
 * @param pos
 */
function inverserGeocoding(pos) {
    google_api.position = pos;
    var key = $("#google_api").data("key")
    ajaxSetUp.disableToken();
    $.post("https://maps.googleapis.com/maps/api/geocode/json?latlng="
        + pos.coords.latitude + ","
        + pos.coords.longitude + "&"
        + key, setAddres);
}
/**
 *
 */
function initMap() {

    $(function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(inverserGeocoding);
        } else {
            console.info("Geolocation is not supported by this browser.");
        }
    });
}

