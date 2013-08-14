################################################################################
#                       GPS Format free - Version 1.2                          #
################################################################################


================================================================================
Description
================================================================================
The „GPS Format Free“ allows e-learning content to be displayed according to the
geo coordinates of the learner. This enables location-based mobile learning. In
events like a city rally, the learner walks between predefined locations using a
smartphone or tablet PC. At these stations the learner gets certain information
and tasks that are directly related to the location. All conceivable Moodle
content like text, pictures, videos or tests can be used. The trainer is able to
integrate new content at his desktop PC, by simply creating a new Moodle course.
The GPS format largely matches the popular topics format. Every topic section
can contain different material or activities. In a second step specific topic
sections can be assigned to the corresponding GPS coordinates where they should
be visible. After the installation of the course format "GPS Format Free",
Moodle courses can be created in the new format and existing courses can be
transferred into the new format with only one click.



================================================================================
Demo Video
================================================================================
http://www.youtube.com/watch?v=W2dSdzp_b4A



================================================================================
How to install
================================================================================
Follow the instructions of the Moodle documentation:
http://docs.moodle.org/25/en/Installing_add-ons

The correct path on your Moodle server is:
/path/to/moodle/course/format/



================================================================================
Support
================================================================================
This is usually an unsupported version of the course format. If you ask kindly
you can contact Barry Oosthuizen who helped us to develop the plugin. The
ka:media Team could also help from time to time.



================================================================================
Background information - why is the format called "free"
================================================================================
ka:media developed the GPS course format in a „Pro“ version for Totara and its
own systems. The focus lies on country-specific learning, mobile learning in
large commercial spaces and the efficient training of rescue and delivery
services.
 
The team discovered already in the developing process, that a GPS format will be
a very helpful tool for a broad range of users, e.g. teachers or in tourism.
To support the meanwhile great development of Moodle in the area of mobile
applications, ka:media decided to publish the GPS format in a version, which is
without any fee-based support and can be installed by every Moodle
administrator.



================================================================================
Version Information
================================================================================
2nd of August 2013 - Version 1.2.
  1. We changed the frankenstyle name of the plugin from format_kamedia_gps_free
     to the more simple format_gps. If you are updating from older versions, you
     will have to uninstall it completely and install this version as a new
	 plugin.
  2. Fixed the language file bug (the lang/en file contained lang/de data)
  3  Added body.format-gps prefix to all directives in style.css and
     geocoder_form.css

19th of July 2013 - Version 1.1.
  1. Fixed a missing language string
  2. Added maturity field in version.php
  3. Fixed GPS update bug
  4. New update buttons
  5. Fixed minor changes