<?php
class YellowTagNavi
{
    const VERSION = "0.8.01";
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
        $pages = $this->yellow->extension->get("blog")->getBlogPages($startLocation);
        $tags = $this->yellow->extension->get("blog")->getMeta($pages, "tag");
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
            if ($url == $blogStart->getLocation(true). $urlPagination){
                $output .= "<li class=\"nav-item\"><a class=\"nav-link active\" aria-current=\"page\" href=\"" . $blogStart->getLocation(true) . "\">";
                $output .= htmlspecialchars($filterName) . "</a></li>\n";
            }else{
                $output .= "<li class=\"nav-item\"><a class=\"nav-link\" href=\"" . $blogStart->getLocation(true) . "\">";
                $output .= htmlspecialchars($filterName) . "</a></li>\n";
            }
            foreach ($tags as $key => $value) {
                $urlNavi = $blogStart->getLocation(true) . $this->yellow->lookup->normaliseArguments("tag:$key");
                if ($url == $urlNavi.$urlPagination){
                    $output .= "<li class=\"nav-item\"><a class=\"nav-link active\" aria-current=\"page\" href=\"" . $urlNavi . "\">";
                    $output .= htmlspecialchars($key) . "</a></li>\n";
                } else {
                    $output .= "<li class=\"nav-item\" ><a class=\"nav-link\" href=\"" . $urlNavi . "\">";
                    $output .= htmlspecialchars($key) . "</a></li>\n";
                }
            }
        } else {
            $output = "The location of your blog start page is wrong (/ or /blog/ or ...)";
        }
        return $output;
    }
}
