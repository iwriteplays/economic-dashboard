<!-- Highcharts licensed to Richer Design Group - Single Developer License -->
<section class="chart_module ">



    <div class="inner">

        <h2> New Projects Added</h2>
        <h5>Columbus 2020 defines a project as a qualified economic base business investment and/or job creation opportunity for which key project parameters have been defined. Click and drag to focus on a certain time period.</h5>
        <div class="dashboard">


            <div class="single-chart">

                <div id="chart-newprojectsadded"></div>
            </div>
            <div class="single-chart">

                <div id="chart-firsttimevisits"></div>
            </div>
        </div>




        <div class="clearfix"></div>

    </div>

</section>



<script>
    // Get the CSV and create the chart


    $(document).ready(function() {
        $.getJSON('https://sheetlabs.com/2020/C2020NewProjectsTextDate', function(jsondata) {


            var chartCats = [];
            var colorIndex;

            var options_newprojects = {

                chart: {
                    renderTo: 'chart-newprojectsadded',
                    type: 'column',
                    zoomType: 'x'
                },
                series: [{
                        name: "New Projects",
                        data: [{
                            y: 0,
                            className: ""
                        }],
                        colorByPoint: false,
                        dataLabels: false
                    },


                ],
                legend: {
                    enabled: false
                },
                title: {
                    text: 'Projects Created'
                },
                subtitle: {
                    text: 'Data shows new projects added to the pipeline on a monthly basis.'
                },

                xAxis: {
                    categories: [],
                    title: {
                        text: ""
                    }
                },

                yAxis: {
                    title: {
                        text: ""
                    }
                },
                tooltip: {
                    useHTML: true,
                    shadow: false,
                    pointFormat: '<span class="color">{point.y:.0f}</span> projects',
                },

                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{y:.0f} projects'
                        }
                    }
                },

                exporting: {
                    enabled: false

                }



            };

            /* GET ALL FILTERED ROWS */
            for (i = 0; i < jsondata.length; i++) {
                chartCats.push(jsondata[i].date);

            };

            var chartData0 = [];

            for (i = 0; i < jsondata.length; i++) {
                var cleanNumber = 0;


                cleanNumber = jsondata[i].newprojects;

                if (jsondata[i].date == "Columbus") {
                    colorIndex = "highlighted";
                } else {
                    colorIndex = "";

                }

                chartData0.push({
                    y: cleanNumber,
                    className: colorIndex
                });



            };









            options_newprojects.xAxis.categories = chartCats;


            options_newprojects.series[0].data = chartData0;







            var chart = new Highcharts.Chart(options_newprojects);




        });
    });
</script>

<script>
    // Get the CSV and create the chart

    $(document).ready(function() {

        $.getJSON('https://sheetlabs.com/2020/C2020NewProjectsTextDate', function(jsondata) {


            var chartCats = [];
            var colorIndex;

            var optionsvisits = {

                chart: {
                    renderTo: 'chart-firsttimevisits',
                    type: 'column',
                    zoomType: 'x'
                },
                series: [{
                        name: "First Time Visits",
                        colorByPoint: false,
                        data: [{
                            y: 0,
                            className: ""
                        }],
                        dataLabels: false

                    },


                ],
                title: {
                    text: 'First-Time Visits'
                },
                subtitle: {
                    text: 'An internal measure to count the first visits made by a company or consultant related to a specific project.'
                },

                xAxis: {
                    categories: [],
                    title: {
                        text: ""
                    }
                },

                yAxis: {
                    title: {
                        text: ""
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    useHTML: true,
                    shadow: false,
                    pointFormat: '<span class="color">{point.y:.0f}</span> visits',
                },

                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{y:.0f} visits'
                        }
                    }
                },

                exporting: {
                    enabled: false

                }



            };

            /* GET ALL FILTERED ROWS */
            for (i = 0; i < jsondata.length; i++) {
                chartCats.push(jsondata[i].date);

            };

            var chartData0 = [];

            for (i = 0; i < jsondata.length; i++) {
                var cleanNumber = 0;


                cleanNumber = jsondata[i].firsttimevisits;

                if (jsondata[i].date == "Columbus") {
                    colorIndex = "highlighted";
                } else {
                    colorIndex = "";

                }

                chartData0.push({
                    y: cleanNumber,
                    className: colorIndex
                });



            };









            optionsvisits.xAxis.categories = chartCats;


            optionsvisits.series[0].data = chartData0;




            var chart_visits = new Highcharts.Chart(optionsvisits);








        });
    });
</script>