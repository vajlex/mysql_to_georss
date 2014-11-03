mysql_to_geoRSS

Author:  Lex Berman
Release Date: February 2008
License:  Free to anyone, no restrictions  http://opensource.org/licenses/MIT

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

Summary:   The purpose of this script is to serialize the results of a query to MySQL into valid RSS, including the geoRSS tags.   The RSS feed produced can be pointed to using the standard OpenLayers example for GeoRSS feed.

References:

RSS validation - rss version=\"2.0\" xmlns:geo=\"http://www.w3.org/2003/01/geo/wgs84_pos#\

GeoRSS validation - xmlns:geo=\"http://www.w3.org/2003/01/geo/wgs84_pos#\"

OpenLayers GeoRSS example - http://openlayers.org/dev/examples/georss.html

XML validation -  http://validator.w3.org/feed/

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

mySQL setup:

Table definition:

your_id INT (unique ID number for each record)
your_title CHAR (holds the title of each record)
your_description_1 CHAR (first attribute of record)
your_description_2 CHAR (second attribute of record)
your_description_3 CHAR (third attribute of record)
your_description_4 CHAR (fourth attribute of record)
your_latitutde CHAR (latitude in decimal degrees)
your_longitude CHAR (longitude in decimal degrees)

NOTE:  if your field names are different, you must change the code in the mysql_to_geoRSS.php file to replace the field names used above.

CONNECTION_INFO.inc:

save an include file in the same directory as mysql_to_geoRSS.php with your connection info in the following format:

<?php
$db_addr ='localhost';
$db_user = 'YOUR_USER_NAME';
$db_pass = 'YOUR_PASSWORD';
$db_name = 'YOUR_DATABASE_NAME';
?>

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

NOTES on how to configure the mysql_to_geoRSS.xml file:

1)  $q="SELECT * FROM YOUR_TABLE ORDER BY your_title";   
edit in the correct name your your table in the query.  note that the result is for all the records.  of course you can limit the query any way you like, or if you have multiple items with the same ID you can GROUP BY the ID, etc.  the query assumes that you would like your RSS feed to be ordered alphabetically by title.  of course you might want them to be by timestamp, etc.

2)  $date= date(r);   
the RSS standard wants dates in the RFC822 format.  PHP has the built-in call for that using the (r) flag.   you can push your own dates for each record to the script for each record, in which case swap out the $date variable with your own, but remember that the RSS won't validate if you don't convert the format to RFC822.

3)  $file = "rss_feed.xml";
name of the file that you want to write the RSS feed to.  Note that you have to change this at the beginning of the script, and AGAIN at the end where you throw in a link to the RSS feed itself.  the second part is like this:
echo "You have successfully written data to <a href=\"rss_feed.xml\">View the XML.</a>";   so if you change this name, change it in both places.  it will process the file, as long as you change it in the first line, but the link won't work, if you forget to change it there.

4)  define the FEED by changing the info as needed in this section:
<title>YOUR RSS FEED TITLE</title>
<description>YOUR RSS FEED DESCRIPTION </description>
<atom:link href=\"http://site.to.xml/path/YOUR_RSS_FEED.xml\" rel=\"self\" type=\"application/rss+xml\" />
<link>http://your.site.org</link>
<dc:publisher>RSS FEED PUBLISHER</dc:publisher>

NOTE:  you probably want to hard code the path to you RSS feed in the atom:link part.   you could do something with $SERVER_NAME and $REQUEST_URI in PHP, but you will end up with the PHP script name, not the RSS feed name that is written to disk.   it is safer to run this script in a hidden directory.  after you have validated the RSS feed [ http://validator.w3.org/feed/ ] then move the .xml file to a public folder on your webserver.  the path to the public location should be hard-coded in the atom:link item.

5) as mentioned above, you want to make sure the calls for the field names in your mySQL table are correctly used in the section where they are assigned variables in the script:       $id = $row["your_id"];

6) note that the <description> section is made by concatenating several different values from your table.  you could use only one, but this makes it easy to use several.  however, don't stuff too much info here, it only appears in the Title and Description lines of the RSS feed, which has some limitations.

7) also note that the <description> section is wrapped in a CDATA call, like
<![CDATA[<description>foo<br>place=bar</description]]>  this is the way to push the line endings to the RSS feed.  \r\n doesn't work.

8) the <link> URI is also concatenated from some sections.  the first section is the host and path up to the script and the header setting up a query.  the second section is the parameter that you want to send for the particular record, in the example it is the ID number.  the trailing section is for additional parameters, if you need them.  of course, you could change this around as you like.


9) testing:
after you set up the mysql table and the script, as described above, move the script to your webserver where you can run PHP.   launch the PHP and if it works you should get a statement saying that the data was written to your filename, and a link to the rss_feed.xml file.   clicking on the RSS feed file will parse it with a browser.   if all went well, you should be able to see it as a normal RSS feed.  however, for testing, you probably want to move the RSS feed file to a public folder on your browser, and paste the complete URI to the file into the RSS Validator [ http://validator.w3.org/feed/ ] .   For example, you can see how my test file validates by pasting in:  http://gist.fas.harvard.edu/rss/news.xml


>>>>>>>>>>>>

OTHER THINGS TO KNOW:

1)  RSS validation might not accept your encoding instruction [charset="UTF-8"] even though it looks fine in the browser.  this sometimes happens when Apache does not have the default setting.  you might want to add the following to httpd.conf, then restart apache:   AddCharset UTF-8 .xml    

2)  RSS validation also gets upset if Apache hasn't been told to serve proper RSS, so you can go ahead and add this to Apache for good measure, then restart:   

#add application for RSS feed
AddType application/rss+xml .xml


3)  WARNING!  XML/RDF/RSS will choke on all sorts of special characters and diacritic marks.  The script below was tested with contents in Chinese, Japanese, Korean, Vietnamese, and English.   It only works if the content being searched in mySQL has been COMPLETELY SCRUBBED of the offending elements. That means in the "Romanized" characters, especially, as well as the other vernacular scripts need to have elements deleted or escaped. If you are just using ASCII or something more XML-feed friendly, the script described above should work no problem.

If you want to find out more about the ugly topic, see http://www.openarchives.org/OAI/2.0/guidelines-oai-identifier.htm 

Or if you want to see my notes on making the East Asian UTF-8 data work, see:
http://gist.fas.harvard.edu/chgis/?p=15