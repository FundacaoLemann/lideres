=== BuddyPress Members Only Pro===
Contributors: tomas zhu
Author URI: http://membersonly.top
Donate link: http://membersonly.top
Tags:buddypress,wordpress,wordpress members only,community,restricts,membership,user,access,privacy,private,private community,protection,pretected site,member
Requires at least: 3.0
Tested up to: 4.9.6
Stable tag: 3.5.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Restricts Your Buddypress and Wordpress to logged in/registered members ,
Restricts your BP standard Components to Logged in/Registered members only, you can choose which components will open to guest user, or which components will only opened to logged in users   
Restricts your BP customized Components to Logged in/Registered members only, you can setting as more as customized components to open to guest users.
Options to only protect your buddypress pages, so other section on your wordpress site will be open to the guest users.
Enable page level protect, when you edit a post, you can choose setting it as a members only page or not.									

== Description ==
Plugin Name: BuddyPress Members Only Pro<br>
Plugin Support URI: https://membersonly.top/support-ticket/<br>

Restricts Your Buddypress to logged in/registered members only.
Only registered/logged in users can view your site, non members can only open home page/login/register/lost password pages.
Logged in users have full access.

If a users who not is logged in, he can view home page, but when he try to view any other buddypress content, he will be redirected to optionally URL which can be setting in admin panel.
Support translate wordpress tooltips plugin in content and launch localized versions, .po files can be found in languages folder

since 3.1.2, in login /  logout redirect based on user role menu, you can select 
#redirect to BuddyPress Personal Profile Activity Page
#redirect to BuddyPress Members Page
#redirect to BuddyPress Personal Friends Page
#redirect to BuddyPress Personal Messages Page
#redirect to BuddyPress Personal Notifications Page
#redirect to BuddyPress Personal Settings Page
#redirect to BuddyPress Personal Profile Page
#redirect to BuddyPress Personal Favorites Page
#redirect to BuddyPress Personal Mentions Page
#BuddyPress Site Wide Activity Page
#BuddyPress Groups Page

Customized URLs Restricts based on user role,  you can use placeholders %username% and %sitename% to protect your customized URLs pages
#For example: https://yourdomain.com/members/%username%/forums/.
#For example: %sitename%/family/%username%/.
... and so on

Support RSS Restricts   
Support Add Announcement on Buddypress Members Only register page   

Also When we released a new version of buddypress members only pro plugin, you will get plugin update notify on admin top bar 

since 2.4.4, you can One Click Reset All Settings in Buddypress Members Only Pro

since 2.2.2, you can Restricts BP Standard Components to users based on user roles and Restricts BP Customization Components to users based on user roles

since version 1.9.8, you can setting after login redirect URLs and after logout URLs based on roles.

since pro version 1.8.2, you can:
Restricts Your Buddypress and Wordpress to logged in/registered members ,
Restricts your BP standard Components to Logged in/Registered members only, you can choose which components will open to guest user, or which components will only opened to logged in users   
Restricts your BP customized Components to Logged in/Registered members only, you can setting as more as customized components to open to guest users.
Options to only protect your buddypress pages, so other section on your wordpress site will be open to the guest users.
Enable page level protect, when you edit a post, you can choose setting it as a members only page or not.

Since version 1.6.1, we supported https and websocket ws. 
Since version 1.1.0, We added a new option: Opened Page URLs, you can add any urls (enter one URL per line please) which opened to public, guest can view content of these opened post / pages / stores... and so on, and they will not be redirected to register page.
Any feature request is welcome. :)

Based on some users suggestion, since version 1.0.4, our buddypress members only plugin support wordpress too, if you disable buddypress on your site, our plugin will detect it and support wordpress members only automatically.
<h4>How To Use:</h4>
BuddyPress Members Only is a simple & quick & light BuddyPress Members Only solution, it allows you to make your buddypress only viewable to visitors that are logged in, you can just activate the plugin and finish a little setting in admin panel and it will begin the work, but if you do not setting it in back end, it works well too, it is super easy to use.

== Installation ==
1:Upload the BuddyPress Members only plugin to your blog
2:Activate it
3: You will find in wordpress admin area, there are menu item "BP Members Only", if you click "BP Members Only", you will find there are 3 sub mutem item
a: "BP Members Only"
b: "BP Components"
c: "Optional Settings"

4: If you click "BP Members Only" sub menu item, you will find you can setting your register page URL or redirect page for non member of your buddypress site in BuddyPress Members only menu at admin panel.
Also if you have any pages / posts / URLs is opened to public user account, you can just add then in "Open Page URLs" textarea, enter one URL per line please.

5:  If you click  "BP Components", you will find we have listed all buddypress standard buddypress components in a checkbox list, you can checked any buddypress standard components to open to guest users.
All un-checked buddypress stantdard components can only be open by logged in users, when guest user try to open any pages related with these protected buddypress standard components, they will be redirected to register page URL or redirect page.
Also in    "BP Components" panel, there are another setting opttion: "Opened Customized Components",  you can add more customized buddypress components in here, it is very easy, please follow notes under this option and you can 
allow other non-standard buddypress components opened to guest users too. 

6: If you click "Optional Settings" Panel, you will find you can "Enable Page Level Protect" in this panel, please note:
# If you enabled this option, in page / post editor, you will find "Members only for this page?" meta box at the right top of the wordpress standard editor.
# If you checked "Allow everyone to access the page" checkbox in meta box, the post will be opened to all guest users
# By this way, you do not need enter page URLs to Opened Pages Panel always. 

Also in "Optional Settings" Panel, you will find there are another useful option: "Only Protect My Buddypress Pages", if you checked this checkbox, all other sections which is not related with buddypress 
will be opened to guest users, for example, blog posts, stores... and so on, if guest users try to open your buddypress section, they will be will be redirected to register page URL or redirect page.
Of course, this option: "Only Protect My Buddypress Pages" can works well with all options in  "BP Components", you can setting which components be opened to guest users yet.  

That's all, in each panel, we have detailed notes, please just follow our notes you will manage it very easy. 
Also any question is welcome at http://membersonly.top/ticket/ 

== Frequently Asked Questions ==
FAQs can be found here: http://membersonly.top/faq/

== Screenshots ==

1. Register page URL or redirect page for non member of your buddypress site

== Changelog ==
= Version 3.5.2 =
When users first time to install the buddypress members only pro plugin, we will do a init settings for the site to make understand how members only works better
Added more details for buddypress members only setting options
Fix an warning in buddypress memebrship approve addon 
Enhanced plugin security  

= Version 3.4.4 =
Restruct plugin to support develop addons for buddypress members only pro plugin

New buddypress members only pro addon panel, in which you can enable / disable many tooltips addons

New approve user addon, if enabled this addon, when users register as members, they need awaiting administrator approve their account manually, at the same time when unapproved users try to login your site, they can not login your site and they will get a message that noticed they have to waiting for admin approve their access first.

After enabled approve user addon, all registered users need approved by site administrator manually, but Super administrator (user ID = 1) and users who have admin user role will never be settings as unapproved user, they can always login your site.

After enabled approve users addon, you will find a new sub menu item -- "Approve User", in the "Buddypress Members Only Approve User Addon Setting" panel,  you can approve all existed users as approved users by one click

Also admin user can approve or unapprove any users at anytime, admin can find users approved status at wordpress standard users list page, Unapproved users will be mark as red background, also If you move your mouse on users name at users list page, you will find Approve and Unapprove links, just click links, you will be redirect edit user panel, at the bottom of the edit user panel, you wil lfind Approve User option, and you can approve or unapprove that user manually.

You can enable / disable approve user addon at anytime in addon manage panel

= Version 3.3.6 =
# In Buddypress Members Only Optional Settings Panel, added new option "restrict home page",
In general we will open homepage to guest, if you enabled this option, the homepage will be restricted to guest too, 
when guest try to open your home page, they will be redirected to register page or redirect page which you setting at Opened Pages Panel
# Improved performance of new version notify

= Version 3.3.2 =
# Restricts specified URL based on user roles, for example, you can closed https://yourdomain.com/support only for user role customer, 
and you can opened https:yourdomain.com/product for guest user role, support use placeholders %username% and %sitename% to protect your customized URLs pages
# Re-develop restricts rules module for better function structure
# Re-develop one click reset modules
# Added more tips for each setting options

= Version 3.2.6 =
Support more types of user roles
Get new version update faster 

= Version 3.2.2 =
When activated buddypress members only pro, no fatal error confict with buddypress members only free
When activated buddypress members only pro, we will deactivate buddypress members only free automatically 

= Version 3.1.8 =
Our buddypress members only plugin support wordpress members features better


= Version 3.1.6 =
Improved buddypress members only plugin update notification

= Version 3.1.4 =
Enhanced security

= Version 3.1.2 =
# In login redirect based on user role menu, added 11 login redirect method
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Profile Activity Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Members Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Friends Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Messages Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Notifications Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Settings Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Profile Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Favorites Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Mentions Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Site Wide Activity Page
# In login redirect based on user role menu, admin can setting users redirect to BuddyPress Groups Page

# In logout redirect based on user role menu, added 8 logout redirect method
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Profile Activity Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Members Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Friends Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Profile Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Favorites Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Personal Mentions Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Site Wide Activity Page
# In logout redirect based on user role menu, admin can setting users redirect to BuddyPress Groups Page

# Support RSS Restricts, in admin -> BP Members Ony -> RSS Restricts Panel, you can enable / disable RSS Restricts, you can add  restricts notification in editor, support image, link, font style, videos... and so on, restricts notification will shown in feed content  
# Support Add Announcement on Buddypress Members Only register page, in admin -> BP Members Ony -> Announcement Panel, you can enable / disable announcement on register page, you can add announcement in editor with image, link, font style, videos... and so on, we will show announcement at top of register page.   
# Customized URLs Restricts based on user role,  you can use placeholders %username% and %sitename% to protect your customized URLs pages,     
* For example: https://yourdomain.com/members/%username%/forums/.
* For example: %sitename%/family/%username%/.
... and so on

# repleaced deprecated admin menu permission 'manage_options'
# Upgrade buddypress members only database and code to processe user role better
# Use wordpress sanitize_textarea_field and esc_url to improve site security
# When we released a new version of buddypress members only pro plugin, you will get plugin update notify on admin top bar 
# In one click reset panel, support one click reset all settings of new features
# In buddypress component setting panel, replaced tips to add user roles name in each user role setting tab 
# redevelop a few functions to enhanced code quality

= Version 2.4.4 =
Add new menu item: One Click Reset All Settings in Buddypress Members Only Pro
Fixed bug

= Version 2.3.8 =
Use function esc_url to replace deprecated function escape
Use wordpress nonce security to improve site security

= Version 2.3.6 =
Based on users requested, changed admin css file name and admin js file name

= Version 2.3.2 =
Fix the bug of Restricts buddypress customize components and support buddypress customize components more better   

= Version 2.2.6 =
Support Restricts Buddypress Notifications Components
Tweak a few css IDs 

= Version 2.2.2 =
Restricts BP Standard Components to users based on user roles
Restricts BP Customization Components to users based on user roles 
Use wp_enqueue_style to load css
Use wp_enqueue_script to load js
Minisize js and css file
Enhance security to stop run our php script directly
Disable list files in plugin folders directly 

= Version 2.0.2 =
Improve security, do not allow access our php files and folders directly

= Version 2.0.0 =
Maybe some plugins did not follow wordpress standard to return data in login_redirect API, in this case we will try to generate one.

= Version 1.9.8 =
You can setting after login redirect URLs and after logout URLs based on roles.
Re-develop the plugin to support -- when you disable buddypress, our plugin will still works well   

= Version 1.8.8 =
Fix the bug of can not remove ppened page URL

= Version 1.8.2 =
Restricts Your Buddypress and Wordpress to logged in/registered members ,
Restricts your BP standard Components to Logged in/Registered members only, you can choose which components will open to guest user, or which components will only opened to logged in users   
Restricts your BP customized Components to Logged in/Registered members only, you can setting as more as customized components to open to guest users.
Options to only protect your buddypress pages, so other section on your wordpress site will be open to the guest users.
Enable page level protect, when you edit a post, you can choose setting it as a members only page or not.

= Version 1.6.1 =
 Supported https and websocket ws, reserved url for example home page, fixed bugs

= Version 1.3.0 =
Support translate wordpress tooltips plugin in content and launch localized versions, .po files can be found in languages folder

= Version 1.2.0 =
Enhanced wordpress security and plugin security 

= Version 1.1.0 =
Since version 1.1.0, We added a new option: Opened Page URLs, you can add any urls (enter one URL per line please) which opened to public, guest can view content of these opened post / pages / stores... and so on, and they will not be redirected to register page.

= Version 1.0.5 =
Solve the problems in some themes about "headers already sent" error

= Version 1.0.4 =
Based on some users suggestion, since version 1.0.4, our buddypress members only plugin support wordpress too, if you disable buddypress on your site, our plugin will detect it and support wordpress members only automatically.

= Version 1.0.2 =
setting menu capability so the menu item will only displayed to the admin.

= Version 1.0.1 =
Added Notification in back end and fixed some bugs.

= Version 1.0.0 =
BuddyPress Members Only Published

== Upgrade Notice ==

= Version 1.0.1 =
Added Notification in back end and fixed some bugs.

= Version 1.0.0 =
BuddyPress Members only Published
