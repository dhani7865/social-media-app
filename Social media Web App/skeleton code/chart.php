<?php
// executing the header.php file
require_once "header.php";
?>
<!DOCTYPE html>
<html>
    <h1>CHART</h1>

<body>
<!--- Adding stylesheet --->
<style>
<?php
include 'stylesheet.css';
?>
</style>
<!-- Code originates from the "Controls and Dashboards" docs: https://developers.google.com/chart/interactive/docs/gallery/controls -->

    <!--Loading the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Loading the Visualization API and the controls package.
      google.charts.load('current', {'packages':['corechart', 'controls']});

      // Setting up a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawDashboard);

      // Callback that creates and populates a data table,
      // instantiates a dashboard, a range slider and a pie chart,
      // passes in the data and draws it.
        // function to draw the dashboard
      function drawDashboard() {

        // Create the data table for username and likes
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn('string', 'Username');
        dataTable.addColumn('number', 'Likes');
        // A column for custom tooltip content
        dataTable.addColumn({type: 'string', role: 'tooltip'});
        dataTable.addRows([['a', 1, 'Message: 1'],['b', 2, 'Message: 2'],['barryg', 4, 'Message: 4'],['brianm', 1, 'Message: 1'],['c', 3, 'Message: 3'],['d', 1, 'Message: 1'],['dhani123', 1, 'Message: 1'],['dhanyaal123', 1, 'Message: 1'],['mandyb', 3, 'Message: 3'], ['mathman', 3, 'Message: 3'], ]);
        
        // Creating a dashboard for the chart
        var dashboard = new google.visualization.Dashboard(
            document.getElementById('dashboard_div'));

        // Creating a range slider, passing some options
        var donutRangeSlider = new google.visualization.ControlWrapper({
          'controlType': 'NumberRangeFilter',
          'containerId': 'filter_div',
          'options': {
            'filterColumnLabel': 'Likes'
          } // close var for donutRangeSlider
        });

        // Creating a pie chart and passing some options
        var pieChart = new google.visualization.ChartWrapper({
          'chartType': 'PieChart',
          'containerId': 'chart_div',
          'options': {
            'title': 'Number of Likes for each Username',
            'pieSliceText': 'value',
            'legend': 'right'
          }
        });

        // Establish dependencies, declaring that 'filter' drives 'pieChart',
        // so that the pie chart will only display entries that are let through
        // given the chosen slider range.
        dashboard.bind(donutRangeSlider, pieChart);
        
        // Drawing the dashboard.
        dashboard.draw(dataTable);
      } // close function for draw dashboard
    </script>

    <!--Div that will hold the dashboard-->
    <div id="dashboard_div" style="width:100%;">
      <!--Divs that will hold each control and chart - set to fit the page -->
      <div id="filter_div" style="width:100%;"></div>
      <div id="chart_div" style="width:100%;"></div>
    </div>
    
    <!-- paragraph to hold the usernames we have filtered -->
    <p id="username"></p>
    <br>
&copy;6G5Z2107
</body>
</html>