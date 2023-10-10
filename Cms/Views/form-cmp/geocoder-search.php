<?php
$fake_item = [
    'label' => '',
    'value' => '',
    'address_data_val' => '',
    'lat' => '',
    'lng' => '',
];

extract($fake_item);
extract($item);
?>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>


<div class="row col_2">

    <div class="form-group form-field-gmaps_addr">
        <label for="address"><?= (isset($label)) ? $label : '' ?></label>
        <input id="gmaps_addr" name="gmaps_addr" class="form-control gmaps_addr" type="textbox" value="<?= esc($value) ?>" />

    </div>
    <!-- <div class="form-group input-width-xmin form-field-gmaps_addr_btn">
        <label>&nbsp;</label>
        <input type="button" value="Vai" onclick="geocode()">
    </div> -->
    <input type="hidden" name="address_data" id="address_data" value="<?= esc($address_data_val) ?>" />
</div>
<div class="row">
    <div id="map" style="width: 100%; height: 380px;"></div>
</div>
<!-- prettier-ignore -->




<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAf-O3lG8BiNcHRYY2IOqL8I-A5btCTsE&libraries=places&callback=initMap&v=weekly" defer></script>
<script>
    let map;
    let marker;
    // let geocoder;
    let addressData;
    let latInput;
    let lngInput;
    let addressInput;
    let cittaInput;

    function initMap() {
        cittaInput = document.getElementById('citta');
        addressData = document.getElementById('address_data');
        latInput = document.getElementById('lat');
        lngInput = document.getElementById('lng');
        addressInput = document.getElementById('gmaps_addr');
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: <?= (isset($lat) && $lat != '' && isset($lng) && $lng != '') ? 14 : 11 ?>,
            center: {
                lat: <?= (isset($lat) && $lat != '') ? $lat : '41.891492' ?>,
                lng: <?= (isset($lng) && $lng != '') ? $lng : '12.492528' ?>
            },
            mapTypeControl: false,
            zoomControl: true,
            streetViewControl: false,
            fullscreenControl: false,
        });
        // geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            //     position: myLatLng,
            map
        });

        <?php if (isset($lat) && $lat != '' && isset($lng) && $lng != '') { ?>
            const myLatLng = {
                lat: <?= $lat  ?>,
                lng: <?= $lng  ?>
            };
            marker.setPosition(myLatLng);

        <?php } ?>




        const autocOptions = {
            fields: ["formatted_address", "geometry", "name", "address_components"],
            strictBounds: false,
        };
        const autocomplete = new google.maps.places.Autocomplete(addressInput, autocOptions);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            const currentResult = place;

            latInput.value = currentResult.geometry.location.lat();
            lngInput.value = currentResult.geometry.location.lng();
            addressInput.value = currentResult.formatted_address;

            const addressComponents = parseAddressComponents(currentResult.address_components);
            if(addressData && addressComponents){
                addressData.value = JSON.stringify(addressComponents);
                if(addressComponents['citta']){
                    if(cittaInput){
                        cittaInput.value = addressComponents['citta'];
                    }
                }
            }

            map.setCenter(currentResult.geometry.location);
            marker.setPosition(currentResult.geometry.location);
            marker.setMap(map);
        });

        // const testAddrCom = parseAddressComponents();
    }

    function parseAddressComponents(address_components) {
        const daParsare = ['route', 'street_number', 'administrative_area_level_3', 'administrative_area_level_2', 'administrative_area_level_1', 'country', 'postal_code'];
        const daParsareObj = {
            route: 'via',
            street_number: 'numero',
            administrative_area_level_3: 'citta',
            administrative_area_level_2: 'provincia',
            administrative_area_level_1: 'regione',
            country: 'nazione',
            postal_code: 'cap'
        };
        const returnAddrComps = Object();
        if (address_components) {
            address_components.map((compItem) => {
                const compItemType = compItem.types[0];
                if (daParsare.includes(compItemType)) {
                    // returnAddrComps[daParsareObj[compItemType]] = compItem.long_name;
                    returnAddrComps[daParsareObj[compItemType]] = compItem.short_name;
                }
            });
        }
        return returnAddrComps;
    }




    /*
    function geocode() {
        console.log('addressInput', addressInput.value);
        var request = {
            address: addressInput.value
        };
        geocoder
            .geocode(request)
            .then((result) => {
                const {
                    results
                } = result;
                if (results[0]) {
                    const currentResult = results[0];
                    latInput.value = currentResult.geometry.location.lat();
                    lngInput.value = currentResult.geometry.location.lng();
                    addressInput.value = currentResult.formatted_address;
                    // 
                    map.setCenter(currentResult.geometry.location);
                    marker.setPosition(currentResult.geometry.location);
                    marker.setMap(map);
                    return currentResult;
                }
            })
            .catch((e) => {
                // alert("Geocode was not successful for the following reason: " + e);
            });
        }
    */
</script>