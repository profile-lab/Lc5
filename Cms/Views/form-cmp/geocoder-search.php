<?php
$fake_item = [
    'label' => '',
    'value' => '',
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
        <input id="address" class="form-control gmaps_addr" type="textbox" value="<?= esc($value) ?>" />

    </div>
    <div class="form-group input-width-xmin form-field-gmaps_addr_btn">
        <label>&nbsp;</label>
        <input type="button" value="Vai" onclick="codeAddress()">
    </div>
</div>
<div class="row">
    <div id="map" style="width: 100%; height: 380px;"></div>
</div>
<!-- prettier-ignore -->
<script>
    (g => {
        var h, a, k, p = "The Google Maps JavaScript API",
            c = "google",
            l = "importLibrary",
            q = "__ib__",
            m = document,
            b = window;
        b = b[c] || (b[c] = {});
        var d = b.maps || (b.maps = {}),
            r = new Set,
            e = new URLSearchParams,
            u = () => h || (h = new Promise(async (f, n) => {
                await (a = m.createElement("script"));
                e.set("libraries", [...r] + "");
                for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                e.set("callback", c + ".maps." + q);
                a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                d[q] = f;
                a.onerror = () => h = n(Error(p + " could not load."));
                a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                m.head.append(a)
            }));
        d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
    })
    ({
        key: "AIzaSyAAf-O3lG8BiNcHRYY2IOqL8I-A5btCTsE",
        v: "beta"
    });
</script>
<?php /*
*/ ?>
<script>
    var geocoder;
    var map;

    document.addEventListener("DOMContentLoaded", init);

    function init() {
        async function initialize() {
            const {Geocoder} = await google.maps.importLibrary("geocoding");
            geocoder = Geocoder;
           
            // geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(<?= (isset($lat) && $lat != '') ? $lat : '41.891492' ?>, <?= (isset($lng) && $lng != '') ? $lng : '12.492528' ?>);
            var mapOptions = {
                zoom: 8,
                center: latlng
            }
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
        }



        // async function initMap() {
        //     // const {Geocoder} = await google.maps.importLibrary("geocoding");
        //     // geocoder = Geocoder;
           
            


        //     const position = {
        //         lat: <?= (isset($lat) && $lat != '') ? $lat : '41.891492' ?>,
        //         lng: <?= (isset($lng) && $lng != '') ? $lng : '12.492528' ?>
        //     };
        //     const {
        //         Map
        //     } = await google.maps.importLibrary("maps");
        //     map = new Map(document.getElementById("map"), {
        //         zoom: 16,
        //         center: position,
                
        //     });
            
        // }
        // initMap();

        function codeAddress() {
            var address = document.getElementById('address').value;
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        initialize();
    }
</script>