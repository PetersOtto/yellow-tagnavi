# yellow-tagnavi
Extension for Datenstrom Yellow. This extension creates a navigation from the blogtags. If wanted, then with number of posts.

<p align="center"><img src="screenshot-yellow-tagnavi.jpg?raw=true" alt="Bildschirmfoto"></p>

## How to use the Yellow tagNavi extension

1. [Download extension](https://github.com/PetersOtto/yellow-tagnavi/archive/refs/heads/main.zip) and copy zip file into your `system/extensions` folder. Right click if you use Safari.

### Variant A: Standalone navigation (recommended)
2a. Go to `\system\extensions\yellow-system.ini` and choose `TagnaviInsideNavi: 0`.
3a. Insert the following code in a suitable place in your `blog-start.html`.

```
<?php $blogLocation = $this->yellow->page->location; $url = $this->yellow->page->getBase(); $urlArg = $this->yellow->toolbox->getLocationArguments(); echo $this->yellow->extension->get("tagnavi")->getTagNavi($blogLocation , "count" , "0" , "tagnavi" , "All Projects" , $url, $urlArg)?>
```
4a. Go to `\system\extensions\yellow-system.ini` and choose your filter name vor all entries `TagnaviFilterName: All Projects`.
5a. Make adjustments in `css`. Here is a basic example. Paste the code into your `css-file`, e.g. at the end of your `stockholm.css`.

```
.tagnavi ul {
    padding-left: 0;
}

.tagnavi li {
    display: inline-block;
    padding-right: 1rem;
}

.tagnavi a {
    text-decoration: none;
}

.tagnavi a:hover {
    text-decoration: underline;
}

.tagnavi a.active {
    text-decoration: underline;
}

.tagnavi span {
    vertical-align: super;
    color: var(--link);
}

.tagnavi span::before {
    content: "(";
    padding-left: 0.2rem;
}

.tagnavi span::after {
    content: ")";
}
```

### Variant B: Inside existing navigation
If you choose this option, several other changes to the theme are often necessary. Take a look at my [Ibbtown theme](https://github.com/PetersOtto/yellow-Ibbtown), where I did it this way.
2b. Go to `\system\extensions\yellow-system.ini` and choose `TagnaviInsideNavi: 1`.
3b. Insert the following code at the right place in your `navigation.html`.

```
<?php 
$checkLayout = $this->yellow->page->getHtml("layout");
$blogLocation = $this->yellow->page->location;
if ($checkLayout == "blog-start"){ 
    $url = $this->yellow->page->getBase();
    $urlArg = $this->yellow->toolbox->getLocationArguments();
    echo $this->yellow->extension->get("tagnavi")->getTagNavi($blogLocation , "count" , "0" , "tagnavi" , $url, $urlArg);
}?>
```

4b. Make adjustments in your `scss` or `css` file.
5b. Go to `\system\extensions\yellow-system.ini` and choose your filter name vor all entries `TagnaviFilterName: All Projects`.

### Settings
The following parameters can be adjusted:
`getTagNavi("1" , "2" , "3" , "4" , "5" , $url, $urlArg)?>`

* 1 = location of blog start page ($blogLocation or / or /blog/ or ...)
* 2 = switch on the »Counter Mode« (count for count, nocount for no count)
* 3 = number of entries to show, 0 for unlimited
* 4 = name for the css class

## Dependencies
This extension requires the blog extension.

## Developer
PetersOtto.
