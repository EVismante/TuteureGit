 function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(43.740559, 6.380062),
          zoom: 9,
          styles: [
    {
        "featureType": "water",
        "stylers": [
            {
                "color": "#b3dbf2"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            },
            {
                "weight": 6
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#e85113"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#efe9e4"
            },
            {
                "lightness": -40
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#efe9e4"
            },
            {
                "lightness": -20
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "lightness": 100
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "lightness": -100
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "labels.icon"
    },
    {
        "featureType": "landscape",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "stylers": [
            {
                "lightness": 20
            },
            {
                "color": "#efe9e4"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "lightness": 100
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "lightness": -100
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "hue": "#11ff00"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "lightness": 100
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            },
            {
                "color": "#f0e4d3"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#efe9e4"
            },
            {
                "lightness": -25
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#efe9e4"
            },
            {
                "lightness": -10
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    }
]

        });
        var infoWindow = new google.maps.InfoWindow;

        var iconBase = 'images/website/icons/';
        var icons = {
          club: {
            name: 'club',
            icon: iconBase + 'club.png'
          },
          event: {
            name: 'event',
            icon: iconBase + 'event.png'
          }
        };
               // Create markers.

          // Change this depending on the name of your PHP or XML file
          downloadUrl("map/map.xml", function(data) {

            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');

            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var idclub = markerElem.getAttribute('id');

              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('longt')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('h3');
              strong.textContent = name
              infowincontent.appendChild(strong);
              //infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('p');
              text.textContent = address;
              /*ajout du bouton*/
              var button = document.createElement('a');
          
              /*changer l'URL selon le type de prestataire*/
              var type = markerElem.getAttribute('type');
                if (type =="club") {
                   button.classList.add("btn");
                  button.setAttribute("href", 'club.php?id='+idclub);
                }
                if (type =="event") {
                   button.classList.add("btn_blue");
                  button.setAttribute("href", 'event.php?id='+idclub);
                }

              button.textContent = "Consulter";

              infowincontent.appendChild(text);
              infowincontent.appendChild(button);

              var type = markerElem.getAttribute('type');
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icons[type].icon,

              });

              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
                window.alert(marker.id);
              });



            });

          var mapDiv = document.querySelector("*[id^='club_']");
            google.maps.event.addDomListener(mapDiv, 'click', function() {
                var marker = $(this).attr("id");
                // window.alert(marker);
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            callback(request);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

