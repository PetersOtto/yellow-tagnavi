<?php
class YellowTagNavi
{
    const VERSION = "0.8.02";
    public $yellow; // access to API

    // Handle initialisation
    public function onLoad($yellow)
    {
        $this->yellow = $yellow;
    }

    // Return a blogtag navigation
    public function getTagNavi($startLocation, $entriesMax, $class, $filterName, $url, $urlArg)
    {
        $output = null;
        $blogStart = $this->yellow->content->find($startLocation);
        $pages = $this->getBlogPages($startLocation);
        $tags = $this->getMeta($pages, "tag");
        $url = $url.$startLocation.$urlArg;
        
        if (strpos($urlArg, "age:")) {
            $pageNr = explode("page:", $urlArg);
            $urlPagination = "page:" . $pageNr[1];
        } else{
            $urlPagination = "";
        }
        
        if (!is_array_empty($tags)) {
            $tags = $this->yellow->lookup->normaliseArray($tags);
            if ($entriesMax != 0 && count($tags) > $entriesMax) {
                uasort($tags, "strnatcasecmp");
                $tags = array_slice($tags, -$entriesMax, $entriesMax, true);
            }
            uksort($tags, "strnatcasecmp");
            $output = "<div class=\"" . htmlspecialchars($class) . "\">\n";
            $output .= "<ul>\n";
            if ($url == $blogStart->getLocation(true). $urlPagination){
                $output .= "<li><a class=\"active\" aria-current=\"page\" href=\"" . $blogStart->getLocation(true) . "\">";
                $output .= htmlspecialchars($filterName) . "</a></li>\n";
            }else{
                $output .= "<li><a href=\"" . $blogStart->getLocation(true) . "\">";
                $output .= htmlspecialchars($filterName) . "</a></li>\n";
            }
            foreach ($tags as $key => $value) {
                $urlNavi = $blogStart->getLocation(true) . $this->yellow->lookup->normaliseArguments("tag:$key");
                if ($url == $urlNavi.$urlPagination){
                    $output .= "<li><a class=\"active\" aria-current=\"page\" href=\"" . $urlNavi . "\">";
                    $output .= htmlspecialchars($key) . "</a></li>\n";
                } else {
                    $output .= "<li><a href=\"" . $urlNavi . "\">";
                    $output .= htmlspecialchars($key) . "</a></li>\n";
                }
            }
            $output .= "</ul>\n";
            $output .= "</div>\n";
        } else {
            $output = "The location of your blog start page is wrong (/ or /blog/ or ...)";
        }
        return $output;
    }
// Return blog pages
    public function getBlogPages($location) {
        $pages = $this->yellow->content->clean();
        $blogStart = $this->yellow->content->find($location);
        if ($blogStart && $blogStart->get("layout")=="blog-start") {
            if ($this->yellow->system->get("blogStartLocation")!="auto") {
                $pages = $this->yellow->content->index();
            } else {
                $pages = $blogStart->getChildren();
            }
            $pages->filter("layout", "blog");
        }
        return $pages;
    }

    // Return meta data from page collection
    public function getMeta($pages, $key) {
        $data = array();
        foreach ($pages as $page) {
            if ($page->isExisting($key)) {
                foreach (preg_split("/\s*,\s*/", $page->get($key)) as $entry) {
                    if (!isset($data[$entry])) $data[$entry] = 0;
                    ++$data[$entry];
                }
            }
        }
        return $data;
    }
}
