<?php
/**
 * S7Ncms - www.s7n.de
 * 
 * Copyright (c) 2006, Eduard Baun
 * All rights reserved.
 * 
 * See license.txt for full text and disclaimer
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @copyright Eduard Baun, 2006
 * @version $Id$
 */

/**
 * Internationalization class
 */
class S7N_I18n {
    /**
     * Here you have an assoc. array of translation strings
     *
     * @var array
     */
    private $translation;
    
    public function __construct() {
        $cachepath = BASE_PATH.'/cache/'.LANGUAGE.'.mo.php';
        $mopath = BASE_PATH.'/lang/'.LANGUAGE.'.mo';
        
        if(file_exists($cachepath)) {
            include_once($cachepath);
        } else {
            $this->cacheTranslation($cachepath,$mopath);
        }
        
        
        
        if (!isset($timestamp) OR $timestamp < filemtime($mopath)) {
			$this->cacheTranslation($cachepath,$mopath);
        } else {
            if(isset($translation)) {
                $this->translation = & $translation;
            } else {
                $this->cacheTranslation($cachepath,$mopath);
            }
        }
    }
    
    /**
     * Parses gettext .mo files
     * 
     * Translated method read_mo from the Perl module Locale::Maketext::Gettext
     * @see http://www.gnu.org/software/gettext/manual/html_mono/gettext.html#SEC136
     *
     * @return array associative array with translations
     */
    private function parseMo() {
        /*
         * TODO: gucken, ob file existiert
         */
        $content = file_get_contents(BASE_PATH.'/lang/'.LANGUAGE.'.mo');
	    $fileSize = strlen($content);
	    
	    // Find the byte order of the MO file creator
	    $byteOrder = substr($content, 0, 4);
	    
	    // Little endian
	    if ($byteOrder == "\xde\x12\x04\x95") {
	    	$tmpl = "V";
	    // Big endian
	    } elseif ($byteOrder == "\x95\x04\x12\xde") {
	        $tmpl = "N";
	    // Wrong magic number.  Not a valid MO file.
	    } else {
	        return 'wrong magic number';
	    }
	    
	    // Check the MO format revision number
	    $revision = unpack($tmpl, substr($content, 4, 4));
	    if ($revision[1] > 0) return 'wrong revision';
	    
	    // Number of strings
	    $numberOfStrings = unpack($tmpl, substr($content, 8, 4));
	    
	    // Offset to the beginning of the original strings
	    $offo = unpack($tmpl, substr($content, 12, 4));
	    
	    // Offset to the beginning of the translated strings
	    $offt = unpack($tmpl, substr($content, 16, 4));
	    
	    $trans = array();
	    for ($i = 0; $i < $numberOfStrings[1]; $i++) {
	        // The first word is the length of the string
	        $len = unpack($tmpl, substr($content, $offo[1]+($i*8), 4));
	        
	        // The second word is the offset of the string
	        $off = unpack($tmpl, substr($content, $offo[1]+($i*8)+4, 4));
	        
	        // Original string
	        $stro = substr($content, $off[1], $len[1]);
	        
	        // The first word is the length of the string
	        $len = unpack($tmpl, substr($content, $offt[1]+($i*8), 4));
	        
	        // The second word is the offset of the string
	        $off = unpack($tmpl, substr($content, $offt[1]+($i*8)+4, 4));
	        
	        // Translated string
	        $strt = substr($content, $off[1], $len[1]);
	                
	        // Hash it baby
	        $trans[$stro] = $strt;
	        
	    }
	    
	    return $trans;
    }
    
    public function _($string,$param1=null) {
        if (array_key_exists($string,$this->translation)) {
        	return $param1 ? sprintf($this->translation[$string],$param1) : $this->translation[$string];
        } else {
            return $param1 ? sprintf($string,$param1) : $string;
        }
    }
    
    public function getTranslation() {
        return $this->translation;
    }
    
    private function cacheTranslation($cachepath, $mopath) {
        $this->translation = $this->parseMo();
		touch($cachepath);
		
		file_put_contents($cachepath, '<?php $timestamp = '.filemtime($mopath).'; $translation='. var_export($this->translation,1) .' ?>');
    }
}
?>