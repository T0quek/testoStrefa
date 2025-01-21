@extends("app")

@section("content")

    <link href="{{asset("vendor/jquery-nice-select/css/nice-select.css")}}" rel="stylesheet">
    <link href="{{asset("vendor/owl-carousel/owl.carousel.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("vendor/nouislider/nouislider.min.css")}}">


    <div class="col-xl-12 mt-3">
        <div class="row">
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 flex-wrap">
                                <h4 class="fs-20 font-w700 mb-2">Twoje statystyki</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="d-flex">
                                        <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                            <span class="donut1" data-peity='{ "fill": ["rgba(255,255,255,1)", "rgba(241, 103, 54, 1)"],   "innerRadius": 20, "radius": 15}'>28/274</span>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="fs-24 font-w700 ">{{$allEndExams??"0"}}</h4>
                                            <span class="fs-16 font-w400 d-block">Liczba rozwiązanych testów</span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="d-flex me-5">
                                            <div class="mt-2">
                                                <svg width="13" height="13" viewbox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6.5" cy="6.5" r="6.5" fill="#F16736"></circle>
                                                </svg>
                                            </div>
                                            <div class="ms-3">
                                                <h4 class="fs-24 font-w700 ">{{$passedExams??"0"}}</h4>
                                                <span class="fs-16 font-w400 d-block">Zdanych</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="mt-2">
                                                <svg width="13" height="13" viewbox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6.5" cy="6.5" r="6.5" fill="#FFFFFF"></circle>
                                                </svg>

                                            </div>
                                            <div class="ms-3">
                                                <h4 class="fs-24 font-w700 ">{{$failedExams??"0"}}</h4>
                                                <span class="fs-16 font-w400 d-block">Niezdanych</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="monthly">
                                        <div id="chartBar" class="chartBar"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">

                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div>
                                    <h4 class="fs-20 font-w700">Ostatnie egzaminy</h4>
                                </div>
                                <div>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded fs-18">Pełna historia</a>
                                </div>
                            </div>
                            <div class="card-body px-0">
                                <div class="d-flex justify-content-between recent-emails">
                                    <div class="d-flex">
                                        <div class="ms-3">
                                            <h4 class="fs-18 font-w500">Kryptografia</h4>
                                            <span class="font-w400 d-block">Jakis tam opis</span>
                                        </div>
                                    </div>
                                    <div class="email-check">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-primary me-2">Kontynuuj</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between recent-emails">
                                    <div class="d-flex">
                                        <div class="ms-3">
                                            <h4 class="fs-18 font-w500">Radioamator</h4>
                                            <span class="font-w400 d-block">Jakis tam opis</span>
                                        </div>
                                    </div>
                                    <div class="email-check">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-primary me-2">Wypełnij ponownie</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between recent-emails">
                                    <div class="d-flex">
                                        <div class="ms-3">
                                            <h4 class="fs-18 font-w500">Radioamator</h4>
                                            <span class="font-w400 d-block">Jakis tam opis</span>
                                        </div>
                                    </div>
                                    <div class="email-check">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-primary me-2">Kontynuuj</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 mt-4">
                        <div class="row">
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4  justify-content-between">
                                        <div>
                                            <div class="">
                                                <h2 class="fs-32 font-w700">{{$averageScore??"0%"}}</h2>
                                                <span class="fs-18 font-w500 d-block">Średni wynik testu</span>
                                                <span class="d-block fs-16 font-w400"><small class="text-danger">-2% </small>niż poprzednio</span>
                                            </div>
                                        </div>
                                        <div id="wykres1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4  justify-content-between">
                                        <div>
                                            <div class="">
                                                <h2 class="fs-32 font-w700">8</h2>
                                                <span class="fs-18 font-w500 d-block">Testów tygodniowo</span>
                                                <span class="d-block fs-16 font-w400"><small class="text-success">+2%</small> niż poprzednio</span>
                                            </div>
                                        </div>
                                        <div id="wykres2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var donutChart1 = function(){
            $("span.donut1").peity("donut", {
                width: "70",
                height: "70"
            });
        }

        var chartBar = function(){

            var options = {
                series: [
                    {
                        name: 'Zdane',
                        data: [50, 18, 70, 40, 90, 70, 20],
                        //radius: 12,
                    },
                    {
                        name: 'Niezdane',
                        data: [80, 40, 55, 20, 45, 30, 80]
                    },

                ],
                chart: {
                    type: 'bar',
                    height: 400,

                    toolbar: {
                        show: false,
                    },

                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '57%',
                        endingShape: "rounded",
                        borderRadius: 12,
                    },

                },
                states: {
                    hover: {
                        filter: 'none',
                    }
                },
                colors:['#f16736', '#ffffff'],
                dataLabels: {
                    enabled: false,
                },
                markers: {
                    shape: "circle",
                },


                legend: {
                    show: false,
                    fontSize: '12px',
                    labels: {
                        colors: '#000000',

                    },
                    markers: {
                        width: 18,
                        height: 18,
                        strokeWidth: 10,
                        strokeColor: '#fff',
                        fillColors: undefined,
                        radius: 12,
                    }
                },
                stroke: {
                    show: true,
                    width: 4,
                    curve: 'smooth',
                    lineCap: 'round',
                    colors: ['transparent']
                },
                grid: {
                    borderColor: '#eee',
                },
                xaxis: {
                    position: 'bottom',
                    categories: ['Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela'],
                    labels: {
                        style: {
                            colors: '#787878',
                            fontSize: '13px',
                            fontFamily: 'poppins',
                            fontWeight: 100,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    },
                    crosshairs: {
                        show: false,
                    }
                },
                yaxis: {
                    labels: {
                        offsetX:-16,
                        style: {
                            colors: '#787878',
                            fontSize: '13px',
                            fontFamily: 'poppins',
                            fontWeight: 100,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    },
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'white',
                        type: "vertical",
                        shadeIntensity: 0.2,
                        gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 50, 50],
                        colorStops: []
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "$ " + val + " thousands"
                        }
                    }
                },
            };

            var chartBar1 = new ApexCharts(document.querySelector("#chartBar"), options);
            chartBar1.render();
        }


        	var wykres1 = function(){
                var options = {
                    series: [
                        {
                            name: 'Net Profit',
                            data: [100,300, 100, 400, 200, 400],
                            /* radius: 30,	 */
                        },
                    ],
                    chart: {
                        type: 'line',
                        height: 50,
                        width: 100,
                        toolbar: {
                            show: false,
                        },
                        zoom: {
                            enabled: false
                        },
                        sparkline: {
                            enabled: true
                        }

                    },

                    colors:['var(--primary)'],
                    dataLabels: {
                        enabled: false,
                    },

                    legend: {
                        show: false,
                    },
                    stroke: {
                        show: true,
                        width: 6,
                        curve:'smooth',
                        colors:['var(--primary)'],
                    },

                    grid: {
                        show:false,
                        borderColor: '#eee',
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0

                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    xaxis: {
                        categories: ['Jan', 'feb', 'Mar', 'Apr', 'May'],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            show: false,
                            style: {
                                fontSize: '12px',
                            }
                        },
                        crosshairs: {
                            show: false,
                            position: 'front',
                            stroke: {
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px',
                            }
                        }
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1,
                        colors:'#FB3E7A'
                    },
                    tooltip: {
                        enabled:false,
                        style: {
                            fontSize: '12px',
                        },
                        y: {
                            formatter: function(val) {
                                return "$" + val + " thousands"
                            }
                        }
                    }
                };

                var chartBar1 = new ApexCharts(document.querySelector("#wykres1"), options);
                chartBar1.render();

            }

        var wykres2 = function(){
            var options = {
                series: [
                    {
                        name: 'Net Profit',
                        data: [100,300, 200, 400, 100, 400],
                        /* radius: 30,	 */
                    },
                ],
                chart: {
                    type: 'line',
                    height: 50,
                    width: 80,
                    toolbar: {
                        show: false,
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }

                },

                colors:['#0E8A74'],
                dataLabels: {
                    enabled: false,
                },

                legend: {
                    show: false,
                },
                stroke: {
                    show: true,
                    width: 6,
                    curve:'smooth',
                    colors:['var(--primary)'],
                },

                grid: {
                    show:false,
                    borderColor: '#eee',
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0

                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                xaxis: {
                    categories: ['Jan', 'feb', 'Mar', 'Apr', 'May'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            fontSize: '12px',
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                        }
                    }
                },
                yaxis: {
                    show: false,
                },
                fill: {
                    opacity: 1,
                    colors:'#FB3E7A'
                },
                tooltip: {
                    enabled:false,
                    style: {
                        fontSize: '12px',
                    },
                    y: {
                        formatter: function(val) {
                            return "$" + val + " thousands"
                        }
                    }
                }
            };

            var chartBar1 = new ApexCharts(document.querySelector("#wykres2"), options);
            chartBar1.render();

        }

        document.addEventListener('DOMContentLoaded', function() {
            chartBar();
            wykres1();
            wykres2();
            donutChart1();
        });

    </script>

    <!--**********************************
     Scripts
 ***********************************-->
    <!-- Required vendors -->
{{--    <script src="{{asset("vendor/global/global.min.js")}}"></script>--}}
    <script src="{{asset("vendor/chart.js/Chart.bundle.min.js")}}"></script>
    <script src="{{asset("vendor/jquery-nice-select/js/jquery.nice-select.min.js")}}"></script>

    <!-- Apex Chart -->
    <script src="{{asset("vendor/apexchart/apexchart.js")}}"></script>

    <script src="{{asset("vendor/chart.js/Chart.bundle.min.js")}}"></script>

    <!-- Chart piety plugin files -->
    <script src="{{asset("vendor/peity/jquery.peity.min.js")}}"></script>
    <!-- Dashboard 1 -->
{{--    <script src="{{asset("js/dashboard/dashboard-1.js")}}"></script>--}}


    <script src="{{asset("vendor/owl-carousel/owl.carousel.js")}}"></script>


    <script>
        function cardsCenter()
        {

            /*  testimonial one function by = owl.carousel.js */



            jQuery('.card-slider').owlCarousel({
                loop:true,
                margin:0,
                nav:true,
                //center:true,
                slideSpeed: 3000,
                paginationSpeed: 3000,
                dots: true,
                navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
                responsive:{
                    0:{
                        items:1
                    },
                    576:{
                        items:1
                    },
                    800:{
                        items:1
                    },
                    991:{
                        items:1
                    },
                    1200:{
                        items:1
                    },
                    1600:{
                        items:1
                    }
                }
            })
        }

        jQuery(window).on('load',function(){
            setTimeout(function(){
                cardsCenter();
            }, 1000);
        });
        jQuery(document).ready(function(){
            setTimeout(function(){
                dlabSettingsOptions.version = 'dark';
                new dlabSettings(dlabSettingsOptions);
            },1500)
        });

    </script>
@endsection
