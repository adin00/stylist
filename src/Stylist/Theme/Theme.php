<?php
namespace FloatingPoint\Stylist\Theme;

use File;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class Theme
 *
 * Theme objects are just dumb little DTOs, used as a reference point for collecting information
 * about themes, namely their name, description and parent details.
 *
 * @package FloatingPoint\Stylist\Theme
 */
class Theme implements Arrayable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var null|string
     */
    private $parent;

    /**
     * Absolute path of where the theme can be found on the disk.
     *
     * @var string
     */
    private $path;
    
    private $manifest;
    
    /**
     * Theme just needs to know one thing - where the theme is found. It'll do the rest.
     *
     * @param string $path Absolute path on the filesystem to the theme.
     */
    public function __construct($name, $description, $path, $parent = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->parent = $parent;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Determines whether or not a theme has a parent.
     *
     * @return bool
     */
    public function hasParent()
    {
        return !!$this->parent;
    }

    /**
     * Return the asset path to the theme.
     *
     * @return string
     */
    public function getAssetPath()
    {
        return Str::slug($this->getName());
    }

    /**
     * Returns the theme object as an array, containing all theme information.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
    
    /**
     * @param $url string
     * @return string
     */
    public function addCacheBreaker($url) {
        if(preg_match('/(^[^\?]*)(?:[\?]|$)((?<=\?|&)cache\-break=manifest(?=&|$))/', $url, $parts)){
            // @todo: add file timestamp as cache breaker method
            if($digest = $this->getManifestDigest($parts[1])) {
                $url = str_replace($parts[2], $digest, $url);
            }
        }
        
        return $url;
    }
    
    /**
     * @param $asset
     * @return mixed
     */
    private function getManifestDigest($asset) {
        if(!$this->manifest) {
            //load manifest on first use
	        $manifestFile = public_path("themes/{$this->getAssetPath()}/" .
		        config('stylist.themes.manifest', 'manifest.json'));
	        if(file_exists($manifestFile)) {
	            $this->manifest = json_decode(file_get_contents($manifestFile));
	        }
	        
	        //if there is any error make it empty object
	        if(!$this->manifest) {
		        $this->manifest = (object) array();
	        }
        }
        
        return isset($this->manifest->{$asset}) ? $this->manifest->{$asset} : false;
    }
    
}
