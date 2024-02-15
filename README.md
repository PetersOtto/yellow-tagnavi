# yellow-tagnavi
Extension for Datenstrom Yellow. This extension creates a navigation from the blogtags. If wanted, then with number of posts.

<p align="center"><img src="screenshot-yellow-tagnavi.jpg?raw=true" alt="Bildschirmfoto"></p>

## How to use the Yellow tagNavi extension

1. [Download extension](https://github.com/PetersOtto/yellow-tagnavi/archive/refs/heads/main.zip) and copy zip file into your `system/extensions` folder. Right click if you use Safari.

2. Insert the following code in a suitable place in your `start-blog.html`.

```
<?php $url = $this->yellow->page->getBase(); $urlArg = $this->yellow->toolbox->getLocationArguments(); echo $this->yellow->extension->get("tagnavi")->getTagNavi("/blog/" , "count" , "0" , "tagnavi" , "All Projects" , $url, $urlArg)?>
```
The following parameters can be adjusted:
`getTagNavi("1" , "2" , "3" , "4" , "5" , $url, $urlArg)?>`

* 1 = location of blog start page (/ or /blog/ or ...)
* 2 = switch on the »Counter Mode« (count for count, nocount for no count)
* 3 = number of entries to show, 0 for unlimited
* 4 = name for the css class
* 5 = name for the link that displays all blog entries. (All or All Projects or ...)

3. Make adjustments in `css`. Here is a basic example. Paste the code into your `css-file`, e.g. at the end of your `stockholm.css`.
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

4. This extension requires the blog extension.


## Developer

PetersOtto. [Get help](https://datenstrom.se/yellow/help/)
