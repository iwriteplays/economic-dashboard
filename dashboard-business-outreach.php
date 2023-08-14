<?php /* first get all the counts */

$cities = array();
$sectors = array();
$dates = array();

$url = 'https://sheetlabs.com/2020/c2020BusinessRetention';
$contents = file_get_contents($url);
$json = json_decode($contents);


foreach ($json as $j) {
    $cities[] = $j->countycity;
    $sectors[] = $j->category;
    $dates[] = $j->meetingdate;
}
$cities = array_unique($cities);
$sectors = array_unique($sectors);
$dates = array_unique($dates);
rsort($dates);
sort($cities);
sort($sectors);




$newest = $dates[0];

?>




<section class="chart_module">

    <h2>Existing Business Outreach</h2>
    <h5><span class="business-outreach-date"><?php echo date("F Y", strtotime($newest)); ?></span>: <span class="business-outreach-total"></span> visits <span class="business-outreach-filtered"></span></h5>


    <div class="inner">



        <div id="business-outreach" class="dashboard" data-active-filter="*" data-active-filter-type="*">
            <div class="single-chart">
                <div id="chart-dashboard-existing-business-category"></div>
            </div>

            <div class="single-chart">
                <div id="chart-dashboard-existing-business-countycity"></div>
            </div>


        </div>

        <div class="filter-group business-outreach">
            <div class="btn-group filters date" data-active-date="<?php echo $newest; ?>">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item active" data-default="<?php echo date("F Y", strtotime($newest)); ?>"><?php echo date("F Y", strtotime($newest)); ?></span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">


                    <?php foreach ($dates as $date) { ?>
                        <li>
                            <a data-id="<?php echo $date; ?>" data-category="meetingdate" class="change-chart" class="btn" data-datename="<?php echo date(" F Y ", strtotime($date)); ?>">
                                <?php echo date("F Y", strtotime($date)); ?>
                            </a>
                        </li>
                    <?php } ?>


                </ul>

            </div>



            <div class="btn-group filters" id="lead">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item" data-default="Location">Location</span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">


                    <?php foreach ($cities as $city) { ?>
                        <li>
                            <a data-id="<?php echo $city; ?>" data-category="countycity" class="change-chart" class="btn">
                                <?php echo $city; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a data-id="Location" data-category="*" class="change-chart" class="btn">All</a>
                    </li>
                </ul>

            </div>


            <div class="btn-group filters" id="cat">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item" data-default="Sector">Sector</span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">


                    <?php foreach ($sectors as $sector) { ?>
                        <li>
                            <a data-id="<?php echo $sector; ?>" data-category="category" class="change-chart" class="btn">
                                <?php echo $sector; ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li>
                        <a data-id="Sector" data-category="*" class="change-chart" class="btn">All</a>
                    </li>
                </ul>

            </div>

        </div>




        <div class="clearfix"></div>







        <script>
            $(document).ready(function() {

                var sectors = []; // sector
                var counties = []; // countycity

                var sectorcount = [];
                var countiescount = [];

                var totalsectors = [];
                var totalcounties = [];

                $.getJSON('https://sheetlabs.com/2020/c2020BusinessRetention', function(jsondata) {

                    for (i = 0; i < jsondata.length; i++) {
                        totalsectors.push(jsondata[i].category);
                        totalcounties.push(jsondata[i].countycity);

                        if (jsondata[i].meetingdate == "<?php echo $newest; ?>") {
                            sectors.push(jsondata[i].category);
                            counties.push(jsondata[i].countycity);
                        }
                    }
                    var sectorsUnique = totalsectors.unique2();
                    var countiesUnique = totalcounties.unique2();

                    for (i = 0; i < sectorsUnique.length; i++) {
                        target = sectorsUnique[i];
                        var numOccurences = $.grep(sectors, function(elem) {
                            return elem === target;
                        }).length;
                        sectorcount.push({
                            y: numOccurences,
                            name: sectorsUnique[i]
                        });

                    }

                    for (i = 0; i < countiesUnique.length; i++) {
                        target = countiesUnique[i];
                        var numOccurences = $.grep(counties, function(elem) {
                            return elem === target;
                        }).length;
                        countiescount.push({
                            y: numOccurences,
                            name: countiesUnique[i]
                        });

                    }



                    // Build the chart
                    var options = {
                        chart: {
                            renderTo: 'chart-dashboard-existing-business-category',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Visits by Sector'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} visits</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true,
                                point: {
                                    events: {
                                        legendItemClick: function() {
                                            return false;
                                        }
                                    }
                                }
                            }
                        },
                        series: [{
                            name: 'Category',
                            colorByPoint: true,
                            data: sectorcount
                        }],
                        exporting: {
                            enabled: false
                        }
                    };

                    var options_countycity = {

                        chart: {
                            renderTo: 'chart-dashboard-existing-business-countycity',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Visits by Location'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} visits</b>'

                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false
                                },
                                showInLegend: true,
                                point: {
                                    events: {
                                        legendItemClick: function() {
                                            return false;
                                        }
                                    }
                                }
                            }
                        },
                        series: [{
                            colorByPoint: true,
                            data: countiescount
                        }],
                        exporting: {
                            enabled: false
                        }
                    };

                    var chart_categoryoutreach = new Highcharts.chart(options);
                    var chart_countycity = new Highcharts.chart(options_countycity);


                    $(".business-outreach-total").html(sectors.length);




                    $('.business-outreach .change-chart').click(function() {
                        var sectorsChangeData = [];
                        var countiesChangeData = [];

                        var sectorsChange = [];
                        var countiesChange = [];

                        var sectorsUniqueChange = [];
                        var countiesUniqueChange = [];

                        var changeto = $(this).data('id');
                        var changecat = $(this).data('category');

                        var activeDate = $(".business-outreach .filters.date").data("active-date");


                        if (changecat == "*") {
                            for (i = 0; i < jsondata.length; i++) {
                                if (jsondata[i].meetingdate == activeDate) {
                                    sectorsChange.push(jsondata[i].category);
                                    countiesChange.push(jsondata[i].countycity);
                                }
                            }
                            $("#business-outreach").data("active-filter", "*").attr("data-active-filter", "*");
                            $("#business-outreach").data("active-filter-type", "*").attr("data-active-filter-type", "*");
                        } else if (changecat == "meetingdate") {
                            if ($("#business-outreach").data("active-filter") != "*") {
                                var activeFilter = $("#business-outreach").data("active-filter");
                                var activeFilterCat = $("#business-outreach").data("active-filter-type");
                                for (i = 0; i < jsondata.length; i++) {
                                    if ((jsondata[i][activeFilterCat] == activeFilter) && (jsondata[i].meetingdate == changeto)) {
                                        sectorsChange.push(jsondata[i].category);
                                        countiesChange.push(jsondata[i].countycity);
                                    }
                                }
                            } else {
                                for (i = 0; i < jsondata.length; i++) {
                                    if (jsondata[i].meetingdate == changeto) {
                                        sectorsChange.push(jsondata[i].category);
                                        countiesChange.push(jsondata[i].countycity);
                                    }
                                }
                            }
                        } else {
                            for (i = 0; i < jsondata.length; i++) {
                                if ((jsondata[i][changecat] == changeto) && (jsondata[i].meetingdate == activeDate)) {
                                    sectorsChange.push(jsondata[i].category);
                                    countiesChange.push(jsondata[i].countycity);
                                }
                            }
                            $("#business-outreach").data("active-filter", changeto).attr("data-active-filter", changeto);
                            $("#business-outreach").data("active-filter-type", changecat).attr("data-active-filter-type", changecat);
                        }


                        sectorsUniqueChange = totalsectors.unique2();
                        countiesUniqueChange = totalcounties.unique2();

                        for (i = 0; i < sectorsUniqueChange.length; i++) {
                            target = sectorsUniqueChange[i];
                            var numOccurences = $.grep(sectorsChange, function(elem) {
                                return elem === target;
                            }).length;
                            sectorsChangeData.push({
                                y: numOccurences,
                                name: sectorsUniqueChange[i]
                            });

                        }

                        for (i = 0; i < countiesUniqueChange.length; i++) {
                            target = countiesUniqueChange[i];
                            var numOccurences = $.grep(countiesChange, function(elem) {
                                return elem === target;
                            }).length;
                            countiesChangeData.push({
                                y: numOccurences,
                                name: countiesUniqueChange[i]
                            });

                        }

                        var title = changecat;

                        chart_categoryoutreach.series[0].setData(sectorsChangeData);
                        console.log(sectorsChangeData);
                        chart_countycity.series[0].setData(countiesChangeData);

                        // change button


                        if (changecat == "meetingdate") {
                            var dateName = $(this).data("datename");
                            $(this).closest(".btn-group").find(".active-item").html(dateName);
                            $(".business-outreach .filters.date").attr("data-active-date", changeto).data("active-date", changeto);
                            $(".business-outreach-date").html(dateName);
                            $(".business-outreach-total").html(sectorsChange.length);
                        } else if (changecat == "*") {
                            $(".btn-group").not(".business-outreach .filters.date").each(function() {
                                var resetText = $(this).find(".active-item").data("default");
                                $(this).find(".active-item").removeClass("active").html(resetText);
                            });
                            $(this).closest(".btn-group").find(".active-item").html(changeto);
                            $(".business-outreach-total").html(sectorsChange.length);


                        } else {
                            $(".btn-group").not(".business-outreach .filters.date").each(function() {
                                var resetText = $(this).find(".active-item").data("default");
                                $(this).find(".active-item").removeClass("active").html(resetText);
                            });
                            $(this).closest(".btn-group").find(".active-item").addClass("active").html(changeto);
                            $(".business-outreach-total").html(sectorsChange.length);

                        }
                        if ($("#business-outreach").data("active-filter") != "*") {
                            $(".business-outreach-filtered").html("matching '" + $('#business-outreach').data('active-filter') + "'");

                        } else {
                            $(".business-outreach-filtered").html("");
                        }

                    });




                });
            });
        </script>

    </div>

</section>