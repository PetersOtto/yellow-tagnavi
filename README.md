# yellow-tagnavi
Extension for Datenstrom Yellow. This extension creates a navigation from the blogtags.

<p align="center"><img src="screenshot-tagnavi.jpg?raw=true" alt="Bildschirmfoto"></p>

## Some words from me
I developed this extension because I needed a solution for one of my projects.  
This extension works, but is not perfectly worked out. 

Feel free to make this extension better :)

## How to use the Yellow tagNavi extension

1. Insert the following code in a suitable place in your `start-blog.html`.
```
<?php $url = $this->yellow->page->getBase(); $urlArg = $this->yellow->toolbox->getLocationArguments(); echo $this->yellow->extension->get("tagnavi")->getTagNavi("/" , "0" , "tagnavi" , "All Projects" , $url, $urlArg)?>

```
The following parameters can be adjusted:
`getTagNavi("1" , "2" , "3" , "4" , $url)?>`

* 1 = location of blog start page (/ or /blog/ or ...)
* 2 = number of entries to show per shortcut, 0 for unlimited
* 3 = Name for the css class
* 4 = Name for the link that displays all blog entries. (All or All Projects or ...)

2. Make adjustments in `css` or `scss`. Here is an `scss` example:

```
.tagnavi{
  ul{
    padding-left: 0;
  }
  li{
    display: inline-block;
    padding-right: 2rem;
  }
  a{
    text-decoration: none;
    &:hover{
      text-decoration: underline;
    }
  }
  a.active{
    text-decoration: underline;
  }
}
```

3. This extension requires the blog extension.


## Installation

[Download extension](https://github.com/PetersOtto/yellow-tagnavi/archive/refs/heads/main.zip) and copy zip file into your `system/extensions` folder. Right click if you use Safari.

## Developer

PetersOtto. [Get help](https://datenstrom.se/yellow/help/)
