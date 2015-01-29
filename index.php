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
    <span id="title">Hits Circle - opba.com.br</span>
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
	    contentCenter = '<span class="infowin">Center Marker (draggable)</span>';
	var circle, circle1;
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
	    markerCenter1 = new google.maps.Marker({
		position: latLngA,
		title: 'Location',
		map: map,
		draggable: true
	    }),
	    infoCenter = new google.maps.InfoWindow({
		content: contentCenter
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
	    circle1 = new google.maps.Circle({
		map: map,
		clickable: false,
		// metres
		radius: 300,
		fillColor: '#fff',
		fillOpacity: .6,
		strokeColor: '#313131',
		strokeOpacity: .4,
		strokeWeight: .8
	    });
	    
	    
	circle.bindTo('center', markerCenter, 'position');
	circle1.bindTo('center', markerCenter1, 'position');
	var
	    bounds = circle.getBounds(),
	    bounds1 = circle1.getBounds(),
	    noteA = jQuery('.bool#a'),
	    noteB = jQuery('.bool#b');

	noteA.text(bounds.contains(latLngA));
	noteB.text(bounds.contains(latLngB));
	
	google.maps.event.addListener(markerCenter, 'dragend', function() {
	    latLngCenter = new google.maps.LatLng(markerCenter.position.lat(), markerCenter.position.lng());
	    bounds = circle.getBounds();

	    var df1 = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), circle1.getCenter()) - circle.getRadius() - circle1.getRadius() <=0;
	    var df2 = google.maps.geometry.spherical.computeDistanceBetween(circle1.getCenter(), circle.getCenter()) - circle1.getRadius() -  circle.getRadius() <=0;
	    
	    var co = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), circle1.getCenter()) - circle.getRadius() - circle1.getRadius();
	    
	    noteA.text(df1);
	    noteB.text(df2);
	});
	google.maps.event.addListener(markerCenter1, 'dragend', function() {
	    latLngCenter = new google.maps.LatLng(markerCenter.position.lat(), markerCenter.position.lng());
	    bounds1 = circle1.getBounds();

	    var df1 = google.maps.geometry.spherical.computeDistanceBetween(circle.getCenter(), circle1.getCenter()) - circle.getRadius() - circle1.getRadius() <=0;
	    var df2 = google.maps.geometry.spherical.computeDistanceBetween(circle1.getCenter(), circle.getCenter()) - circle1.getRadius() - circle.getRadius() <=0;
	    
	    noteA.text(df1);
	    noteB.text(df2);
	});

	
	google.maps.event.addListener(markerCenter, 'click', function() {
	    infoCenter.open(map, markerCenter);
	});

	google.maps.event.addListener(markerCenter, 'drag', function() {
	    infoCenter.close();
	    noteA.html("draggin&hellip;");
	    noteB.html("draggin&hellip;");
	});
	google.maps.event.addListener(markerCenter1, 'click', function() {
	    infoCenter.open(map, markerCenter1);
	});

	google.maps.event.addListener(markerCenter1, 'drag', function() {
	    infoCenter.close();
	    noteA.html("draggin&hellip;");
	    noteB.html("draggin&hellip;");
	});

	
    };
</script>