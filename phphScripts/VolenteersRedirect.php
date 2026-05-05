<?php
function simple_url_redirect() {
	
	
	$config = [
		"volentersQrRedirect" => "https://docs.google.com/forms/d/e/1FAIpQLSfSLBE9VGfU3EIsayrkXB0F7MdBTrHy4Ugxo1kyEIi3A9isoQ/viewform?usp=header",
		"latatude" => '34.878167',
		"logditude" =>'150.603917',
	];

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (rtrim($path, '/') === '/volenrersqrcode') {
		echo '    <script>
        const targetLat = ' . $config["latatude"] . '; // Sydney example
        const targetLon = ' . $config["logditude"] . ';
        function getLocationAndRedirect() {

            if (!navigator.geolocation) {
                console.log("Geolocation not supported");
                location.reload();
                return;
            }
            navigator.geolocation.getCurrentPosition(function (position) {

                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;

                const allowed = isWithinevent(
                    userLat,
                    userLon,
                    targetLat,
                    targetLon
                );

                if (allowed) {
                    window.location.href = "' . $config["volentersQrRedirect"] . '";
                } else {
                    document.getElementById("headingid").innerHTML = "to far way from event try again";
                }

            });
        }

        // Run on page load
        window.onload = getLocationAndRedirect;
        function isWithinevent(lat1, lon1, lat2, lon2) {

            const R = 6371;

            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const distance = R * c; // distance in km

            return distance <= 1; // true if within 1km, false otherwise
        }



    </script>
    <h2 id="headingid">if you dont redirect reload page</h2>';

    }
}

add_action('template_redirect', 'simple_url_redirect');
?>
