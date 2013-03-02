<div id="mapdiv" class="row"></div>
<script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script type="text/javascript"><!--//--><![CDATA[//><!--
// map constructor
    map = new OpenLayers.Map("mapdiv");
// map layer
    map.addLayer(new OpenLayers.Layer.OSM());
// 
//var markers = <?php //echo json_encode($markers) ?>;
    var pois = new OpenLayers.Layer.Text( "My Points",
                    { location:"<?php echo $genvars['blogtheme']. "/map.markers.php" ?>",
                      projection: map.displayProjection
                    });
//alert("Vamos a eliminar los resultados de la b'usqueda anterior.");
    map.addLayer(pois);
// 
    //Set start centrepoint and zoom    
    var lonLat = new OpenLayers.LonLat( 9.5788, 48.9773 )
//    var lonLat = new OpenLayers.LonLat( 2.2137, 46.2276 )
//https://maps.google.com/maps?q=france&hl=en&sll=36.879621,-68.115234&sspn=&t=h&hnear=France&z=5
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
    var zoom=0;
    map.setCenter (lonLat, zoom);  
 
//--><!]]></script>
