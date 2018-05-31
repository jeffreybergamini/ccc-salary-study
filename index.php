<?php
class MyDB extends SQLite3 {
  function __construct() {
    $this->open('salary-data.sqlite');
  }
}

$reports = array(
  array(
    'description' => "Full-Time Salaries, Master's Degree, Step 1",
    'query' => "select district.district, ft_salary.salary from district natural join ft_salary where ft_salary.ma_plus = 0 and step = 1 group by district.district order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'description' => "Full-Time Salaries, Master's Degree, Step 6",
    'query' => "select district.district, ft_salary.salary from district natural join ft_salary where ft_salary.ma_plus = 0 and step = 6 group by district.district order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'description' => "Full-Time Salaries, Master's Degree + 30 Units, Step 11",
    'query' => "select district.district, ft_salary.salary from district natural join ft_salary where ft_salary.ma_plus = 30 and step = 11 group by district.district order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'description' => "Full-Time Salaries, Master's Degree + 60 Units, Step 21",
    'query' => "select district.district, ft_salary.salary from district natural join ft_salary where ft_salary.ma_plus = 60 and step = 21 group by district.district order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'description' => "Full-Time Salaries, PhD, Maximum Salary",
    'query' => "select district.district, ft_salary.salary from district natural join ft_salary where ft_salary.ma_plus = 100 group by district.district order by salary desc;",
    'key' =>  'salary',
    'keydescription' => 'Full-Time Salary',
    'type' => 'dollars'
  ),
  array(
    'description' => "Part-Time Hourly Rates, Master's Degree, Step 1",
    'query' => "select district.district, pt_salary.hourly from district natural join pt_salary where pt_salary.ma_plus = 0 and step = 1 group by district.district order by salary desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'description' => "Part-Time Hourly Rates, Master's Degree, Step 5",
    'query' => "select district.district, pt_salary.hourly from district natural join pt_salary where pt_salary.ma_plus = 0 and step = 5 group by district.district order by salary desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'description' => "Part-Time Hourly Rates, Master's Degree + 30 Units, Step 10",
    'query' => "select district.district, pt_salary.hourly from district natural join pt_salary where pt_salary.ma_plus = 30 and step = 10 group by district.district order by salary desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'description' => "Part-Time Hourly Rates, Maximum Without PhD",
    'query' => "select district.district, pt_salary.hourly from district natural join pt_salary where pt_salary.ma_plus = 60 group by district.district order by salary desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'description' => "Part-Time Hourly Rates, Maximum With PhD",
    'query' => "select district.district, pt_salary.hourly from district natural join pt_salary where pt_salary.ma_plus = 100 group by district.district order by salary desc;",
    'key' =>  'hourly',
    'keydescription' => 'Part-Time Hourly Rate',
    'type' => 'dollars'
  ),
  array(
    'description' => "PT/FT Pro Rata, Master's Degree, Step 1",
    'query' => "select district.district, ROUND(pt_salary.hourly / ft_salary.hourly, 3) as pro_rata from district join ft_salary on ft_salary.district = district.district and ft_salary.ma_plus = 0 and ft_salary.step = 1 join pt_salary on pt_salary.district = district.district and pt_salary.ma_plus = 0 and pt_salary.step = 1 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'description' => "PT/FT Pro Rata, Master's Degree, Steps 5 (PT) 6 (FT)",
    'query' => "select district.district, ROUND(pt_salary.hourly / ft_salary.hourly, 3) as pro_rata from district join ft_salary on ft_salary.district = district.district and ft_salary.ma_plus = 0 and ft_salary.step = 6 join pt_salary on pt_salary.district = district.district and pt_salary.ma_plus = 0 and pt_salary.step = 5 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'description' => "PT/FT Pro Rata, Master's Degree + 30 Units, Steps 10 (PT) 11 (FT)",
    'query' => "select district.district, ROUND(pt_salary.hourly / ft_salary.hourly, 3) as pro_rata from district join ft_salary on ft_salary.district = district.district and ft_salary.ma_plus = 30 and ft_salary.step = 11 join pt_salary on pt_salary.district = district.district and pt_salary.ma_plus = 30 and pt_salary.step = 10 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'description' => "PT/FT Pro Rata, PhD, Maximum Salary",
    'query' => "select district.district, ROUND(pt_salary.hourly / ft_salary.hourly, 3) as pro_rata from district join ft_salary on ft_salary.district = district.district and ft_salary.ma_plus = 100 join pt_salary on pt_salary.district = district.district and pt_salary.ma_plus = 100 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'Pro Rata',
    'type' => 'percentage'
  ),
  array(
    'description' => "FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius), Master's Degree, Step 1",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 1 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'description' => "FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius), Master's Degree, Step 6",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 6 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'description' => "FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius), Master's Degree + 30 Units, Step 11",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 30 and step = 11 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'description' => "FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius), Master's Degree + 60 Units, Step 21",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 60 and step = 21 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'description' => "FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius), PhD, Maximum Salary",
    'query' => "select district.district, ft_salary.salary / avg(qinc) as pro_rata from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 100 group by district.district order by pro_rata desc;",
    'key' =>  'pro_rata',
    'keydescription' => 'FT/Median-Home-Price Pro Rata (Zillow Home Value Index, 70 km radius)',
    'type' => 'percentage'
  ),
  array(
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree, Step 1",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 1 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree, Step 6",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 00 and step = 6 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree + 30 Units, Step 11",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 30 and step = 11 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), Master's Degree + 60 Units, Step 21",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 60 and step = 21 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
  array(
    'description' => "Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius), PhD, Maximum Salary",
    'query' => "select district.district, round(1.0 / (ft_salary.salary / avg(qinc)), 2) as incomes from district natural join ft_salary join zip_distance on zip_distance.src = district.zip and distance < 70 join home_value on home_value.zip = zip_distance.dst where ft_salary.ma_plus = 100 group by district.district order by incomes desc;",
    'key' =>  'incomes',
    'keydescription' => 'Number of Full-Time Faculty Salaries to Qualify for a Loan on a Median-Priced Local Home (Zillow Home Value Index, 70 km radius)'
  ),
);

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
    <title>CCC Salary Study - Jeffrey Bergamini, Cabrillo College</title>
    <link rel="stylesheet" href="style.css">
  </head>
<body>
<header>
<form action="#" method="GET">
<h3>CCC Salary Study - <a href="/">Jeffrey Bergamini</a> - <a href="https://www.cabrillo.edu">Cabrillo College</a></h3>
<?php
for ($i = 0; $i < count($reports); ++$i) {
  $desc = $reports[$i]['description'];
  $style = '';
  if ($i == $_GET['report'])
    $style = " class='active-button'";
  echo "<button type='submit' name='report' value='$i'$style>$desc</button>";
}
?>
</form>
</footer>
<hr>
<?php
if (isset($report)) {
?>
  <h2><?=$report['description']?></h2>
  <table>
  <tr><th>Rank</th><th>District</th><th><?=(isset($report) ? $report['keydescription'] : 'TBD')?></th></tr>
  <?php
  $numRows = count($results);
  for ($i = 0; $i < $numRows; ++$i) {
    $bgColor = 'rgb('
      .round((floatval($i)/$numRows) * 256)
      .','
      .round((1-(floatval($i)/$numRows)) * 256)
      .',0)';
    if ($results[$i]['district'] == 'Cabrillo')
      $style = " style='background: yellow; font-weight: bold'";
    else
      $style = '';
    echo "<tr$style><td>"
      .($i + 1).' ';
    if ($i == floor($numRows / 4))
      echo '(End of first quartile)';
    elseif ($i == intval($numRows / 2) or ($numRows % 2 == 0 and $i == $numRows / 2 or $i == $numRows / 2 - 1))
      echo '(Median)';
    if ($i == floor($numRows * 3 / 4))
      echo '(End of third quartile)';
    echo '</td><td>'.$results[$i]['district'].'</td><td>';
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
<hr>
<?php
}
?>
<footer>
Notes:
<ul>
<li>Salary data courtesy Joanna Valentine at CFT, and is currently based on 2016-2017 salary schedules.</li>
<li>Home loan qualification based the <a href="https://www.nar.realtor/research-and-statistics/housing-statistics/housing-affordability-index/methodology">National Association of Realtors's housing affordability index</a>, with home values pulled from the <a href="https://www.zillow.com/research/data/">Zillow Home Value index</a>. Assumed interest rate is 4.5%.</li>
<li>Per CFT's data: <i>Full-time faculty were assumed to receive 75% of their annual salary for prep &amp; grading only (no office hours, no governance work) 30 hours/40 hours = .75.</i> Some part-time rates (including Cabrillo) included office hours, according to CFT's reports.</li>
<li>Median home price and radius is calculated as follows: The centroid of a district's main ZIP code is considered the center point, and all other ZIP codes with centroids within the stated radius are also included in the calculuations. The price used here is the average of the Zillow Home Value index in those ZIP codes.</li>
<li>Source code and data <a href="https://github.com/jeffreybergamini/ccc-salary-study">available on GitHub</a>.</li>
</ul>
</footer>
</body>
</html>
