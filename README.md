# static-html-output-post-deploy-rewrite

VERSION 1.0
- For use with Static HTML Output plugin ([https://github.com/WP2Static/static-html-output-plugin](https://github.com/WP2Static/static-html-output-plugin)).
- Resolves issue described here: [https://github.com/WP2Static/static-html-output-plugin/issues/94](https://github.com/WP2Static/static-html-output-plugin/issues/94)
- Works with input form data from WP admin > Static HTML > Processing > Rewrite Links in source code ("rewrite_rules" field)
- Works with WP Multi
- Does not work w/ CLI (but could be modified to do so) as it uses the form submission post data.
- Final output may break the functionality of your live WP static output (/wp-content/uploads/static-html-output/index.html)


View logs at: 

> mydomain.com/wp-content/uploads/post-deploy-rewrite.txt

...or, in the case of WP Multi, the "3" below represents site number:

> mydomain.com/wp-content/uploads/sites/3/post-deploy-rewrite.txt


**For super-clean, non-Wordpressy output, try:**

WP Admin > Static HTML > Processing

Rewrite Links in source code:
```
wp-content/,content/
content/themes/,contents/ui/
content/ui/_mytheme_/,content/ui/
wp-includes/,inc/
```

Rename Exported Directories:
```
wp-content,content
content/themes,content/ui
content/ui/_mytheme_,content/ui
wp-includes/,inc/
```
