<!--
    Developer Update Controller
    Leonardo Miyamoto 2015
    hkanata@gmail.com
    
    Hits beetween circles

-->
<style>
    body {margin: 0; padding: 0}
    html, body, #map {height: 100%; font-family: Arial, sans-serif; font-size: .9em; color: #fff;}
    #note { text-align: center;padding: .3em; 10px; background: #009ee0; }
    .bool {font-style: italic;color: #313131;}
    .info {display: inline-block;width: 40%;text-align: center;}
    .infowin {color: #313131;}
    #title,.bool{font-weight: bold;}
</style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&extension=.js"></script>
<div id="note">
    <span id="title">HITS Circles - opba.com.br</span>
    <hr />
    <span class="info">
	Marker <strong>A</strong>: <span id="a" class="bool"></span>
    </span> 
    &larr;&diams;&rarr; 
    <span class="info">
	Marker <strong>B</strong>: <span id="b" class="bool"></span>
    </span>
</div>
<div id="map"></div>

<script>
    window.onload = function init() {
	var
	    contentCenter = '<span class="infowin">Center Marker (draggable)</span>',
	    contentA = '<span class="infowin">Marker A (draggable)</span>',
	    contentB = '<span class="infowin">Marker B (draggable)</span>';
	var
	    latLngCenter = new google.maps.LatLng(-19.859618, -43.969575),
	    
	    latLngCMarker = new google.maps.LatLng(-19.859618, -43.969575),
	    latLngA = new google.maps.LatLng(-19.861698, -43.963505),
	    latLngB = new google.maps.LatLng(-19.869698, -43.969575),
	    map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: latLngCenter,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false
	    }),
	    markerCenter = new google.maps.Marker({
		position: latLngCMarker,
		title: 'Location',
		map: map,
		draggable: true
	    }),
	    infoCenter = new google.maps.InfoWindow({
		content: contentCenter
	    }),
	    markerA = new google.maps.Marker({
		position: latLngA,
		title: 'Location',
		map: map,
		draggable: true
	    }),
	    infoA = new google.maps.InfoWindow({
		content: contentA
	    }),
	    markerB = new google.maps.Marker({
		position: latLngB,
		title: 'Location',
		map: map,
		draggable: true
	    }),
	    infoB = new google.maps.InfoWindow({
		content: contentB
	    }),
	    circle = new google.maps.Circle({
		map: map,
		clickable: false,
		// metres
		radius: 1000,
		fillColor: '#fff',
		fillOpacity: .6,
		strokeColor: '#313131',
		strokeOpacity: .4,
		strokeWeight: .8
	    });
	    
	circle.bindTo('center', markerCenter, 'position');
	var
	    bounds = circle.getBounds(),
	    noteA = jQuery('.bool#a'),
	    noteB = jQuery('.bool#b');

	noteA.text(bounds.contains(latLngA));
	noteB.text(bounds.contains(latLngB));
	
	google.maps.event.addListener(markerCenter, 'dragend', function() {
	    latLngCenter = new google.maps.LatLng(markerCenter.position.lat(), markerCenter.position.lng());
	    bounds = circle.getBounds();

	    //noteA.text(bounds.contains(latLngA));
	    //noteB.text(bounds.contains(latLngB));
	    noteA.text(google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), latLngA) <= circle.getRadius());
	    noteB.text(google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), latLngB) <= circle.getRadius());

	    //var pointIsInsideCircle = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), latLngA) <= circle.getRadius();
	});

	google.maps.event.addListener(markerA, 'dragend', function() {
	    latLngA = new google.maps.LatLng(markerA.position.lat(), markerA.position.lng());
	    //noteA.text(bounds.contains(latLngA));
	    noteA.text(google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), latLngA) <= circle.getRadius());
	});

	google.maps.event.addListener(markerB, 'dragend', function() {
	    latLngB = new google.maps.LatLng(markerB.position.lat(), markerB.position.lng());
	    //noteB.text(bounds.contains(latLngB));
	    noteB.text(google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), latLngB) <= circle.getRadius());
	});

	google.maps.event.addListener(markerCenter, 'click', function() {
	    infoCenter.open(map, markerCenter);
	});

	google.maps.event.addListener(markerA, 'click', function() {
	    infoA.open(map, markerA);
	});

	google.maps.event.addListener(markerB, 'click', function() {
	    infoB.open(map, markerB);
	});

	google.maps.event.addListener(markerCenter, 'drag', function() {
	    infoCenter.close();
	    noteA.html("draggin&hellip;");
	    noteB.html("draggin&hellip;");
	});

	google.maps.event.addListener(markerA, 'drag', function() {
	    infoA.close();
	    noteA.html("draggin&hellip;");
	});

	google.maps.event.addListener(markerB, 'drag', function() {
	    infoB.close();
	    noteB.html("draggin&hellip;");
	});
    };
</script>