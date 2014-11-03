<?php
//  a very basic serialization from mysql table to georss
//  lex berman    gis.harvard.edu   
//  version:   2008
//  license:  http://opensource.org/licenses/MIT

require ("CONNECTION_INFO.inc");

$connect = @mysql_connect("$db_addr", "$db_user", "$db_pass");

if (!($connect)) // If no connect, error and exit().
{
echo("<p>Unable to connect to the database server.</p>");
exit();
}

if (!(@mysql_select_db($db_name))) // If can't connect to database, error and exit().
{
echo("<p>Unable to locate the $db_name database.</p>");
exit();
}

$q="SELECT * FROM YOUR_TABLE ORDER BY your_title";

$result = mysql_query($q) or die("Error: " . mysql_error()); 

$num = mysql_num_rows($result);

if ($num != 0) {

//  get a valid date in RFC822 format
$date= date(r);


$file = "rss_feed.xml";
if (!$file_handle = fopen($file,"a")) { echo "Cannot open file"; }


 $_xml ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n
<rss version=\"2.0\" xmlns:geo=\"http://www.w3.org/2003/01/geo/wgs84_pos#\" xmlns:atom=\"http://www.w3.org/2005/Atom\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n
<channel>
<title>YOUR RSS FEED TITLE</title>
<description>YOUR RSS FEED DESCRIPTION </description>
<atom:link href=\"http://site.to.xml/path/YOUR_RSS_FEED.xml\" rel=\"self\" type=\"application/rss+xml\" />
<link>http://your.site.org</link>
<dc:publisher>RSS FEED PUBLISHER</dc:publisher>
<pubDate>$date</pubDate>\n

";

if ($row = mysql_fetch_array($result)) {
  do {

    $id = $row["your_id"];
    $title = $row["your_title"];
    $desc_1 = $row["your_description_1"];
    $desc_2 = $row["your_description_2"];
    $desc_3 = $row["your_description_3"];
    $desc_4 = $row["your_description_4"];
    $lat = $row["your_latitude"];
    $long = $row["your_longitute"];


      $_xml .="<item>\n<title>" . "$title" . "</title>\n";
      $_xml .="<pubDate>" . "$date" . "</pubDate>\n";
      $_xml .="<description><![CDATA[" . "$desc_1" . "<br> YOUR FIELD NAME 2=$desc_2 <br> YOUR FIELD NAME 3=$desc_3 <br> YOUR FIELD NAME 4=$desc_4" . "]]></description>\n";

      $_xml .="<link>http://your.site.org/your_query.php?your_ID_parameter=" . "$id" . "&amp;your_OTHER_parameter=foo</link>\n";
      $_xml .="<geo:lat>" . "$lat" . "</geo:lat>\n";
      $_xml .="<geo:long>" . "$long" . "</geo:long>\n";
      $_xml .="</item>\n";

  } while($row = mysql_fetch_array($result));

} else {print "no attribute data for this record";}

 $_xml .="</channel> \n </rss>";

 fwrite($file, $_xml);

 fclose($file);

if (!fwrite($file_handle, $_xml)) { echo "Cannot write to file"; }
echo "You have successfully written data to <a href=\"rss_feed.xml\">View the XML.</a>";
fclose($file_handle);

 } else {

 echo "No Records found";

 }


?>

