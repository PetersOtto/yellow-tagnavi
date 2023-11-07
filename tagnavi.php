<?php
class YellowTagNavi
{
    const VERSION = "0.8.04";
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
        $pages = $this->yellow->content->index()->filter("layout", "blog")->sort("published", false);
        $tags = $pages->group("tag"); // = group content by tag with ascending name, A-Z
        // $tags = $pages->group("tag", false); // = group content by tag with descending name, Z-A
        // $tags = $pages->group("tag", false, "count"); // = group content by tag with descending count, highest first
        $url = $url.$startLocation.$urlArg;
        
        if (strpos($urlArg, "age:")) {
            $pageNr = explode("page:", $urlArg);
            $urlPagination = "page:" . $pageNr[1];
        } else{
            $urlPagination = "";
        }
        
        if (!is_array_empty($tags)) {
            if ($entriesMax != 0 && count($tags) > $entriesMax) {
                $tags = array_slice($tags, -$entriesMax, $entriesMax, true);
            }
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
}
