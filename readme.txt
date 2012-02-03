=== Browser Sniff ===
Contributors: bpedrassani
Donate link:
Tags: browser, operating system, browser sniff
Requires at least: 1.5.0
Tested up to: 3.3.1
Stable tag: 2.3

Detects web browser type and operating system to show in the comment loop

== Description ==

* Detects and shows commenters web browser/operating system (used in the comment loop)
* Describe an arbitrary user agent string (for general use)
* Can show web browser/operating system icons
* If the user is "cookied" - a.k.a blog admin visiting the blog - , it also displays an asterisk titled with the full user agent string(just mouse hover the asterisk to see the string). Regular visitors can't see this feature.
* All mainstream browsers and SOs are detected, blogging softwares(trackbacks/pingbacks), text based browsers, antiquated browsers, cell phones and pdas
* It can be "automagically" added in your theme if you do not want/like to edit templates 

== Installation ==

1. Download and extract the plugin, you should see a browser-sniff directory
1. Install like any other Wordpress plugin, just place the browser-sniff folder in your wp-content/plugins directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the Plugins->Browser Sniff menu and set your options
1. (optional) Place `<?php pri_print_browser(); ?>` in your templates, especifically on the comment loop. See the Usage section for more info
1. (optional) You can change how the icon look in your CSS by modifying style for selector img.browsericon

== Frequently Asked Questions ==

= My device is not being recognized, or I get the message "Unknown Browser". Why? =

Your device is too new or I did not get the user agent string to parse in the code. Send me the user agent string and the name of the unrecognized device, and I'll fix it.

= I didn't like the icon for "name-your-browser-or-so-here". Can I change/send you a better one? =

Yes, you can. There`s a directory named "icons", with all of them. Just change the ones you want. Some icons may not be the best, but I don't spend that much time looking for them. If you've got a better one, send me, and if I like I'll put it in the next release.

= Are you the original author of the plugin? Priyadi just have the same plugin you do! =

I'm not the original author, Priyadi from [http://priyadi.net](http://priyadi.net) is. But he discontinued the development, so I contacted him and now I'm the new maintaner/developer of it. I'm an author, but not the original one.

= I don't like where the plugin shows the browser and OS. Can I change it? =

Yes you can, but you need to place the hook by yourself on the theme, and choose "manually" on the plugin admin page.

== Screenshots ==

1. This is an example of how the plugin looks. Neat, huh?

== Changelog ==

= 1.0 =
* First release

= 1.1 =
* Added $between parameter. Thanks to João Craveiro.

= 1.2 =
* Fixes for eLinks

= 1.3 =
* Detects Shiira. Thanks to CH Chan.

= 1.4 =
* Now detects Windows Vista, Qtopia/QtEmbedded, Danger HipTop, Anonymouse, PHP, Drupal, TypePad, and several Samsung phones.

= 1.5 =
* Detects Nokia E Series (as SymbianOS), W3M, Openwave UP.Browser, Mozilla Seamonkey, Minimo, Flock, MultiZilla, Sony PSP, AvantBrowser and Opera Mini. Also includes various icon updates. Thanks to Frank Aune and Siren.

= 1.6 =
* Detects o2 XDA, Dopod, Xiino, LG Electronics phones, Motorola phones, and NTT DoCoMo phones.

= 1.7 =
* Detects Kazehakase.

= 1.8 =
* Detects Nintendo Wii.

= 1.10 =
* Detects all Ubuntu derivatives: Kubuntu, Xubuntu and Edubuntu.
* Detects Debian Iceweasel and unbranded Firefox (BonEcho).
* Fixes for Nintendo Wii.
* Rearrange order for Debian derivatives.

= 1.11 =
* Maintaner changed to Bruno Pedrassani.
* Detects Google Chrome
* Added Icons for Google Chrome, Windows 7 and Windows Vista
* WP compliant, no need to create a browsers directory anymore
* First release on http://wordpress.org/extend/plugins

= 1.12 =
* Added new Icons for MAC OS X, Internet Explorer and Safari, Thanks to [Peter Upfold](http://peter.upfold.org.uk/)
* Detects Opera Mini for iPhone
* Fixed detecting for Safari on iPhone.
* Detects iPhone OS Version if available.

= 1.13 =
* Detects Android phones
* Detects Default Android browser
* Added icons for Android, Android browser, webOS, ZuneHD and Windows Phone OS
* Fixed Opera Mini/Mobile version detection
* Detects iPad
* Detects iPod
* Detects iPad OS version if available
* Detects Palm WebOS
* Detects Safari on SymbianOS
* Detects IE Mobile
* Detects ZuneHD
* Detects Windows Phone OS
* Fixed Avant Browser detection

= 2.0 =
* Admin menu available at Plugins->Browser Sniff. Now you can set a lot of options, like size of icons, Strings to print, whether to show icons or not and to place the hook "automagically".

= 2.1 =
* Fixed bug a bug that showed Netscape under some Apple devices, thanks to [ShaolinTiger](http://www.shaolintiger.com)
* Changed iPod/iPhone OS to iOS

= 2.2 =
* Changed all Apple devices OS to iOS
* Changed Mac OS X detection to show version

= 2.3 =
* Added Windows 8 detection
* Updated the compatibility list

== Upgrade Notice ==

= 2.3 =
Added Windows 8 detection and updated compatibility list

= 2.2 =
Changed Apple device detection and compatibility of the plugin up to 3.1.3

= 2.1 =
Fixed some bugs with Apple devices detections and updated the compatibility to 3.0.1

= 2.0 =
Entire code being rewritten for better performance and usability! Admin menu available with a set of options to change!

= 1.13 =
Tons of new detections, new icons and some bug fixes!

= 1.12 =
New icons(thanks to Peter Upfold), detection of Opera on iPhone, and improved iPhone detection!

= 1.11 =
First release on http://wordpress.org/extend/plugins, with maintaner change(to Bruno Pedrassani). Just get it :)

== Usage ==

Usage is pretty simple.

If you choose the "automagically" option, no need to worries, but it can be placed where you do not want it to be. 

If you want to place the code into your theme, just use the function pri_print_browser("Using ", "", true, 'on'); wherever you want in the comment loop. Also you can simply use pri_print_browser(); and the options will be loaded from database. The parameters here are:

1. String to be printed before description("Using" in this case)
1. String to be printed after description(nothing i.t.c)
1. true or false to display icons or not. Default is true
1. String to be printed between web broser and operating system. Default is 'on'.

The default use of the plugin show something like this:

** Using Mozilla Firefox Mozilla Firefox 4.0 on Windows Windows 7 **

If there's no recorded user agent string(WP1.5-), strings before and after will no be printed.
If you are logged as administrator of the WP-based site("cookied"), you'll see an asterisk after the print, with the full user agent string detected by Wordpress. Just hover the asterisk to see it. This is useful to see if the plugin is working correctly.

You can also find browser description from an arbitrary user agent string, using the function pri_browser_string("Mozilla/1.0", true, 'on'); . It'll return a string with the browser description. The parameters are:

1. The user agent string to be detected.("Mozilla/1.0" i.t.c)
1. true of false to display icons or not
1. String to be printed between web broser and operating system. Default is 'on'.

** FINDING THE COMMENT LOOP **

If your template is made to newer versions of Wordpress(2.7+), normally the comment loop will be located in the file wp-content/themes/your-theme/comments.php . Just look for clues like "comment loop", or text printed on every comment, like "commented by", or you can just put the function pri_print_browser("Using ", "", true, 'on'); and see where it prints, then try to locate where you want it to be.

Although normally the wp-content/themes/your-theme/comments.php file is used, sometimes it can be the wp-content/themes/your-theme/comments-popup.php, or even the wp-content/themes/your-theme/functions.php. If this last one is used, look for a function custom_comment() or something like this.

I'll not dig deeper in this, but with some time and will, you can find the comment loop. Once you find it, you won't forget it :)
