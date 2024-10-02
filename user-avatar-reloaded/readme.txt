=== User Avatar - Reloaded ===

Contributors: saadiqbal
Tags: user profile, avatar, gravatar, author image, author photo, author avatar, bbPress, profile avatar, profile image, user avatar, user image, user photo, widget
Requires at least: 4.0
Requires PHP: 5.6
Tested up to: 6.3.1
Stable tag: 1.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Use any image from your WordPress Media Library as a custom user avatar or user profile picture. Add your own Default Avatar.

== Description ==

WordPress currently only allows you to use custom avatars that are uploaded through Gravatar. WP User Avatar enables you to use any photo uploaded into your Media Library as an avatar. This means you use the same uploader and library as your posts. No extra folders or image editing functions are necessary.

**WP User Avatar** also lets you:

* Upload your own Default Avatar in your WP User Avatar settings.
* Show the user's [Gravatar](http://gravatar.com/) avatar or Default Avatar if the user doesn't have a WP User Avatar image.
* Disable [Gravatar](http://gravatar.com/) avatars and use only local avatars.
* Use the <code>[avatar_upload]</code> shortcode to add a standalone uploader to a front page or widget. This uploader is only visible to logged-in users.
* Use the <code>[avatar]</code> shortcode in your posts. These shortcodes will work with any theme, whether it has avatar support or not.
* Allow Contributors and Subscribers to upload their own avatars.
* Limit upload file size and image dimensions for Contributors and Subscribers.

== ADD WP USER AVATAR TO YOUR OWN PROFILE EDIT PAGE ==

You can use the [avatar_upload] shortcode to add a standalone uploader to any page. It’s best to use this uploader by itself and without other profile fields.
If you’re building your own profile edit page with other fields, WP User Avatar is automatically added to the show_user_profile and edit_user_profile hooks. If you’d rather have WP User Avatar in its own section, you could add another hook:

`do_action('edit_user_avatar', $current_user);`

Then, to add WP User Avatar to that hook and remove it from the other hooks outside of the administration panel, you would add this code to the functions.php file of your theme:
`<?php
function my_avatar_filter() {
  // Remove from show_user_profile hook
  remove_action('show_user_profile', array('wp_user_avatar', 'wpua_action_show_user_profile'));
  remove_action('show_user_profile', array('wp_user_avatar', 'wpua_media_upload_scripts'));

  // Remove from edit_user_profile hook
  remove_action('edit_user_profile', array('wp_user_avatar', 'wpua_action_show_user_profile'));
  remove_action('edit_user_profile', array('wp_user_avatar', 'wpua_media_upload_scripts'));

  // Add to edit_user_avatar hook
  add_action('edit_user_avatar', array('wp_user_avatar', 'wpua_action_show_user_profile'));
  add_action('edit_user_avatar', array('wp_user_avatar', 'wpua_media_upload_scripts'));
}


// Loads only outside of administration panel
if(!is_admin()) {
  add_action('init','my_avatar_filter');
}
?>`
== HTML WRAPPER ==

You can change the HTML wrapper of the WP User Avatar section by using the functions wpua_before_avatar and wpua_after_avatar. By default, the avatar code is structured like this:

`<div class="wpua-edit-container">
  <h3>Avatar</h3>
  <input type="hidden" name="wp-user-avatar" id="wp-user-avatar" value="{attachmentID}" />
  <p id="wpua-add-button">
    <button type="button" class="button" id="wpua-add" name="wpua-add">Edit Image</button>
  </p>
  <p id="wpua-preview">
    <img src="{imageURL}" alt="" />
    Original Size
  </p>
  <p id="wpua-thumbnail">
    <img src="{imageURL}" alt="" />
    Thumbnail
  </p>
  <p id="wpua-remove-button">
    <button type="button" class="button" id="wpua-remove" name="wpua-remove">Default Avatar</button>
  </p>
  <p id="wpua-undo-button">
    <button type="button" class="button" id="wpua-undo" name="wpua-undo">Undo</button>
  </p>
</div>`

To strip out the div container and h3 heading, you would add the following filters to the functions.php file in your theme:

`<?php
remove_action('wpua_before_avatar', 'wpua_do_before_avatar');
remove_action('wpua_after_avatar', 'wpua_do_after_avatar');
?>`

To add your own wrapper, you could create something like this:

`<?php
function my_before_avatar() {
  echo '<div id="my-avatar">';
}
add_action('wpua_before_avatar', 'my_before_avatar');

function my_after_avatar() {
  echo '</div>';
}
add_action('wpua_after_avatar', 'my_after_avatar');
?>`

This would output:


`<div id="my-avatar">
  <input type="hidden" name="wp-user-avatar" id="wp-user-avatar" value="{attachmentID}" />
  <p id="wpua-add-button">
    <button type="button" class="button" id="wpua-add" name="wpua-add">Edit Image</button>
  </p>
  <p id="wpua-preview">
    <img src="{imageURL}" alt="" />
    <span class="description">Original Size</span>
  </p>
  <p id="wpua-thumbnail">
    <img src="{imageURL}" alt="" />
    <span class="description">Thumbnail</span>
  </p>
  <p id="wpua-remove-button">
    <button type="button" class="button" id="wpua-remove" name="wpua-remove">Default Avatar</button>
  </p>
  <p id="wpua-undo-button">
    <button type="button" class="button" id="wpua-undo" name="wpua-undo">Undo</button>
  </p>
</div>`

== Installation ==

1. Download, install, and activate the WP User Avatar plugin.
2. On your profile edit page, click "Edit Image".
3. Choose an image, then click "Select Image".
4. Click "Update Profile".
5. Upload your own Default Avatar in your WP User Avatar settings (optional). You can also allow Contributors & Subscribers to upload avatars and disable Gravatar.

== Frequently Asked Questions ==

= Why am I not getting the emails when a new user registers? =

First, choose a theme that has avatar support. In your theme, you have a choice of manually replacing get_avatar with get_wp_user_avatar, or leaving get_avatar as-is. Here are the differences:

**get_wp_user_avatar**


1. Allows you to use the values “original", “large", “medium", or “thumbnail" for your avatar size.

2. Doesn’t add a fixed width and height to the image if you use the aforementioned values. This will give you more flexibility to resize the image with CSS.

3. Allows you to use custom image sizes registered with add_image_size (fixed width and height are added to the image).

4. Optionally adds CSS classes “alignleft", “alignright", or “aligncenter" to position your avatar.

5. Shows nothing if the user has no WP User Avatar image.

6. Shows the user’s Gravatar avatar or Default Avatar only if “Show Avatars" is enabled in your WP User Avatar settings.

**get_avatar**


1. Requires you to enable “Show Avatars" in your WP User Avatar settings to show any avatars.

2. Accepts only numeric values for your avatar size.

3. Always adds a fixed width and height to your image. This may cause problems if you use responsive CSS in your theme.

4. Shows the user’s Gravatar avatar or Default Avatar if the user doesn’t have a WP User Avatar image. (Choosing “Blank" as your Default Avatar still generates a transparent image file.)

5. Requires no changes to your theme files if you are currently using get_avatar.
[Read more about get_avatar in the WordPress Function Reference.](https://developer.wordpress.org/reference/functions/get_avatar)

= Can I create a custom Default Avatar? =

In your WP User Avatar settings, you can upload your own Default Avatar.

= Can I disable all Gravatar avatars? =

In your WP User Avatar settings, you can select “Disable Gravatar — Use only local avatars" to disable all Gravatar avatars on your site and replace them with your Default Avatar. This will affect your registered users and non-registered comment authors.

= Can Contributors or Subscribers choose their own WP User Avatar image? =

Yes, if you enable “Allow Contributors & Subscribers to upload avatars" in the WP User Avatar settings. These users will see a slightly different interface because they are allowed only one image upload.

= Will WP User Avatar work with comment author avatars? = 

Yes, for registered users. Non-registered comment authors will show their Gravatar avatars or Default Avatar.

= Will WP User Avatar work with bbPress? = 

Yes!

= Will WP User Avatar work with BuddyPress? =

No, BuddyPress has its own custom avatar functions and WP User Avatar will override only some of them. It’s best to use BuddyPress without WP User Avatar.

= How can I see which users have an avatar? =

For Administrators, WP User Avatar adds a column with avatar thumbnails to your Users list table. If “Show Avatars" is enabled in your WP User Avatar settings, you will see avatars to the left of each username instead of in a new column.

= Can I use the WP User Avatar uploader in a front page or widget? = 

Yes, you can use the [avatar_upload] shortcode to put a standalone uploader in a front page or widget. This uploader is only visible to logged-in users. If you want to integrate the uploader into a profile edit page, see Other Notes.

You can specify a user with the shortcode, but you must have 'edit_user' capability to change the user’s avatar.

`[avatar_upload user="admin"]`

= Can I insert WP User Avatar directly into a post? =

You can use the [avatar] shortcode in your posts. It will detect the author of the post or you can specify an author by username. You can specify a size, alignment, and link, but they are optional. For links, you can link to the original image file, attachment page, or a custom URL.

`[avatar user="admin" size="96" align="left" link="file" /]`

**If you have a caption, the output will be similar to how WordPress adds captions to other images.**

`[avatar user="admin" size="96" align="left" link="file"]Photo Credit: Your Name[/avatar]`

**Note:**If you are using one shortcode without a caption and another shortcode with a caption on the same page, you must close the caption-less shortcode with a forward slash before the closing bracket: [avatar /] instead of [avatar].

= What CSS can I use with WP User Avatar? =

WP User Avatar will add the CSS classes “wp-user-avatar" and “wp-user-avatar-{size}" to your image. If you add an alignment, the corresponding alignment class will be added:

`<?php echo get_wp_user_avatar($user_id, 96, 'left'); ?>`

**Note** “alignleft", “alignright", and aligncenter" are common WordPress CSS classes, but not every theme supports them. Contact the theme author to add those CSS classes.
If you use the values “original", “large", “medium", or “thumbnail", no width or height will be added to the image. This will give you more flexibility to resize the image with CSS:

`<?php echo get_wp_user_avatar($user_id, 'medium'); ?>`

**Note:** WordPress adds more CSS classes to the avatar not listed here.
If you use the [avatar] shortcode, WP User Avatar will add the CSS class “wp-user-avatar-link" to the link. It will also add CSS classes based on link type.


- Image File: wp-user-avatar-file

- Attachment: wp-user-avatar-attachment

- Custom URL: wp-user-avatar-custom

`[avatar user="admin" size="96″ align="left" link="attachment" /]`

= What other functions are available for WP User Avatar? =

- get_wp_user_avatar_src: retrieves just the image URL

- has_wp_user_avatar: checks if the user has a WP User Avatar image

- [See example usage here](https://wordpress.org/extend/plugins/wp-user-avatar/installation/)



== Changelog ==

= 1.2.2 =
- **IMPROVEMENT** - Sanitize the shortcode attributes

= 1.2.1 =
- **IMPROVEMENT** - Code Optimization

= 1.2 =
- Compatible & Tested upto WordPress 6.3+

= 1.1 =
- **FIX** - Shortcode not working in some cases

= 1.0 =
- **Initial release**

== Upgrade Notice ==

= 1.0 =
* Initial release

= 1.1 =
* Bug fixes