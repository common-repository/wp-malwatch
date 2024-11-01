=== Plugin Name ===
Contributors: Orangecast Social Media
Donate link: http://how-to-blog.tv/security/wp-malwatch
Tags: security, security scan, malware scanner, scanner
Requires at least: 2.9.0
Tested up to: 3.0.0
Stable tag: 2.1.2

WP-MalWatch is a WordPress security plugin that performs a nightly scan of your WordPress blog looking for evidence of malware.

== Description ==

WP-MalWatch is a WordPress security plugin scanner designed to help alert you when hackers have been at work inside your blog.

When hackers infiltrate a blog, the first thing they do is plant hidden files, disguised .PHP, and malicious .HTACCESS files in various
directores.  Their goal is to litter your WordPress installation and theme with links to their sites.

WP-MalWatch performs a security scan of your WordPress installation nightly looking for evidence of foul play and if WP-MalWatch finds it, a dashboard widget will tell you were you should take a closer look.  WP-MalWatch's detailed report also provides you a very easy interface for looking at the contents of these files right from within WordPress so you don't have to get into messy FTP clients and editors looking at potential problems.

Version 2.1.2 of WP-MalWatch is based on 2.0.2 which was a complete rewrite of the original WP-MalWatch plugin and provides efficient malware scanning.  Version 2.1.2 looks for hidden files, HTACCESS files, configurable file patterns, keywords in theme files, encode 64 calls in key WordPress files, and .PHP files in the uploads directory.  

Does WP-MalWatch protect your blog?

NO!  WP-MalWatch is a scanning plugin that allows a blogger to easily identify the presence of files in a blog installation and provides a simple viewer for examining them.

If WP-MalWatch finds files in my blog, does it mean I have a problem?

Not necessarily but it does mean you need to take a look at them.  The plugin has several links to explanations of what WP-MalWatch is looking for.  Any file that WP-MalWatch reports, you should look at and be comfortable that it is there for a purpose.  

Why PHP files in the uploads directory?  Because they shouldn't be there and are clear evidence of foul play.

What are configurable file patterns?

Hackers love to drop multiple extension files into a blog hoping that you won't notice them.  The default setting for WP-MalWatch are the file extension patterns for the somewhat clever "pharma attack".  These include patterns like *.old.php and *.bak.php.  You can configure these for whatever you are looking for.

Why .HTACCESS files?  .HTACCESS files are specific for UNIX and you will generally have one at the root of your website.  WordPress actually uses this file for things like Permalinks.  Hackers love to drop .HTACCESS files into other parts of your WordPress installation to do malicious things such as implement 301 redirects to trick users or even search engines.  Still, some plugins use .HTACCESS files for their functionality.  That doesn't mean that a hacker can't get into those.  If you have more than one .HTACCESS file in your installation, you'll want to take a look at it and ensure that there are no redirects to sites you aren't aware of.

Will WP-MalWatch scans impact the performance of my blog?

We tested WP-MalWatch on one of our blogs while there were over 2,000 active users online.  We were impressed with its performance and the fact that it didn't impact server performance.  If you see something different with your hosting, report it to us but we can assure you we paid close attention to the efficiency of scanning in this plugin.

If My Blog Is Clean, Should I leave WP-MalWatch installed?

YES!  It only runs once per night and is very efficient.  Leave this plugin installed.  You can turn modules on/off as well.



WP-MalWatch Features:

*    Automated nightly scans with the option to manually invoke.
*    Efficient detection of PHP files in your Uploads directory.
*    Efficient detection of multiple .HTACCESS files in your installation.
*    Detection of files based on configurable file patterns.
*    Detection of hidden files.
*    Detection of configurable keywords in theme files.
*    Detection of encode64 calls in key WordPress files
*    Configurations including turning modules on and off.
*    A easy to use viewer for any files detected during a scan.
*    Symbolic link friendly file scanning.
*    Dashboard widget for easy notification.
*    Efficient and high performance scanning.
*    A very well written, modularized plugin architecture for future expansion.

   
== Installation ==

WP-MalWare's installation is fairly straight forward.

1. Upload the 'wp-malware folder' to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

PHP4 IS NOT supported and will produce an activation error.

Sub-domain installations and "One Click" installations have been found to put a fully qualified file system path in the "Miscellaneous -> Store Uploads In This Folder setting".  The default is "wp-content/uploads".  WP-MalWatch WILL NOT activate if the uploads folder is not set to the default setting. 


== Frequently Asked Questions ==

= Should I leave WP-MalWatch installed or just run it once and delete? =

WP-MalWatch only runs once a night and is your eyes and ears as to any strange behavior in your blog.  Leave it installed.  It won't impact performance and doesn't take any memory while not scanning.

= What should I do if WP-Malware finds evidence that my site has been hacked? =

Manually look at the files that WP-MalWare marks as suspect through the "view" option in the detailed report.  If you find direct evidence that something is not right (e.g. - PHP files in the uploads directory structure), you will want to engage a professional who is knowledgeable of WordPress and restoring an installation or locating/eliminating malware.  Visit our plugin home page for the most up to date information regarding malware blocking software and service professionals.  PLEASE NOTE that there might be a solid reason for a file being there that WP-MalWatch finds.  Ask questions before you delete.

= How do I know if an .HTACCESS file found in a plugin directory is malicious? =

View it in the detailed reports and look at it.  If it implements a 301 redirect to a site that doesn't look right, you have a problem.  If it does some basic interaction with the plugin's site, you are likely OK.

For more information on common directives found in HTACCESS files in WordPress installations, download our PDF <a href="http://how-to-blog.tv/security/wp-malwatch/common-htaccess-directives-for-wordpress/>Common HTACCESS Entries for WordPress</a>.

= How Can I prevent malware in my WordPress installation? =

Several software vendors create monitoring, blocking, and prevention services for WordPress.  We maintain a full list of security resources and products on <a href="http://how-to-blog.tv/security>How-To-Blog.TV</a>

= Why Does WP-MalWatch v1.1.2 only look for PHP files in the uploads directory and multiple .htaccess files? =

The makers of WP-MalWatch believe that the development of software is an evolving process.  We have an understanding of how hackers work; yet, we have to also listen to users in order to develop the right solution. The goal of our v1.0.X release series was to provide a solid plugin framework that performed one of the many things we wanted to accomplish.  Since then, we have been listening to your feedback.  1.1.2 is a testament to this as we've incorporated the feedback and fixed the bugs reported by hundreds of users.

= I installed WP-MalWatch and I got an error upon activating the plugin.  Why? =

If you received an error saying that the plugin had a fatal exception expecting a T_STRING on line 12 . . then you are running PHP4 on your hosting.  You should contact your hosting provider and ask them to 
enable PHP5 on your hosting.  If they can't, hosting is a commodity and you should consider looking for a provider that provides more up to date infrastructure.  Version 1.0.4 and beyond traps this error.

= Why is WP-MalWatch hard coded for a specific time in the early morning? =

The short answer. . that is a safe time to scan directories and catches issues before the US workday begins.  The long answer is that it was a functionality choice.  We will provide full scheduling control in a future release of the plugin.  Thanks for your patience.

== Screenshots ==

1. WP-MalWatch provides a dashboard widget that provides an updated status as to the most recent scan.
2. WP-MalWatch was created with a modular design that will allow for expansion.
3. WP-MalWatch requires your uploads directory to be in the default location.
4. WP-MalWatch's file viewer.


== Changelog ==

= 1.0.0 =

*  Initial release

= 1.0.1 =
* Fixed initiation issue that occurred on MediaTemple's grid service.
* Fixed intermittent errors with How-To-Blog.TV RSS feed.
* Corrected minor formatting issues with IE8.
*

= 1.0.2 =

* Fixed time display issue.
* Identified issue with Massive News theme

= 1.0.3 =

* Added handling to trap PHP4 activation error.
* Added handling to detect an uploads folder that is not set to default.
* Verified that sub-domain installations are supported.

= 1.0.4 =

* Fixed installation error

= 1.1.0 =

* Added support for detecting multiple .HTACCESS files.

= 1.1.1 =

* This was an internal release tested only on <a href="http://how-to-blog.tv">How-To-Blog.TV</a> and <a href="http://www.midwestsportsfans.com">Midwest Sports Fans</a>

= 1.1.2 =

* Changed the format for reporting .HTACCESS files knowing that some plugins implement them.

= 2.0.2 =
WP-MalWatch 2.0 is a complete rewrite of this plugin offering fast and efficient scanning, a user friendly interface including an easy to use file viewer.  2.0 introduces configurable file extension pattern scanning and hidden file scanning.

= 2.0.3 =
We have been testing WP-MalWatch with WordPress 3.0 and fixing minor glitches along the way.  Now that WordPress 3.0 is released, we wanted to update WP-MalWatch with a release that has been tested on the final WordPress 3.0 code.

= 2.1.2 =
We add support for enabling and disabling individual modules, detection of encode64 calls in vulnerable WordPress files and the ability to search for up to 10 keywords in theme files.

== Upgrade Notice ==

= 1.1.2 =
Fixes all known issues to date.  The official public release.

= 2.0.3 =
Tested on released code of WordPress 2.0.3. Minor glitches fixed.

= 2.1.2 =
Fixed several issues, tested with WordPress 3.0, and added functionality for encode64 detection, keyword scanning in theme files, and enable/disable of individual modules.

== Our Commitment ==

Please understand that this is only our second major release of the plugin.  In the first major release, we poured all of our effort into creating a framework that was well coded and very stable.  The functionality will expand as we add modules.  We could have introduced a lot more functionality and not paid as much attention to the quality of the code or the expandability of the frame work.

We hope you agree that quality comes first. We commit to expanding the functionality of this plugin on a regular basis.


