<?php
// Read JSON file contents
$fileContents = file_get_contents('results.json');
// Decode JSON data into an associative array
$data = json_decode($fileContents, true);

// Initialize an empty array to store sequence scores
$sequenceScores = [];

// Iterate over each entry in the JSON data
foreach ($data as $key => $entry) {
    // Check if the entry has both 'score' and 'list' keys
    if (isset($entry['score']) && isset($entry['list'])) {
        // Create a new sequence with a unique name
        $sequenceName = 'Test ' . ($key + 1); // Naming starts from Test 1
        // Assign 'data' and 'score' to the new sequence
        $sequenceScores[$sequenceName] = [
            'data' => $entry['list'],
            'score' => $entry['score']
        ];
    }
}

// Preparing matches and durations for the Scatter Plot
$matches = [];
$durations = [];
foreach ($sequenceScores as $sequence) {
    $duration = rand(1, 100);  // Simulate a duration for the sequence
    foreach ($sequence['data'] as $index => $item) {
        if ($item === 'Match' || (is_array($item) && in_array('Pitch Match', $item))) {
            $matches[] = $index;  // Index as x-coordinate
            $durations[] = $duration;  // Simulated duration as y-coordinate
        }
    }
}

$counts = [
    'Match' => 0,
    'No Match' => 0,
    'Sliding' => 0,
    'Dur. Mismatch' => 0
];

// Process data for visualization and update counts
foreach ($sequenceScores as $sequence) {
    foreach ($sequence['data'] as $item) {
        if (is_array($item)) {
            if (in_array('Pitch Match', $item)) {
                $counts['Match']++;
            }
            if (in_array('Dur. Mismatch', $item)) {
                $counts['Dur. Mismatch']++;
            }
        } else {
            $counts[$item]++;
        }
    }
}

// Prepare data points for line chart showing cumulative matches over time
$dataPoints = [];
$sumMatches = 0;
foreach ($sequenceScores as $sequence) {
    foreach ($sequence['data'] as $item) {
        if ($item === 'Match' || (is_array($item) && in_array('Pitch Match', $item))) {
            $sumMatches++;
        }
        $dataPoints[] = $sumMatches;
    }
}

// Calculate Histogram data for durations
$bins = array_fill(0, 10, 0);  // 10 bins for example
foreach ($durations as $duration) {
    $index = floor($duration / 10);  // Determine the bin index
    if ($index < 10) {
        $bins[$index]++;
    }
    // echo "Duration: $duration, Bin Index: $index\n";

}
// var_export($durations);
// var_export($bins);

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
            <?php foreach ($sequenceScores as $sequenceName => $sequence): ?>
            <!-- Bar Chart Placeholder -->
            <div class="col-md-12">
                <div class="portlet box purple">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bar-chart"></i> Bar Chart for <?php echo $sequenceName; ?> Match Count
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="bar_chart_<?php echo str_replace(' ', '_', strtolower($sequenceName)); ?>" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

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
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>
<!-- END CONTENT -->
<script src="https://cdn.jsdelivr.net/npm/jquery"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.flot"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/4.2.6/jquery.flot.categories.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/choir/node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>

<?php foreach ($sequenceScores as $sequenceName => $sequence): ?>
<script>
jQuery(document).ready(function() {
    function updateBarChart_<?php echo str_replace(' ', '_', strtolower($sequenceName)); ?>() {
        var barData = [
            { label: "Match", data: [[1, <?php echo $counts['Match']; ?>]], color: "#8A2BE2" },
            { label: "No Match", data: [[2, <?php echo $counts['No Match']; ?>]], color: "#DA70D6" },
            { label: "Sliding", data: [[3, <?php echo $counts['Sliding']; ?>]], color: "#9370DB" },
            { label: "Duration Mismatch", data: [[4, <?php echo $counts['Dur. Mismatch']; ?>]], color: "#D8BFD8" }
        ];

        var options = {
            series: {
                bars: { show: true, barWidth: 0.5, align: 'center' }
            },
            xaxis: { mode: 'categories', tickLength: 0 },
            yaxis: {},
            grid: { hoverable: true, clickable: true, borderWidth: 1, borderColor: '#ccc' },
            legend: { show: true, position: "ne" }
        };

        $.plot('#bar_chart_<?php echo str_replace(' ', '_', strtolower($sequenceName)); ?>', barData, options);
    }

    updateBarChart_<?php echo str_replace(' ', '_', strtolower($sequenceName)); ?>();
});
</script>
<?php endforeach; ?>

<script>
jQuery(document).ready(function() {
    function updatePieChart() {
        var data = {
            labels: ['Match', 'No Match', 'Sliding', 'Duration Mismatch'],
            datasets: [{
                data: [<?php echo $counts['Match']; ?>, <?php echo $counts['No Match']; ?>, <?php echo $counts['Sliding']; ?>, <?php echo $counts['Dur. Mismatch']; ?>],
                backgroundColor: ['#8D83BF', '#B9ADD5', '#dcd4e9', '#693b69'],
                borderColor: ['#8D83BF', '#B9ADD5', '#dcd4e9', '#693b69'],
                borderWidth: 1
            }]
        };

        var ctx = document.getElementById('pie_chart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: false,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Match Distribution'
                },
                plugins: {
                    datalabels: {
                        display: true,
                        formatter: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        });
    }
    updatePieChart();
});
</script>

<script>
    jQuery(document).ready(function() {
        function updateLineChart() {
            // Data points for the line chart
            var dataPoints = <?php echo json_encode($dataPoints); ?>;
            // Prepare the data in the format required by Flot
            var data = [{
                label: "Match Count Over Time",
                data: dataPoints.map(function(value, index) {
                    return [index + 1, value]; // Assuming time starts from 1
                }),
                color: "#8A2BE2"
            }];
            // Options for the line chart
            var options = {
                series: {
                    lines: { show: true, fill: true },
                    points: { show: true }
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
                    label: "Time"
                },
                yaxis: {
                    min: 0,
                    tickSize: 1,
                    label: "Matches"
                },
                legend: {
                    show: true
                }
            };
            // Plot the line chart
            $.plot("#line_chart", data, options);
        }
        // Call the function to update the line chart
        updateLineChart();
    });
</script>

<!-- JavaScript code to generate the bar chart using Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Retrieve data for scores across sequences
    var sequenceScores = <?php echo json_encode($sequenceScores); ?>;

    // Extract sequence names and scores
    var sequenceNames = Object.keys(sequenceScores);
    var scores = sequenceNames.map(function(sequenceName) {
        return sequenceScores[sequenceName].score;
    });

    // Set up the bar chart data
    var barChartData = {
        labels: sequenceNames, // Sequence names as labels
        datasets: [{
            label: 'Scores',
            backgroundColor: '#693b69', // Blue color with opacity
            borderColor: '#693b69',
            borderWidth: 1,
            data: scores // Scores as data points
        }]
    };

    // Set up options for the bar chart
    var barChartOptions = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true // Start y-axis from 0
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Score' // Y-axis label
                }
            }],
            xAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'Test' // X-axis label
                }
            }]
        },
        legend: {
            display: false // Hide legend
        }
    };

    // Get the canvas element
    var ctx = document.getElementById('scoresChart').getContext('2d');

    // Create the bar chart
    var scoresChart = new Chart(ctx, {
        type: 'bar', // Bar chart type
        data: barChartData,
        options: barChartOptions
    });
</script>
