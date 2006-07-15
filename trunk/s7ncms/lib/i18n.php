<?php
/**
 * S7Ncms
 * 
 * @author Eduard Baun <edy@edy-b.de>
 * @license http://creativecommons.org/licenses/by-nc-nd/2.0/de/ Creative Commons Attribution-NonCommercial-NoDerivs 2.0
 * @version $Id$
 * @copyright Eduard Baun, 2006
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
        /* 
         * TODO: i18n init
         * - checken, ob cachefile da ist
         * - wenn nicht, neue anlegen
         * - wenn doch, laden
         * 
         * - gucken, ob die X.mo vorhanden und aktueller ist, als timestamp
         * - wenn nicht, fertig
         * - wenn aktueller, dann parser anschmeißen, neue cachefile generieren
         * - das neu erzeugte array benutzen
         * - fertig
         */
        $cachepath = BASE_PATH.'/cache/'.LANGUAGE.'.mo.php';
        if(file_exists($cachepath)) {
            include_once($cachepath);
            //$this->translation = & $translation;
        } else {
            touch($cachepath);
        }
        
        $mopath = BASE_PATH.'/lang/'.LANGUAGE.'.mo';
        
        if (!isset($timestamp) OR $timestamp < filemtime($mopath)) {
			$this->translation = $this->parseMo();
			file_put_contents($cachepath, '<?php $timestamp = '.filemtime($mopath).'; $translation='. var_export($this->translation,1) .' ?>');
        } else {
            $this->translation = & $translation;
        }
    }
    
    /**
     * Parses gettext .mo files
     * 
     * Translated method read_mo from the Perl module Locale::Maketext::Gettext
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
}
?>