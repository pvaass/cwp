jQuery(function ($) {
    'use strict';

    // Navigation Scroll
    $(window).scroll(function (event) {
        Scroll();
    });

    $('.scroll a').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $('html, body').animate({scrollTop: $(this.hash).offset().top - 50}, 1000);
        return false;
    });

    // User define function
    function Scroll() {
        var contentTop = [];
        var contentBottom = [];
        var winTop = $(window).scrollTop();
        var rangeTop = 200;
        var rangeBottom = 500;
        $('.scroll a').each(function () {
            var hashSplit = $(this).attr('href').split('#');
            var hash = hashSplit.length > 1 ? $('#' + hashSplit[1]) : null;
            if (!hash || !hash.offset()) {
                return;
            }
            contentTop.push(hash.offset().top);
            contentBottom.push(hash.offset().top + hash.height());
        });
        $.each(contentTop, function (i) {
            if (winTop > contentTop[i] - rangeTop) {
                $('.navbar-collapse li.scroll')
                    .removeClass('active')
                    .eq(i).addClass('active');
            }
        })
    };

    $('#tohash').on('click', function () {
        $('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
        return false;
    });

    // accordian
    $('.accordion-toggle').on('click', function () {
        $(this).closest('.panel-group').children().each(function () {
            $(this).find('>.panel-heading').removeClass('active');
        });

        $(this).closest('.panel-heading').toggleClass('active');
    });

    //Slider
    $(document).ready(function () {
        var time = 7; // time in seconds

        var $progressBar,
            $bar,
            $elem,
            isPause,
            tick,
            percentTime;

        //Init the carousel
        $("#main-slider").find('.owl-carousel').owlCarousel({
            slideSpeed: 500,
            paginationSpeed: 500,
            singleItem: true,
            navigation: true,
            navigationText: [
                "<i class='fa fa-angle-left'></i>",
                "<i class='fa fa-angle-right'></i>"
            ],
            afterInit: progressBar,
            afterMove: moved,
            startDragging: pauseOnDragging,
            //autoHeight : true,
            transitionStyle: "fadeUp"
        });

        //Init progressBar where elem is $("#owl-demo")
        function progressBar(elem) {
            $elem = elem;
            //build progress bar elements
            buildProgressBar();
            //start counting
            start();
        }

        //create div#progressBar and div#bar then append to $(".owl-carousel")
        function buildProgressBar() {
            $progressBar = $("<div>", {
                id: "progressBar"
            });
            $bar = $("<div>", {
                id: "bar"
            });
            $progressBar.append($bar).appendTo($elem);
        }

        function start() {
            //reset timer
            percentTime = 0;
            isPause = false;
            //run interval every 0.01 second
            tick = setInterval(interval, 10);
        };

        function interval() {
            if (isPause === false) {
                percentTime += 1 / time;
                $bar.css({
                    width: percentTime + "%"
                });
                //if percentTime is equal or greater than 100
                if (percentTime >= 100) {
                    //slide to next item
                    $elem.trigger('owl.next')
                }
            }
        }

        //pause while dragging
        function pauseOnDragging() {
            isPause = true;
        }

        //moved callback
        function moved() {
            //clear interval
            clearTimeout(tick);
            //start again
            start();
        }
    });

    //Initiat WOW JS
    new WOW().init();
    //smoothScroll
    smoothScroll.init();

    // portfolio filter
    $(window).load(function () {
        'use strict';
        var $portfolio_selectors = $('.portfolio-filter >li>a');
        var $portfolio = $('.portfolio-items');
        $portfolio.isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
        });

        $portfolio_selectors.on('click', function () {
            $portfolio_selectors.removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $portfolio.isotope({filter: selector});
            return false;
        });
    });

    $(document).ready(function () {
        //Animated Progress
        $('.progress-bar').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
            if (visible) {
                $(this).css('width', $(this).data('width') + '%');
                $(this).unbind('inview');
            }
        });

        //Animated Number
        $.fn.animateNumbers = function (stop, commas, duration, ease) {
            return this.each(function () {
                var $this = $(this);
                var start = parseInt($this.text().replace(/,/g, ""));
                commas = (commas === undefined) ? true : commas;
                $({value: start}).animate({value: stop}, {
                    duration: duration == undefined ? 1000 : duration,
                    easing: ease == undefined ? "swing" : ease,
                    step: function () {
                        $this.text(Math.floor(this.value));
                        if (commas) {
                            $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                        }
                    },
                    complete: function () {
                        if (parseInt($this.text()) !== stop) {
                            $this.text(stop);
                            if (commas) {
                                $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                            }
                        }
                    }
                });
            });
        };

        $('.animated-number').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
            var $this = $(this);
            if (visible) {
                $this.animateNumbers($this.data('digit'), false, $this.data('duration'));
                $this.unbind('inview');
            }
        });
    });

    // Contact form
    var form = $('#main-contact-form');
    form.submit(function (event) {
        event.preventDefault();
        var form_status = $('<div class="form_status"></div>');
        $.ajax({
            url: $(this).attr('action'),
            beforeSend: function () {
                form.prepend(form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn());
            }
        }).done(function (data) {
            form_status.html('<p class="text-success">Thank you for contact us. As early as possible  we will contact you</p>').delay(3000).fadeOut();
        });
    });

    //Pretty Photo
    $("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools: false
    });

    var locations = [
        ['Het Zuiderpark', 52.0528355, 4.2851475, 1],
        ['De Waterthor', 52.0658249, 4.2463693, 2],
        ['De Blinkerd', 52.1062128, 4.2807188, 3],
        ['De Houtzagerij', 52.0699413, 4.3019263, 4],
        ['Steenvoorde', 52.0388966, 4.3071353, 5],
        ['Het Hofbad', 52.0530853, 4.3808283, 6],
        ['Escamphof', 52.0650032, 4.2747264, 7],
        ['De Schilp', 52.0381758, 4.2966581, 8]
    ];

    var locationText = [
        new google.maps.InfoWindow({
            content: '<h5>Het Zuiderpark</h5><br />Meester P. Drooglever Fortuynweg 59, <br />2533 SP Den Haag'
        }),
        new google.maps.InfoWindow({
            content: '<h5>De Waterthor</h5><br />Thorbeckelaan 350,<br />2546 BZ Den Haag'
        }),
        new google.maps.InfoWindow({
            content: '<h5>De Blinkerd</h5><br />Seinpoststraat 150,<br />2586 HC Den Haag'
        }),
        new google.maps.InfoWindow({
            content: '<h5>De Houtzagerij</h5><br />Hobbemastraat 93,<br />2526 JG Den Haag'
        }),
        new google.maps.InfoWindow({
            content: '<h5>Steenvoorde</h5><br />Generaal Spoorlaan 62,<br />2285 CH Rijswijk'
        }),
        new google.maps.InfoWindow({
            content: '<h5>Het Hofbad</h5><br />Ypenburgse Boslaan 30,<br />2496 ZA Den Haag'
        }),
        new google.maps.InfoWindow({
            content: '<h5>Escamphof</h5><br />Escamplaan 57,<br />2574 GA Den Haag'
        }),
        new google.maps.InfoWindow({
            content: '<h5>De Schilp</h5><br />Schaapweg 4,<br />2285 SP Rijswijk'
        })
    ];

    //Google Map
    var latitude = $('#google-map').data('latitude');
    var longitude = $('#google-map').data('longitude');

    function initialize_map() {
        var myLatlng = new google.maps.LatLng(52.0699413, 4.3019263);
        var mapOptions = {
            zoom: 12,
            scrollwheel: false,
            center: myLatlng,
            zoomControl: false,
            scaleControl: false,
            streetViewControl: false,
            mapTypeControl: false
        };
        var map = new google.maps.Map(document.getElementById('google-map'), mapOptions);

        var markers = [];
        for (var i = 0; i < locations.length; i++) {
            markers[i] = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });
            markers[i].infoWindow = locationText[i];

            google.maps.event.addListener(markers[i], 'click', function() {
                for(var j = 0; j < markers.length; j++) {
                    markers[j].infoWindow.close();
                }
                this.infoWindow.open(map, this);
            });
        }
        // var marker = new google.maps.Marker({
        // 	position: myLatlng,
        // 	map: map
        // });
    }

    google.maps.event.addDomListener(window, 'load', initialize_map);
});
