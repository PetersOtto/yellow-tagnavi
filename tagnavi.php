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
    public function getTagNavi($startLocation, $entriesMax, $class, $filterName, $url)
    {
        $output = null;
        $blogStart = $this->yellow->content->find($startLocation);
        $pages = $this->yellow->extension->get("blog")->getBlogPages($startLocation);
        $tags = $this->yellow->extension->get("blog")->getMeta($pages, "tag");

        if (!is_array_empty($tags)) {
            $tags = $this->yellow->lookup->normaliseArray($tags);
            if ($entriesMax != 0 && count($tags) > $entriesMax) {
                uasort($tags, "strnatcasecmp");
                $tags = array_slice($tags, -$entriesMax, $entriesMax, true);
            }
            uksort($tags, "strnatcasecmp");
            $output = "<div class=\"" . htmlspecialchars($class) . "\">\n";
            $output .= "<ul>\n";
            if ($url == $blogStart->getLocation(true)){
                $output .= "<li><a class=\"active\" aria-current=\"page\" href=\"" . $blogStart->getLocation(true) . "\">";
                $output .= htmlspecialchars($filterName) . "</a></li>\n";
            }else{
                $output .= "<li><a href=\"" . $blogStart->getLocation(true) . "\">";
                $output .= htmlspecialchars($filterName) . "</a></li>\n";
            }
            foreach ($tags as $key => $value) {
                $urlNavi = $blogStart->getLocation(true) . $this->yellow->lookup->normaliseArguments("tag:$key");
                if ($url == $urlNavi){
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
