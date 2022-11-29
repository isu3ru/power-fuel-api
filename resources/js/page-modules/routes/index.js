let previewMap;
let geocoderMap;
let geocoderMarker;
let selectionTarget = 'start_location';
let selectionDetails = start = end = {
    name: '',
    lat: '',
    lng: ''
};
let waypoints = [];
let routeName = '';
let directionsService;
let directionsDisplay;

$('#route_name').on('keyup', function() {
    routeName = $(this).val();
    localStorage.setItem('route_name', routeName);
});

function initLocalStorage() {
    if (localStorage.getItem('route_name') === null) {
        localStorage.setItem('route_name', routeName);
    } else {
        routeName = localStorage.getItem('route_name');
        $('#route_name').val(routeName);
    }

    if (localStorage.getItem('start_location') === null) {
        localStorage.setItem('start_location', JSON.stringify(start));
    } else {
        start = JSON.parse(localStorage.getItem('start_location'));
        $('#start_location').val(start.name);
        $('#start_latitude').val(start.lat);
        $('#start_longitude').val(start.lng);
    }

    if (localStorage.getItem('end_location') === null) {
        localStorage.setItem('end_location', JSON.stringify(end));
    } else {
        end = JSON.parse(localStorage.getItem('end_location'));
        $('#end_location').val(end.name);
        $('#end_latitude').val(end.lat);
        $('#end_longitude').val(end.lng);
    }

    if (localStorage.getItem('waypoints') === null) {
        localStorage.setItem('waypoints', JSON.stringify(waypoints));
    } else {
        waypoints = JSON.parse(localStorage.getItem('waypoints'));
        renderWaypointsList();
    }
}

function resetLocalStorage() {
    localStorage.removeItem('route_name');
    localStorage.removeItem('start_location');
    localStorage.removeItem('end_location');
    localStorage.removeItem('waypoints');
}

function resetUI() {
    // clear vars
    selectionTarget = 'start_location';
    selectionDetails = start = end = {
        name: '',
        lat: '',
        lng: ''
    };
    waypoints = [];
    routeName = '';

    // clear field values
    $('#route_name').val('');
    $('#start_location').val('');
    $('#start_latitude').val('');
    $('#start_longitude').val('');
    $('#end_location').val('');
    $('#end_latitude').val('');
    $('#end_longitude').val('');

    // remove existing items from local storage
    resetLocalStorage();
    // load routes table
    getRoutesForLocalAuthority();

    initMap();

    renderWaypointsList();
}

function initMap() {
    // init services
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;

    // init preview map
    let defaultCenterLocation = new google.maps.LatLng(6.8935381, 79.8908061);
    let mapOptions = {
        zoom: 16,
        center: defaultCenterLocation,
        mapTypeId: 'roadmap',
        disableDefaultUI: true,
        zoomControl: false,
        scaleControl: false,
    };
    let previewMapElement = document.getElementById('preview_map');
    previewMap = new google.maps.Map(previewMapElement, mapOptions);

    // init geocoder map
    let geocoderMapOptions = {
        zoom: 14,
        center: defaultCenterLocation,
        mapTypeId: 'roadmap',
    };
    let geocoderMapElement = document.getElementById('geocoder_map');
    geocoderMap = new google.maps.Map(geocoderMapElement, geocoderMapOptions);
    geocoderMap.addListener("click", (e) => {
        placeMarkerAndPanTo(e.latLng, geocoderMap);
    });

    directionsDisplay.setMap(previewMap);
    directionsDisplay.setOptions({
        // suppressMarkers: true,
        // preserveViewport: true,
        polylineOptions: {
            strokeColor: "#ff0000",
            strokeOpacity: 0.6,
            strokeWeight: 4
        },
    });

    initLocalStorage();

    if (start && end) {
        renderDirections();
    }
}

function placeMarkerAndPanTo(latLng, map) {
    // clear existing markers
    if (geocoderMarker) {
        geocoderMarker.setMap(null);
    }

    // show marker
    geocoderMarker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        title: "You can drag to select the location"
    });
    // pan to marker
    map.panTo(latLng);

    // pan the google map to drag location of the geocoder map
    geocoderMarker.addListener('dragend', (e) => {
        placeMarkerAndPanTo(e.latLng, map);
    });

    selectLocationDetailsFromLatLang(latLng);
}

function selectLocationDetailsFromLatLang(latLng) {
    // get location name
    let geocoder = new google.maps.Geocoder;
    geocoder.geocode({
        'location': latLng
    }, function(results, status) {
        if (status === 'OK') {
            if (results[1]) {
                console.log(results[1]);
                // get selection details
                selectionDetails.name = results[1].formatted_address;
                $('#search_geocode_location').val(selectionDetails.name);
                selectionDetails.lat = latLng.lat();
                selectionDetails.lng = latLng.lng();
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

$('#search_start_location').click(function() {
    selectionTarget = 'start_location';
    $('#geocodeModal').modal('show');
});

$('#search_end_location').click(function() {
    selectionTarget = 'end_location';
    $('#geocodeModal').modal('show');
});

$('#search_waypoints').click(function() {
    selectionTarget = 'waypoints';
    $('#geocodeModal').modal('show');
});

$('#select_marked_location').click(function() {
    $('#geocodeModal').modal('hide');
    if (selectionTarget == 'start_location') {
        $('#start_location').val(selectionDetails.name);
        $('#start_latitude').val(selectionDetails.lat);
        $('#start_longitude').val(selectionDetails.lng);

        // set to local storage
        start.name = selectionDetails.name;
        start.lat = selectionDetails.lat;
        start.lng = selectionDetails.lng;
        localStorage.setItem('start_location', JSON.stringify(start));

    } else if (selectionTarget == 'end_location') {
        $('#end_location').val(selectionDetails.name);
        $('#end_latitude').val(selectionDetails.lat);
        $('#end_longitude').val(selectionDetails.lng);

        // set to local storage
        end.name = selectionDetails.name;
        end.lat = selectionDetails.lat;
        end.lng = selectionDetails.lng;
        localStorage.setItem('end_location', JSON.stringify(end));
    } else if (selectionTarget == 'waypoints') {
        waypoints.push({
            name: selectionDetails.name,
            stopover: true,
            latitude: selectionDetails.lat,
            longitude: selectionDetails.lng
        });

        // set to local storage
        localStorage.setItem('waypoints', JSON.stringify(waypoints));
        renderWaypointsList();
    }
});

// gecode address and set marker on map
$('#search_geocode_location').keyup(function(e) {
    if (e.keyCode == 13) {
        let address = $(this).val();
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === 'OK') {
                placeMarkerAndPanTo(results[0].geometry.location, geocoderMap);
            } else {
                window.alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
});

function renderWaypointsList() {
    let waypointsList = $('#waypoints_list');
    waypointsList.empty();
    let num = 1;
    waypoints.forEach((waypoint, index) => {
        waypointsList.append(`
            <li class="list-group-item p-0">
                <div class="input-group">
                    <input type="text" class="form-control" value="${waypoint.name}" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" onclick="removeWaypoint(${index})">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </li>
        `);
    });

    renderDirections();
}

function removeWaypoint(index) {
    if (confirm('Are you sure?')) {
        waypoints.splice(index, 1);
        localStorage.setItem('waypoints', JSON.stringify(waypoints));
        renderWaypointsList();
    }
}

function renderDirections() {
    let waypointsList = [];

    // loop through waypoints array and add to waypoints
    waypoints.forEach((waypoint) => {
        waypointsList.push({
            location: new google.maps.LatLng(waypoint.latitude, waypoint.longitude),
            stopover: true
        });
    });

    // clear existing directions path
    if (directionsDisplay) {
        directionsService.waypoints = [];
    }

    directionsService.route({
        origin: new google.maps.LatLng(start.lat, start.lng),
        destination: new google.maps.LatLng(end.lat, end.lng),
        waypoints: waypointsList,
        travelMode: 'DRIVING',
    }, function(response, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(response);
            previewMap.setCenter(directionsDisplay.directions.routes[0].bounds.getCenter());
        }
    });
}

function sendRouteCreateRequest() {
    let data = {
        "local_authority_id": $('#local_authority_id').val(),
        "name": $('#route_name').val(),
        "status": "active",
        "start": {
            "location": start.name,
            "latitude": start.lat,
            "longitude": start.lng
        },
        "end": {
            "location": end.name,
            "latitude": end.lat,
            "longitude": end.lng
        },
        "roads": []
    };

    let num = 1;
    waypoints.forEach((waypoint) => {
        data.roads.push({
            "name": waypoint.name,
            "latitude": waypoint.latitude,
            "longitude": waypoint.longitude,
            "order_number": num
        });
        num++;
    });

    let url = BASE_URL + '/routes';
    $.post(url, data, function(response) {
        if (response.data) {
            Swal.fire('Success!', 'Route created successfully.', 'success');
        } else {
            Swal.fire('Error!', 'Route creation failed.', 'error');
            console.error('error: ' + response);
        }
        resetUI();
    }, 'json');
}

$('#send_create_route').click(sendRouteCreateRequest);

function getRoutesForLocalAuthority() {
    let localAuthorityId = $('#route_local_authority_id').val();

    let url = BASE_URL + `/routes/local-authority/${localAuthorityId}`;
    $.get(url, function(res) {
        let routeListTable = $('#route-list-table tbody');
        let routes = res.data;
        if (routes && routes.length > 0) {
            routeListTable.empty(); // clear existing rows

            let num = 1;

            routes.forEach((route) => {
                routeListTable.append(`
                    <tr>
                        <td>${num}</td>
                        <td>${route.name}</td>
                        <td>${route.start.location}</td>
                        <td>${route.end.location}</td>
                        <td>${route.roads.length} Roads</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-trigger="route_edit" data-route_id="${route.id}">Edit</button>
                            <button class="btn btn-sm btn-danger" data-trigger="route_delete" data-route_id="${route.id}">Delete</button>
                        </td>
                    </tr>
                `);
            });
        } else {
            routeListTable.html(`
            <tr>
                <td colspan="6">Routes will be listed here, when they are created for the selected local authority.</td>
            </tr>`);
        }
    }, 'json');
}

$('#route_local_authority_id').change(function() {
    getRoutesForLocalAuthority();
});

function deleteRoute(routeId) {
    Swal.fire({
        title: 'Are you sure you want to delete this route?',
        showCancelButton: true,
        confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            let deleteUrl = BASE_URL + `/routes/${routeId}`;
            $.delete(deleteUrl, function(res) {
                if (res.data) {
                    Swal.fire('Success!', 'Route deleted successfully.', 'success');
                } else {
                    Swal.fire('Error!', 'Route deletion failed.', 'error');
                    console.error('error: ' + res);
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Error!', 'Route deletion failed.', 'error');
        }
        resetUI();
    });
}

$(document).on('click', '[data-trigger="route_delete"]', function() {
    let routeId = $(this).data('route_id');
    deleteRoute(routeId);
});

// go to location with route/id
$(document).on('click', '[data-trigger="route_edit"]', function() {
    let routeId = $(this).data('route_id');
    window.location.href = BASE_URL + `/admin/routes/${routeId}`;
});

$('#reset_ui').click(resetUI);