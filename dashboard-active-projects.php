<?php /* first get all the counts */

$categories = array();
$sources = array();
$dates = array();

$url = 'https://sheetlabs.com/2020/c2020ActiveProjects_new';
$contents = file_get_contents($url);
$json = json_decode($contents);


foreach ($json as $j) {
    $categories[] = $j->category;
    $sources[] = $j->projectlead;
    $dates[] = $j->reportdate;
}
$sources = array_unique($sources);
$dates = array_unique($dates);
rsort($dates);
$categories = array_unique($categories);


$newest = $dates[0];

?>



<section class="chart_module active-projects">

    <h2>Active Projects</h2>
    <h5><span class="active-projects-date"><?php echo date("F Y", strtotime($newest)); ?></span>: <span class="active-projects-total"></span> active projects <span class="active-projects-filtered"></span></h5>


    <div class="inner">



        <div id="active-projects" class="dashboard" data-active-filter="*" data-active-filter-type="*">
            <div class="single-chart">
                <div id="chart-dashboard-active-projects-category"></div>
            </div>
            <div class="single-chart">
                <div id="chart-dashboard-active-projects-projectlead"></div>
            </div>
            <div class="single-chart">
                <div id="chart-dashboard-active-projects-domesticorinternational"></div>
            </div>
            <div class="single-chart">
                <div id="chart-dashboard-active-projects-neworexisting"></div>
            </div>
        </div>

        <div class="filter-group active-projects">
            <div class="btn-group filters date" data-active-date="<?php echo $newest; ?>">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item active" data-default="<?php echo date("F Y", strtotime($newest)); ?>"><?php echo date("F Y", strtotime($newest)); ?></span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">


                    <?php foreach ($dates as $date) { ?>
                        <li>
                            <a data-id="<?php echo $date; ?>" data-category="reportdate" class="change-chart" class="btn" data-datename="<?php echo date(" F Y ", strtotime($date)); ?>">
                                <?php echo date("F Y", strtotime($date)); ?>
                            </a>
                        </li>
                    <?php } ?>


                </ul>

            </div>

            <div class="btn-group filters" id="noe">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item" data-default="New or Existing">New or Existing</span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">

                    <li>
                        <a data-id="New" data-category="neworexisting" class="change-chart" class="btn">New</a>
                    </li>
                    <li>
                        <a data-id="Existing" data-category="neworexisting" class="change-chart" class="btn">Existing</a>
                    </li>
                    <li>
                        <a data-id="New or Existing" data-category="*" class="change-chart" class="btn">All</a>
                    </li>
                </ul>

            </div>
            <div class="btn-group filters" id="doe">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item" data-default="Domestic or International">Domestic or International</span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">

                    <li>
                        <a data-id="Domestic" data-category="domesticorinternational" class="change-chart" class="btn">Domestic</a>

                    </li>
                    <li>
                        <a data-id="International" data-category="domesticorinternational" class="change-chart" class="btn">International</a>

                    </li>
                    <li>
                        <a data-id="Domestic or International" data-category="*" class="change-chart" class="btn">All</a>
                    </li>
                </ul>

            </div>

            <div class="btn-group filters" id="lead">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item" data-default="Project Source">Project Source</span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">


                    <?php foreach ($sources as $source) { ?>
                        <li>
                            <a data-id="<?php echo $source; ?>" data-category="projectlead" class="change-chart" class="btn">
                                <?php echo $source; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a data-id="Project Source" data-category="*" class="change-chart" class="btn">All</a>
                    </li>
                </ul>

            </div>


            <div class="btn-group filters" id="cat">
                <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="active-item" data-default="Project Sector">Project Sector</span> <i class="icon-arrow-down"></i>
                </button>
                <ul class="dropdown-menu">


                    <?php foreach ($categories as $category) { ?>
                        <li>
                            <a data-id="<?php echo $category; ?>" data-category="category" class="change-chart" class="btn">
                                <?php echo $category; ?>
                            </a>
                        </li>
                    <?php } ?>

                    <li>
                        <a data-id="Project Sector" data-category="*" class="change-chart" class="btn">All</a>
                    </li>
                </ul>

            </div>

        </div>




        <div class="clearfix"></div>







        <script>
            $(document).ready(function() {

                var categories = [];
                var leads = [];
                var doi = [];
                var noe = [];

                var totalcategories = [];
                var totalleads = [];
                var totaldoi = [];
                var totalnoe = [];

                var catcount = [];
                var leadcount = [];
                var doicount = [];
                var noecount = [];

                $.getJSON('https://sheetlabs.com/2020/c2020ActiveProjects_new', function(jsondata) {

                    for (i = 0; i < jsondata.length; i++) {
                        totalcategories.push(jsondata[i].category);
                        totalleads.push(jsondata[i].projectlead);
                        totaldoi.push(jsondata[i].domesticorinternational);
                        totalnoe.push(jsondata[i].neworexisting);
                        if (jsondata[i].reportdate == "<?php echo $newest; ?>") {
                            categories.push(jsondata[i].category);
                            leads.push(jsondata[i].projectlead);
                            doi.push(jsondata[i].domesticorinternational);
                            noe.push(jsondata[i].neworexisting);
                        }
                    }
                    var catUnique = totalcategories.unique2();
                    var leadsUnique = totalleads.unique2();
                    var doiUnique = totaldoi.unique2();
                    var noeUnique = totalnoe.unique2();

                    for (i = 0; i < catUnique.length; i++) {
                        target = catUnique[i];
                        var numOccurences = $.grep(categories, function(elem) {
                            return elem === target;
                        }).length;
                        catcount.push({
                            y: numOccurences,
                            name: catUnique[i]
                        });

                    }
                    for (i = 0; i < leadsUnique.length; i++) {
                        target = leadsUnique[i];
                        var numOccurences = $.grep(leads, function(elem) {
                            return elem === target;
                        }).length;
                        leadcount.push({
                            y: numOccurences,
                            name: leadsUnique[i]
                        });

                    }
                    for (i = 0; i < doiUnique.length; i++) {
                        target = doiUnique[i];
                        var numOccurences = $.grep(doi, function(elem) {
                            return elem === target;
                        }).length;
                        doicount.push({
                            y: numOccurences,
                            name: doiUnique[i]
                        });

                    }

                    for (i = 0; i < noeUnique.length; i++) {
                        target = noeUnique[i];
                        var numOccurences = $.grep(noe, function(elem) {
                            return elem === target;
                        }).length;
                        noecount.push({
                            y: numOccurences,
                            name: noeUnique[i]
                        });

                    }


                    // Build the chart
                    var options = {
                        chart: {
                            renderTo: 'chart-dashboard-active-projects-category',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Active Projects by Category'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} projects</b>'
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
                            data: catcount
                        }],
                        exporting: {
                            enabled: false
                        }
                    };
                    var options_projectlead = {

                        chart: {
                            renderTo: 'chart-dashboard-active-projects-projectlead',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Active Projects by Lead'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} projects</b>'

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
                            name: 'Lead Point of Entry',
                            colorByPoint: true,
                            data: leadcount
                        }],
                        exporting: {
                            enabled: false
                        }
                    };
                    var options_domesticorinternational = {

                        chart: {
                            renderTo: 'chart-dashboard-active-projects-domesticorinternational',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'Domestic vs. International'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} projects</b>'

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
                            data: doicount
                        }],
                        exporting: {
                            enabled: false
                        }
                    };
                    var options_neworexisting = {

                        chart: {
                            renderTo: 'chart-dashboard-active-projects-neworexisting',
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: 'New or Existing'
                        },
                        tooltip: {
                            pointFormat: '<b>{point.y} projects</b>'

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
                            name: 'New or Existing',
                            colorByPoint: true,
                            data: noecount
                        }],
                        exporting: {
                            enabled: false
                        }
                    };





                    var chart_category = new Highcharts.chart(options);
                    var chart_projectlead = new Highcharts.chart(options_projectlead);
                    var chart_domesticorinternational = new Highcharts.chart(options_domesticorinternational);
                    var chart_neworexisting = new Highcharts.chart(options_neworexisting);


                    $(".active-projects-total").html(categories.length);

                    $('.active-projects .change-chart').click(function() {
                        var catChangeData = [];
                        var leadChangeData = [];
                        var doiChangeData = [];
                        var noeChangeData = [];

                        var categoriesChange = [];
                        var leadsChange = [];
                        var doiChange = [];
                        var noeChange = [];

                        var catUniqueChange = [];
                        var leadUniqueChange = [];
                        var doiUniqueChange = [];
                        var noeUniqueChange = [];

                        var changeto = $(this).data('id');
                        var changecat = $(this).data('category');

                        var activeDate = $(".active-projects .filters.date").data("active-date");


                        if (changecat == "*") {
                            for (i = 0; i < jsondata.length; i++) {
                                if (jsondata[i].reportdate == activeDate) {
                                    categoriesChange.push(jsondata[i].category);
                                    leadsChange.push(jsondata[i].projectlead);
                                    doiChange.push(jsondata[i].domesticorinternational);
                                    noeChange.push(jsondata[i].neworexisting);
                                }
                            }
                            $("#active-projects").data("active-filter", "*").attr("data-active-filter", "*");
                            $("#active-projects").data("active-filter-type", "*").attr("data-active-filter-type", "*");
                        } else if (changecat == "reportdate") {
                            if ($("#active-projects").data("active-filter") != "*") {
                                var activeFilter = $("#active-projects").data("active-filter");
                                var activeFilterCat = $("#active-projects").data("active-filter-type");
                                for (i = 0; i < jsondata.length; i++) {
                                    if ((jsondata[i][activeFilterCat] == activeFilter) && (jsondata[i].reportdate == changeto)) {
                                        categoriesChange.push(jsondata[i].category);
                                        leadsChange.push(jsondata[i].projectlead);
                                        doiChange.push(jsondata[i].domesticorinternational);
                                        noeChange.push(jsondata[i].neworexisting);
                                    }
                                }
                            } else {
                                for (i = 0; i < jsondata.length; i++) {
                                    if (jsondata[i].reportdate == changeto) {
                                        categoriesChange.push(jsondata[i].category);
                                        leadsChange.push(jsondata[i].projectlead);
                                        doiChange.push(jsondata[i].domesticorinternational);
                                        noeChange.push(jsondata[i].neworexisting);
                                    }
                                }
                            }
                        } else {
                            for (i = 0; i < jsondata.length; i++) {
                                if ((jsondata[i][changecat] == changeto) && (jsondata[i].reportdate == activeDate)) {
                                    categoriesChange.push(jsondata[i].category);
                                    leadsChange.push(jsondata[i].projectlead);
                                    doiChange.push(jsondata[i].domesticorinternational);
                                    noeChange.push(jsondata[i].neworexisting);
                                }
                            }
                            $("#active-projects").data("active-filter", changeto).attr("data-active-filter", changeto);
                            $("#active-projects").data("active-filter-type", changecat).attr("data-active-filter-type", changecat);
                        }


                        catUniqueChange = totalcategories.unique2();
                        leadUniqueChange = totalleads.unique2();
                        doiUniqueChange = totaldoi.unique2();
                        noeUniqueChange = totalnoe.unique2();

                        for (i = 0; i < catUniqueChange.length; i++) {
                            target = catUniqueChange[i];
                            var numOccurences = $.grep(categoriesChange, function(elem) {
                                return elem === target;
                            }).length;
                            catChangeData.push({
                                y: numOccurences,
                                name: catUniqueChange[i]
                            });

                        }
                        for (i = 0; i < leadUniqueChange.length; i++) {
                            target = leadUniqueChange[i];
                            var numOccurences = $.grep(leadsChange, function(elem) {
                                return elem === target;
                            }).length;
                            leadChangeData.push({
                                y: numOccurences,
                                name: leadUniqueChange[i]
                            });

                        }
                        for (i = 0; i < doiUniqueChange.length; i++) {
                            target = doiUniqueChange[i];
                            var numOccurences = $.grep(doiChange, function(elem) {
                                return elem === target;
                            }).length;
                            doiChangeData.push({
                                y: numOccurences,
                                name: doiUniqueChange[i]
                            });

                        }
                        for (i = 0; i < noeUniqueChange.length; i++) {
                            target = noeUniqueChange[i];
                            var numOccurences = $.grep(noeChange, function(elem) {
                                return elem === target;
                            }).length;
                            noeChangeData.push({
                                y: numOccurences,
                                name: noeUniqueChange[i]
                            });

                        }
                        var title = changecat;

                        chart_category.series[0].setData(catChangeData);
                        chart_projectlead.series[0].setData(leadChangeData);
                        chart_neworexisting.series[0].setData(noeChangeData);
                        chart_domesticorinternational.series[0].setData(doiChangeData);

                        // change button


                        if (changecat == "reportdate") {
                            var dateName = $(this).data("datename");
                            $(this).closest(".btn-group").find(".active-item").html(dateName);
                            $(".active-projects .filters.date").attr("data-active-date", changeto).data("active-date", changeto);
                            $(".active-projects-date").html(dateName);
                            $(".active-projects-total").html(categoriesChange.length);
                        } else if (changecat == "*") {
                            $(".btn-group").not(".date").each(function() {
                                var resetText = $(this).find(".active-item").data("default");
                                $(this).find(".active-item").removeClass("active").html(resetText);
                            });
                            $(this).closest(".btn-group").find(".active-item").html(changeto);
                            $(".active-projects-total").html(categoriesChange.length);


                        } else {
                            $(".btn-group").not(".date").each(function() {
                                var resetText = $(this).find(".active-item").data("default");
                                $(this).find(".active-item").removeClass("active").html(resetText);
                            });
                            $(this).closest(".btn-group").find(".active-item").addClass("active").html(changeto);
                            $(".active-projects-total").html(categoriesChange.length);

                        }

                        if ($("#active-projects").data("active-filter") != "*") {
                            $(".active-projects-filtered").html("matching '" + $('#active-projects').data('active-filter') + "'");

                        } else {
                            $(".active-projects-filtered").html("");
                        }

                    });




                });
            });
        </script>

    </div>

</section>