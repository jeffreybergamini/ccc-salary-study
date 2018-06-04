<?php
session_start();
class MyDB extends SQLite3 {
  function __construct() {
    $this->open('salary-data.sqlite');
  }
}

$reports = array(
  array(
    'category' => 'Full-Time Salaries',
    'description' => "Full-Time Salaries, Master's Degree, Step 1",
    'query' => "select district, salary from ft_salary where ft_salary.ma_plus = 0 and step = 1 order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Full-Time Salaries',
    'description' => "Full-Time Salaries, Master's Degree, Step 6",
    'query' => "select district, salary from ft_salary where ft_salary.ma_plus = 0 and step = 6 order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Full-Time Salaries',
    'description' => "Full-Time Salaries, Master's Degree + 30 Units, Step 11",
    'query' => "select district, salary from ft_salary where ft_salary.ma_plus = 30 and step = 11 order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Full-Time Salaries',
    'description' => "Full-Time Salaries, Master's Degree + 60 Units, Step 21",
    'query' => "select district, salary from ft_salary where ft_salary.ma_plus = 60 and step = 21 order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Full-Time Salaries',
    'description' => "Full-Time Salaries, PhD, Maximum Salary",
    'query' => "select district, salary from ft_salary where ft_salary.ma_plus = 100 order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Part-Time Hourly Rates',
    'description' => "Part-Time Hourly Rates, Master's Degree, Step 1",
    'query' => "select district, hourly from pt_salary where ma_plus = 0 and step = 1 order by hourly desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Part-Time Hourly Rates',
    'description' => "Part-Time Hourly Rates, Master's Degree, Step 5",
    'query' => "select district, hourly from pt_salary where ma_plus = 0 and step = 5 order by hourly desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Part-Time Hourly Rates',
    'description' => "Part-Time Hourly Rates, Master's Degree + 30 Units, Step 10",
    'query' => "select district, hourly from pt_salary where ma_plus = 30 and step = 10 order by hourly desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Part-Time Hourly Rates',
    'description' => "Part-Time Hourly Rates, Maximum Without PhD",
    'query' => "select district, hourly from pt_salary where ma_plus = 60 order by hourly desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Part-Time Hourly Rates',
    'description' => "Part-Time Hourly Rates, Maximum With PhD",
    'query' => "select district, hourly from pt_salary where ma_plus = 100 order by hourly desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'category' => 'PT/FT Pro Rata',
    'description' => "PT/FT Pro Rata, Master's Degree, Step 1",
    'query' => "select ft_salary.district, pt_salary.hourly / ft_salary.hourly as pro_rata from ft_salary join pt_salary on pt_salary.district = ft_salary.district where ft_salary.ma_plus = 0 and ft_salary.step = 1 and pt_salary.ma_plus = 0 and pt_salary.step = 1 order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'category' => 'PT/FT Pro Rata',
    'description' => "PT/FT Pro Rata, Master's Degree, Steps 5 (PT) 6 (FT)",
    'query' => "select ft_salary.district, pt_salary.hourly / ft_salary.hourly as pro_rata from ft_salary join pt_salary on pt_salary.district = ft_salary.district where ft_salary.ma_plus = 0 and ft_salary.step = 6 and pt_salary.ma_plus = 0 and pt_salary.step = 5 order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'category' => 'PT/FT Pro Rata',
    'description' => "PT/FT Pro Rata, Master's Degree + 30 Units, Steps 10 (PT) 11 (FT)",
    'query' => "select ft_salary.district, pt_salary.hourly / ft_salary.hourly as pro_rata from ft_salary join pt_salary on pt_salary.district = ft_salary.district where ft_salary.ma_plus = 30 and ft_salary.step = 11 and pt_salary.ma_plus = 30 and pt_salary.step = 10 order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'category' => 'PT/FT Pro Rata',
    'description' => "PT/FT Pro Rata, PhD, Maximum Salary",
    'query' => "select ft_salary.district, pt_salary.hourly / ft_salary.hourly as pro_rata from ft_salary join pt_salary on pt_salary.district = ft_salary.district where ft_salary.ma_plus = 100 and pt_salary.ma_plus = 100 order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius), Master's Degree, Step 1",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 1 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius), Master's Degree, Step 6",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 6 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius), Master's Degree + 30 Units, Step 11",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 30 and step = 11 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius), Master's Degree + 60 Units, Step 21",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 60 and step = 21 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius), PhD, Maximum Salary",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 100 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Ratio (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree, Step 1",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 1 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree, Step 6",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 6 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree + 30 Units, Step 11",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 30 and step = 11 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree + 60 Units, Step 21",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 60 and step = 21 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'category' => 'FT Salary vs. Cost of Living',
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), PhD, Maximum Salary",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 100 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'category' => 'Overall Averages',
    'description' => "Average Full-Time Salary",
    'query' => "select district, avg(salary) as salary from ft_salary group by district order by avg(salary) desc;",
    'key' =>  'salary',
    'keydescription' => 'Average Full-Time Salary (all steps and education levels mentioned above)',
    'type' => 'dollars'
  ),
  array(
    'category' => 'Overall Averages',
    'description' => "Average Part-Time Hourly Rate",
    'query' => "select district, avg(hourly) as hourly from pt_salary group by district order by avg(hourly) desc;",
    'key' =>  'hourly',
    'keydescription' => 'Average Part-Time Hourly Rate (all steps and education levels mentioned above)',
    'type' => 'dollars'
  ),
);

if (isset($_GET['highlight'])) {
  $_SESSION['highlight'] = $_GET['highlight'];
  header('Location: '.$_SERVER['HTTP_REFERER']);
} elseif (!isset($_SESSION['highlight'])) {
  $_SESSION['highlight'] = 'Cabrillo';
}

if (isset($_GET['report'])
  and is_integer(intval($_GET['report']))
  and $_GET['report'] >= 0
  and $_GET['report'] < count($reports)) {

  $report = $reports[$_GET['report']];
  $db = new MyDB();
  $curStmt = $db->prepare($report['query']);
  $curRes = $curStmt->execute();
  $results = array();
  while ($entry = $curRes->fetchArray(SQLITE3_ASSOC)) {
    array_push($results, $entry);
  }
  $db->close();
} else {
  $results = array();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>California Community Colleges Salary Study - Jeffrey Bergamini - Cabrillo College</title>
    <link rel="stylesheet" href="style.css">
  </head>
<body>
<header>
<form action="." method="GET">
<h1><a href=".">California Community Colleges Salary Study</a> - <a href="/">Jeffrey Bergamini</a> - <a href="https://www.cabrillo.edu">Cabrillo College</a></h1>
<?php
$prevCategory = '';
for ($i = 0; $i < count($reports); ++$i) {
  if ($reports[$i]['category'] != $prevCategory) {
    if ($prevCategory != '')
      echo '</div>';
    echo '<div class="report-category">'.$reports[$i]['category'].': ';
  }
  $prevCategory = $reports[$i]['category'];
  $desc = $reports[$i]['description'];
  $style = '';
  if (isset($_GET['report']) and $i == $_GET['report'])
    $style = " class='active-button'";
  echo "<button type='submit' name='report' value='$i'$style>$desc</button>";
}
?>
</div>
</form>
<hr>
</header>
<?php
if (isset($report)) {
  $highlight = urldecode($_SESSION['highlight']);
?>
  <h1><?=$report['description']?></h1>
  <div id="percentile-gauge"></div>
  <table>
  <tr><th>Rank</th><th>Percentile</th><th>District</th><th><?=(isset($report) ? $report['keydescription'] : 'TBD')?></th></tr>
  <?php
  $numRows = count($results);
  for ($i = 0; $i < $numRows; ++$i) {
    $numBelow = 0;
    for ($j = 0; $j < $numRows; ++$j) {
      if ($results[$j][$report['key']] < $results[$i][$report['key']])
        ++$numBelow;
    }
    $percentile = round(100.0 * $numBelow / $numRows);
    $bgColor = 'rgb('
      .round((floatval($i)/$numRows) * 256)
      .','
      .round((1-(floatval($i)/$numRows)) * 256)
      .',0)';
    if ($results[$i]['district'] == $highlight) {
      echo "<tr class='highlight'><td>"
      .($i + 1).' ';
      $gaugePercentile = $percentile;
    } else {
      echo "<tr onclick='highlight(\"".$results[$i]['district']."\")'><td>"
      .($i + 1).' ';
    }
    if ($i == floor($numRows / 4))
      echo '(End of first quartile)';
    elseif ($i == intval($numRows / 2) or ($numRows % 2 == 0 and $i == $numRows / 2 or $i == $numRows / 2 - 1))
      echo '(Median)';
    if ($i == floor($numRows * 3 / 4))
      echo '(End of third quartile)';
    echo "<td>$percentile%</td>";
    echo '<td>'.$results[$i]['district'].'</td><td>';
    if ($report['type'] == 'percentage')
      echo number_format($results[$i][$report['key']] * 100, 2).'%';
    elseif ($report['type'] == 'dollars')
      echo '$' . number_format($results[$i][$report['key']]);
    elseif ($report['type'] == 'fractional')
      echo number_format($results[$i][$report['key']], 2);
    else
      echo $results[$i][$report['key']];
    echo '</td><td>';
    echo '</td></tr>';
  }
  ?>
</table>
<?php
}
?>
<footer>
<hr>
Notes:
<ul>
<li>Salary data courtesy Joanna Valentine at <a href="http://cft.org/">CFT</a>, and is currently based on 2016-2017 salary schedules.</li>
<li>Home loan qualification based on the <a href="https://www.nar.realtor/research-and-statistics/housing-statistics/housing-affordability-index/methodology">National Association of Realtors's qualifying income formula</a>, with home values pulled from the <a href="https://www.zillow.com/research/data/">Zillow Home Value index</a> (currently for April 2018). Assumed interest rate is 4.5%.</li>
<li>PT rates in relevant districts have been adjusted to incorporate additional pay for required office hours, assuming a maximum part-time workload (10 semester units).</li>
<li>PT/FT pro rata is computed using 100% of part-time rates and 87.5% of full-time rates, since all relevant PT rates have been adjusted to incorporate pay for required office hours but do not involve pay for governance etc., usually acknowledged to account for roughly 1/8 of full-time compensation.</li>
<li>Median home price and radius is calculated as follows: All ZIP codes with centroids no further than the stated radius from the centroid of any ZIP code in the district are included in the calculuations. The price used here is the average of the Zillow Home Value index in those ZIP codes.</li>
<li>Source code and data <a href="https://github.com/jeffreybergamini/ccc-salary-study">available on GitHub</a>.</li>
</ul>
</footer>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
function highlight(district) {
  window.location.replace('./?highlight='+district);
}

google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

  <?php if (!isset($highlight)) echo 'return;'; ?>

	var data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['<?=$highlight?>', <?=$gaugePercentile?>],
	]);

	var options = {
		width: 200, height: 200,
		min: 0, max: 99,
		minorTicks: 5
	};

	var chart = new google.visualization.Gauge(document.getElementById('percentile-gauge'));

	chart.draw(data, options);
}
</script>
</body>
</html>
