<?php

// Define the sequence array
$sequence = [
    ['No Match', 'Sliding', ['Pitch Match', 'Duration Mismatch'], 'Match', 'Match'],
    ['Pitch Match', 'Duration Mismatch'], 'Match', 'No Match',
    ['Pitch Match', 'Duration Mismatch'], 'Sliding',
    ['Pitch Match', 'Duration Mismatch'], 'Match', 'No Match',
    ['Pitch Match', 'Duration Mismatch'], 'Match', 'Match', 'Match'
];

// Initialize counters
$counts = [
    'Match' => 0,
    'No Match' => 0,
    'Sliding' => 0,
    'Duration Mismatch' => 0
];

// Dummy durations and match counts
$durations = [];
$matches = [];
foreach ($sequence as $index => $item) {
    $durations[] = rand(1, 100);  // Random duration between 1 and 100
    if ($item === 'Match' || (is_array($item) && in_array('Pitch Match', $item))) {
        $matches[] = ['x' => $index, 'y' => $durations[$index]];
    }
}

// Calculate counts
foreach ($sequence as $item) {
    if (is_array($item)) {
        $counts['Duration Mismatch']++;
    } elseif ($item === 'Match') {
        $counts['Match']++;
    } elseif ($item === 'No Match') {
        $counts['No Match']++;
    } elseif ($item === 'Sliding') {
        $counts['Sliding']++;
    }
}

// Prepare data points for Flot
$dataPoints = [];
$currentMatches = 0;
foreach ($sequence as $index => $item) {
    if ($item === 'Match') {
        $currentMatches++;
    }
    $dataPoints[] = [$index, $currentMatches];
}

// Initialize counters
$matchCount = 0;
$mismatchCount = 0;

// Calculate counts
foreach ($sequence as $item) {
    if (is_array($item)) {
        // Assuming 'Pitch Match', 'Duration Mismatch' is a type of match for simplicity
        $matchCount++;
    } elseif ($item === 'Match') {
        $matchCount++;
    } elseif ($item === 'No Match') {
        $mismatchCount++;
    }
}
$matchCount = count(array_filter($sequence, function($item) {
    return $item === 'Match' || (is_array($item) && in_array('Pitch Match', $item));
}));

// Data for Flot
$flotData = [
    ["label" => "Matches", "data" => $matchCount, "color" => "#00FF00"],
    ["label" => "Mismatches", "data" => $mismatchCount, "color" => "#FF0000"]
];

$matches = array_map(function ($match) {
    return [$match['x'], $match['y']];
}, $matches);

?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <?php echo lang('sub_set_optional'); ?>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>Home
                    </li>
                    <li>
                        <?php echo lang('sub_song'); ?>
                    </li>
                    <li>
                        <?php echo lang('header_ass_opt_sub'); ?>
                    </li>
                    <li id="result" class="pull-right topClock"></li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <!-- Bar Chart Placeholder -->
            <div class="col-md-12">
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bar-chart"></i> Bar Chart for Match Count
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="bar_chart" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart Placeholder -->
            <div class="col-md-12">
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-pie-chart"></i> Pie Chart for Match Distribution
                        </div>
                    </div>
                    <div class="portlet-body">
                    <canvas id="pie_chart" style="max-width:400px; max-height:400px;"></canvas>

                    </div>
                </div>
            </div>

            <!-- Line Chart Placeholder -->
            <div class="col-md-12">
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-line-chart"></i> Line Chart for Match Proportion Over Time
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="line_chart" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>

            <!-- Stacked Bar Chart Placeholder -->
          

              <!--  Bar Chart Placeholder -->
             <!-- Bar Chart Placeholder -->
                <div class="col-md-12">
                    <div class="portlet box purple" style="background-color: white;">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bars"></i> Bar Chart for scores across sequences
                            </div>
                        </div>
                        <div class="portlet-body">
                            <canvas id="scoresChart"></canvas>
                        </div>
                    </div>
                </div>


            <!-- Scatter Plot Placeholder -->
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-scatter-plot"></i> Scatter Plot for Matches vs. Duration
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="scatter_plot" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-scatter-plot"></i> Histogram Plot for Sequence Duration
                        </div>
                    </div>
                    <div class="portlet-body">
                    <div id="histogram" style="width:600px;height:300px;"></div>

                    </div>
                </div>
            </div>


        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->

<script src="https://cdn.jsdelivr.net/npm/jquery"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.flot"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/4.2.6/jquery.flot.categories.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="pie_chart"></canvas>




<script>  
 function updateBarChart() {
    var barData = [
    {
        label: "Match",
        data: [ [1, <?php echo $counts['Match']; ?>] ],
        color: "#8A2BE2"  // A shade of purple
    },
    {
        label: "No Match",
        data: [ [2, <?php echo $counts['No Match']; ?>] ],
        color: "#DA70D6"  // Another shade of purple
    },
    {
        label: "Sliding",
        data: [ [3, <?php echo $counts['Sliding']; ?>] ],
        color: "#9370DB"  // Another shade of purple
    },
    {
        label: "Duration Mismatch",
        data: [ [4, <?php echo $counts['Duration Mismatch']; ?>] ],
        color: "#D8BFD8"  // Another shade of purple
    }
];

var options = {
    series: {
        bars: {
            show: true,
            barWidth: 0.5,
            align: 'center'
        }
    },
    xaxis: {
        mode: 'categories',
        tickLength: 0,
        label: "Types" // Label for the x-axis
    },
    yaxis: {
        label: "Count" // Label for the y-axis
    },
    grid: {
        hoverable: true,
        clickable: true,
        borderWidth: 1,
        borderColor: '#ccc'
    },
    legend: {
        show: true,
        position: "ne" // Legend at the top right corner
    }
};

$.plot('#bar_chart', barData, options);

}

$(document).ready(function() {
    updateBarChart(); // This calls the function after the document is ready
});

</script>
<script>
jQuery(document).ready(function() {
    function updatePieChart() {
        var data = {
    labels: ['Match', 'No Match', 'Sliding', 'Duration Mismatch'],
    datasets: [{
        data: [<?php echo $counts['Match']; ?>, <?php echo $counts['No Match']; ?>, <?php echo $counts['Sliding']; ?>, <?php echo $counts['Duration Mismatch']; ?>],
        backgroundColor: ['#8A2BE2', '#DA70D6', '#9370DB', '#D8BFD8'], // Shades of purple
        borderColor: ['#8A2BE2', '#DA70D6', '#9370DB', '#D8BFD8'],
        borderWidth: 1
    }]
};

        var ctx = document.getElementById('pie_chart').getContext('2d');
        var pieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Match Distribution'
        },
        tooltips: { // Enabling tooltips
            enabled: true
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
});
    }
    updatePieChart();
});
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
    function updateGraph() {
        // Fetch new data periodically (simulation here; replace with AJAX call in production)
        var data = [
    {
        label: "Match Count Over Time",
        data: <?php echo json_encode($dataPoints); ?>,
        lines: { show: true, fill: false },
        color: "#8A2BE2"  // Purple color
    }
];


     // Inside your existing updateGraph function
var options = {
    series: {
        lines: {
            show: true,
            fill: true
        },
        points: {
            show: true
        }
    },
    grid: {
        hoverable: true,
        clickable: true,
        borderWidth: 1,
        borderColor: '#ccc'
    },
    xaxis: {
        tickDecimals: 0,
        tickSize: 1,
        label: "Time" // Label for the x-axis
    },
    yaxis: {
        min: 0,
        tickSize: 1,
        label: "Matches" // Label for the y-axis
    },
    legend: {
        show: true
    }
};
$.plot("#line_chart", data, options);


        // Tooltips setup
        $('<div id="tooltip"></div>').css({
            position: "absolute",
            display: "none",
            border: "1px solid #fdd",
            padding: "2px",
            "background-color": "#fee",
            opacity: 0.80
        }).appendTo("body");

        $("#matchTimeGraph").bind("plothover", function (event, pos, item) {
            if (item) {
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);

                $("#tooltip").html("Match at " + x + ": " + y)
                    .css({top: item.pageY+5, left: item.pageX+5})
                    .fadeIn(200);
            } else {
                $("#tooltip").hide();
            }
        });
    }

    // Initial graph load
    updateGraph();

    // Optional: Update graph data periodically
    setInterval(function() {
        updateGraph(); // Redraw the graph with potentially new data
    }, 10000); // Update every 10 seconds
});
</script>
<?php

// Parse sequences and count types for each sequence
$typeCounts = [];
$scores = [];


// Convert PHP arrays to JavaScript arrays
$typeCountsJS = json_encode($typeCounts);
$scoresJS = json_encode($scores);
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script type="text/javascript">
jQuery(document).ready(function() {
    function updateScatterPlot() {
        
        // Simulated data; replace with AJAX call in production to fetch real-time data
        var scatterData = [
    {
        label: "Matches vs Duration",
        data: <?php echo json_encode($matches); ?>,
        points: { show: true },
        color: "#9370DB"  // Purple color
    }
];



        // Initialize the scatter plot
        $.plot("#scatter_plot", scatterData, {
            series: {
                lines: { show: false },
                points: { show: true, radius: 3 }
            },
            grid: {
                hoverable: true,
                clickable: true,
                borderWidth: 1,
                borderColor: '#ccc'
            },
            xaxis: {
                tickDecimals: 0,
                tickSize: 1
            },
            yaxis: {
                min: 0
            }
        });

        // Tooltips setup
        $('<div id="tooltip"></div>').css({
            position: "absolute",
            display: "none",
            border: "1px solid #fdd",
            padding: "2px",
            "background-color": "#fee",
            opacity: 0.80
        }).appendTo("body");

        $("#scatter_plot").bind("plothover", function(event, pos, item) {
            if (item) {
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);

                $("#tooltip").html(item.series.label + " at " + x + ": " + y)
                    .css({top: item.pageY+5, left: item.pageX+5})
                    .fadeIn(200);
            } else {
                $("#tooltip").hide();
            }
        });
    }

    // Initial chart load
    updateScatterPlot();

    // Optional: Update chart data periodically
    setInterval(function() {
        updateScatterPlot(); // Redraw the graph with potentially new data
    }, 10000); // Update every 10 seconds, adjust timing as needed
});
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
    function updateHistogram(sequenceDurations) {
        var histogramData = [];
        var binSize = 10; // This value can be adjusted as needed for your histogram resolution
        var maxDuration = Math.max.apply(null, sequenceDurations);
        var numBins = Math.ceil(maxDuration / binSize);
        var bins = new Array(numBins).fill(0);

        sequenceDurations.forEach(function(duration) {
            var binIndex = Math.floor(duration / binSize);
            bins[binIndex]++;
        });

        bins.forEach(function(count, index) {
            if (count > 0) {
                histogramData.push([index * binSize + binSize / 2, count]); // Center the bar
            }
        });

       // Inside your existing updateHistogram function
var options = {
    series: {
        bars: {
            show: true,
            align: 'center'
        }
    },
    grid: {
        hoverable: true,
        borderWidth: 1,
        borderColor: '#ccc'
    },
    xaxis: {
        tickSize: binSize,
        min: 0,
        max: maxDuration + binSize,
        label: "Duration (units)" // Label for the x-axis
    },
    yaxis: {
        min: 0,
        label: "Frequency" // Label for the y-axis
    },
    legend: {
        show: true
    }
};
$.plot('#histogram', [{ data: histogramData, bars: { show: true, barWidth: binSize * 0.8, fillColor: "#D8BFD8" } }], options);

    }

    // Dummy data for sequence durations
    var sequenceDurations = [5, 20, 15, 10, 35, 25, 30, 40, 45, 10, 20, 25, 30, 50, 55, 60, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20];

    // Call the update function to display the histogram
    updateHistogram(sequenceDurations);
});
</script>
<?php
// Assuming you have your scores in an associative array format
$sequenceScores = [
    'Sequence 1' => 87,
    'Sequence 2' => 92,
    'Sequence 3' => 75
];

// Convert PHP array to JSON
$scoresJson = json_encode($sequenceScores);
?>

<script>
var scoresData = <?php echo $scoresJson; ?>;
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('scoresChart').getContext('2d');
    var scoresChart = new Chart(ctx, {
        type: 'bar',
        var data = {
    labels: Object.keys(scoresData), // Sequence names
    datasets: [{
        label: 'Scores',
        data: Object.values(scoresData), // Actual scores
        backgroundColor: [
            'rgba(148, 0, 211, 0.2)',  // A shade of purple
            'rgba(153, 50, 204, 0.2)', // Another shade of purple
            'rgba(186, 85, 211, 0.2)'  // Another shade of purple
        ],
        borderColor: [
            'rgba(148, 0, 211, 1)',  // Darker purple
            'rgba(153, 50, 204, 1)', // Darker purple
            'rgba(186, 85, 211, 1)'  // Darker purple
        ],
        borderWidth: 1
    }]
},
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        font: {
                            size: 14
                        }
                    }
                }
            },
            // Set the background color here
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            backgroundColor: 'white' // Here's the key to setting the background color
        }
    });
});
</script>
