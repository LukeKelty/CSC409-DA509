<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<title>Meteorite Landings</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>

<img src=".." width="300" height="84" alt="NASA Logo??">

	<h1>Meteorite Landings</h1>

<p>Source: <a href="https://catalog.data.gov/dataset/meteorite-landings">Data.gov</a></p>



<?php
print ("<form method=\"post\" action=\"index.php\">\n<fieldset>\n");


/*Discovery filter*/
print ("</select><br>\n");
print("<label>Discovery</label><br>\n");
if(isset($_POST['Discovery']))
{
    if($_POST['Discovery'] == 'Both'){
      $filter_discovery = 'Discovery LIKE \'%\'';
      print("<input type=\"radio\" name=\"Discovery\" value=\"Fell\">Fell<br>\n");
      print("<input type=\"radio\" name=\"Discovery\" value=\"Found\">Found<br>\n");
      print("<input type=\"radio\" name=\"Discovery\" value=\"Both\" checked>Both<br>\n");
    }
    if($_POST['Discovery'] == 'Found')
  	{
  		$filter_discovery = 'Discovery LIKE \'Found\'';
      print("<input type=\"radio\" name=\"Discovery\" value=\"Fell\">Fell<br>\n");
      print("<input type=\"radio\" name=\"Discovery\" value=\"Found\" checked>Found<br>\n");
      print("<input type=\"radio\" name=\"Discovery\" value=\"Both\" >Both<br>\n");
  	}
  	if($_POST['Discovery'] == 'Fell')
  	{
  		$filter_discovery = 'Discovery LIKE \'Fell\'';
  		print("<input type=\"radio\" name=\"Discovery\" value=\"Fell\" checked>Fell<br>\n");
      print("<input type=\"radio\" name=\"Discovery\" value=\"Found\">Found<br>\n");
      print("<input type=\"radio\" name=\"Discovery\" value=\"Both\" >Both<br>\n");
  	}
}
else
{
	$filter_discovery = 'Discovery LIKE \'%\'';
	print("<input type=\"radio\" name=\"Discovery\" value=\"Fell\">Fell<br>\n");
  print("<input type=\"radio\" name=\"Discovery\" value=\"Found\">Found<br>\n");
  print("<input type=\"radio\" name=\"Discovery\" value=\"Both\" checked>Both<br>\n");
}

/*Year Filter*/
print("<label>Year</label><br>\n");
if(filter_var($_POST['Yearmin'], FILTER_VALIDATE_INT)==False){
  $yearmin = 860;
}
else{
  $yearmin=$_POST['Yearmin'];
}
print("<p>Minimum</p><br>");
print ("<input type=\"text\" name=\"Yearmin\" value=\"".$yearmin."\"><br>\n");
if(filter_var($_POST['Yearmax'], FILTER_VALIDATE_INT)==False){
  $yearmax = 2013;
}
else{
  $yearmax=$_POST['Yearmax'];
}
print("<p>Maximum</p><br>");
print ("<input type=\"text\" name=\"Yearmax\" value=\"".$yearmax."\"><br>\n");
$filter_year= 'Year <='.$yearmax.' AND Year >='.$yearmin;


/*Mass Filter*/
print("<label>Mass</label><br>\n");
if(filter_var($_POST['Massmin'], FILTER_VALIDATE_FLOAT)==False){
  $massmin = 0.0;
}
else{
  $massmin=$_POST['Massmin'];
}
print("<p>Minimum</p><br>");
print ("<input type=\"text\" name=\"Massmin\" value=\"".$massmin."\"><br>\n");
if(filter_var($_POST['Massmax'], FILTER_VALIDATE_FLOAT)==False){
  $massmax = 60000000.0;
}
else{
  $massmax=$_POST['Massmax'];
}
print("<p>Maximum</p><br>");
print ("<input type=\"text\" name=\"Massmax\" value=\"".$massmax."\"><br>\n");
$filter_mass= 'Mass <='.$massmax.' AND Mass >='.$massmin;


$finalQuery = 'SELECT * FROM meteorite WHERE ('.$filter_discovery.') AND ('.$filter_year.') AND ('.$filter_mass.')';

print ("<input type=\"submit\" value=\"Filter\">\n");
print ("\n<input type=\"button\" onclick=\"window.location.replace('index.php')\" value=\"Reset\"><br>\n");
print ("</fieldset>\n</form>\n");

print "<!-- ".$finalQuery."; -->\n";
$dbfile = new PDO('sqlite:meteorite.db');
$query = $dbfile->query($finalQuery);
$results = $query->fetchAll();
$dbfile = null;

$resultsCount = count($results);
if ($resultsCount <= 1)
{
	print("<p class=\"resultsCount\">$resultsCount result</p>\n");
}
else
{
	print("<p class=\"resultsCount\">$resultsCount results</p>\n");
}

print("<table>\n");
print("<tr><th>Name</th><th>ID</th><th>Mass</th><th>Discovery</th><th>Year</th><th>Latitude</th><th>Longitude</th><th>See location</th></tr>\n");

foreach ($results as $value)
{
	$link='https://www.google.com/maps/@'.$value['Latitude'].','.$value['Longitude'].',13.09z';
  print("<tr><td>".$value['Name']."</td><td>".$value['ID']."</td><td>".$value['Mass']."</td><td>".$value['Discovery']."</td><td>".$value['Year']."</td><td>".$value['Latitude']."</td><td>".$value['Longitude']."</td><td><a href=\"$link\">Click to see</a></td></tr>\n");
}
print("</table>\n");
?>
<!--</table>-->
</body>
</html>
