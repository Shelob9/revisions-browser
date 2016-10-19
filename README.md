# revisions-browser
Front-end revision browser via REST API proof of concept.

Requires: [REST API Version 2.0 develop branch](https://github.com/WP-API/WP-API/tree/develop)

What this does: adds revisions browsing link to top of admin bar when looking at single post and you can edit, with next/previous links.

<img src="https://github.com/Shelob9/revisions-browser/blob/master/CvIKaDdWcAAtRSa.gif?raw=true" alt="Demo GIF">

* Theme Support
The revision browser needs to know the ID attribute of the container with the post title and content. It works with recent WordPress default themes and probably most themes based on _s. By using these defaults:

* #entry-title
* #entry-content 

You can modify these using `add_theme_support()`. For example if your theme uses a container with ID "main-content" for the content and a containter with the ID "post-title" for the title, you could add this to your theme's functions.php:

```
add_action( 'init', function(){
  add_theme_support( 'revision-browser-selectors', array(
    'content' => 'main-content',
    'title' => 'post-title',
   );
});
```
