<?php
/**
* @version		$Id$
* @package		JResearch
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license		GNU/GPL
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jresearchimport('tables.table', 'jresearch.admin');

/**
 * This class defines the base for all sources of activity in a center 
 * like publications, projects and theses. All of them have association with 
 * groups of members.
 *
 */
class JResearchActivity extends JResearchTable{	
    /**
     * String for alias
     *
     * @var string
     */
    public $alias;

    /**
    * @var string
    */
    public $title;


    /**
     * Date of creation
     *
     * @var datetime
     */
    public $created;		

    /**
     * URL associated to the activity
     *
     * @var string
     */
    public $url;

    /**
     * List of relative paths (in relation to site base path)
     * associated to the activity, separated by semicolons.
     *
     * @var string
     */
    public $files;

    /**
     * Research areas ids
     *
     * @var string
     */
    public $id_research_area;	


    /**
     * User id of the person who blocked the item. 0 if the item is not blocked.
     *
     * @var int
     */
    public $checked_out;	

    /**
     * @var unknown_type
     */
    public $checked_out_time;

    /**
     * Holds the id of the user who created the publication.
     *
     * @var string
     */
    public $created_by;

    /**
     * Number of hits for the activity
     *
     * @var int
     */
    public $hits;

    /**
     * 
     * String storing either author names or staff ids separated by commas
     * @var string
     */
    public $authors;

    /**
     * 
     * Link to the entry with the access rules
     * @var int
     */
    public $asset_id;


    /**
     * Cache for list of authors 
     *
     * @var array
     */
    protected $_authorsArray;
    
    /**
     * Cache for list of attachments
     * 
     * @var type 
     */
    protected $_attachmentsArray;


    /**
     * Name used by subtypes.
     *
     * @var string
     */
    protected $_type;


    /**
     * Cache for the list of research areas associated to the
     * object
     */
    protected $_areas;	
    
    /**
     * Keywords delimiter both in database and forms
     * @var string 
     */
    public static $_keywordsDelimiter = ';';

    /**
     * Authors delimiter both in database and forms
     * @var string 
     */
    public static $_authorsDelimiter = ';';
    
    public static $_authorsIdDelimiter = '|';
    
    public static $_attachmentsPartsDelimiter = '|';
    
    public static $_attachmentsDelimiter = ';';

    public function __construct($table, $key, $db ){
        parent::__construct($table, $key, $db);
    }


    /**
     * Loads the information about internal and external authors.
     *
     */
    protected function _loadAuthors(){
        jresearchimport('helpers.staff', 'jresearch.admin');
        $db = $this->getDBO();

        $query = 'SELECT '.$db->quoteName('id').' FROM 
        (SELECT '.$db->quoteName('id_staff_member').' as id, '.$db->quoteName('order').' FROM #__jresearch_publication_internal_author 
        WHERE '.$db->quoteName("id_".$this->_type).' = '.$db->Quote($this->id).' UNION 
        (SELECT '.$db->quoteName('author_name').' as id, '.$db->quoteName('order').' FROM #__jresearch_publication_external_author
        WHERE '.$db->quoteName("id_".$this->_type).' = '.$db->Quote($this->id).')) R1 order by R1.'.$db->quoteName('order');

        $db->setQuery($query);
        $result = $db->loadColumn();
        $finalResult = array();
        foreach ($result as $entry) {
            if (is_numeric($entry)) {
                $finalResult[] = $entry.self::$_authorsIdDelimiter
                        .JResearchStaffHelper::getMemberName($entry);
            } else {
                $finalResult[] = $entry;
            }
        }

        $this->authors = implode(self::$_authorsDelimiter, $finalResult);
    }

    /**
     * Internal method that extracts a list of authors encoded in a text fields
     * and puts them in the given array field.
     * 
     * @param type $textField
     * @param type $arrayField
     */
    protected function getAuthorsFromFields($textField, &$arrayField) {
        if(empty($arrayField)){
            $arrayField = array();

            if(!empty($textField))
                $tmpAuthorsArray = explode(self::$_authorsDelimiter, $textField);
            else
                $tmpAuthorsArray = array();

            foreach($tmpAuthorsArray as $author){
                $authorText = null;
                //Search for the position separator
                if(strpos($author, self::$_authorsIdDelimiter) !== false){
                    $tmpArray = explode(self::$_authorsIdDelimiter, $author);
                    $authorText = $tmpArray[0];
                }else{
                    $authorText = $author;
                }

                if(is_numeric($authorText)){
                    JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_jresearch/tables');
                    $member = JTable::getInstance('Member', 'JResearch');
                    $member->load((int)$authorText);
                    $arrayField[] = $member;
                }else{
                    $arrayField[] = $authorText;
                }
            }
        }

        return $arrayField;
    }
    

    /**
     * Returns the complete list of authors (internal and externals) suitably ordered. 
     * Internal authors are displayed in format [lastname, firstname].
     * External authors are taken as they appear in the database.
     * 
     * @return array Array of mixed elements. Internal authors are instances of 
     * JResearchMember. External ones are strings.
     */
    public function getAuthors(){
        return $this->getAuthorsFromFields($this->authors, $this->_authorsArray);
    }

    /**
     * 
     * Adds an author to the activity
     * @param mixed If $author is a integer or numeric string it is consider as the id
     * of a J!Research member, otherwise it is considered as an external author.
     * If it is a JResearchMember, only its id is used.
     */
    public function addAuthor($author){		
        $textToAppend = '';
        $this->_authorsArray = null;

        if($author instanceof JResearchMember) {
            $textToAppend = $author->id.self::$_authorsIdDelimiter.$author->__toString();
        }elseif(!empty($author)){
            $textToAppend = $author;
        }else{
            return false;
        }

        if(!empty($this->authors))
            $this->authors .= self::$_authorsDelimiter.$textToAppend;
        else
            $this->authors = $textToAppend;	

        return true;	
    }

    /**
     * Returns the author with the index specified. In publications records, the order
     * in which authors are displayed is important.
     * 
     * @param int $index Must be equal or greater than 0 and less than the number of authors.
     * @return mixed string with the name of the author when external.
     * JResearchMember instance when the author is internal.
     * null when the index does not make sense (e.g the publication has 3 authors and $index=4 or $index<0)
     */
    public function getAuthor($index){		
        $this->getAuthors();
        return $this->_authorsArray[$index];
    }

    /**
     * Returns a sorted array with the information of the publication's internal authors.
     * Internal authors are part of the center's staff so they are represented by
     * objects of class JResearchMember
     * @return array Associative array of JResearchMember objects as values and order parameter
     * as key.
     */
    public function getInternalAuthors(){
        $this->getAuthors();

        $internalsArray = array();
        $index = 0;

        foreach($this->_authorsArray as $author){
            if($author instanceof JResearchMember){
                $internalsArray[$index] = $author; 
            }			
            $index++;
        }

        return $internalsArray;		
    }

    /**
     * Returns a sorted array with the information of the publication's external authors.
     * External authors are not part of the center's staff so they are represented as strings
     * @return array Associative array, where the order is the key and the 
     * author's name, the value.
     */
    public function getExternalAuthors(){
        $this->getAuthors();

        $externalsArray = array();
        $index = 0;

        foreach($this->_authorsArray as $author){
            if(is_string($author)){
                $externalsArray[$index] = $author; 
            }			
            $index++;
        }

        return $externalsArray;
    }

    /**
     * Resets the default properties.
     *
     */
    public function reset(){
        parent::reset();
        $this->_authorsArray = null;
        $this->_areas = null;
    }

    /**
     * Returns the number of authors of the publication.
     *
     * @return int
     */
    public function countAuthors(){
        if(!empty($this->_authorsArray)){
            return count($this->_authorsArray);
        }else{
            return count(explode(self::$_authorsDelimiter, $this->authors));
        }	
    }

    /**
     * Verifies the integrity of the authors names and ids.
     * 
     * @return boolean False if a person appears as author more than once or 
     * invalid author names are provided.
     */
    public function checkAuthors(){
        return true;
    } 
    
    /**
     * 
     * @param type $controller
     * @return type
     */
    protected function getAttachmentsByController($controller) {
        if (!isset($this->_attachmentsArray)) {
            $this->_attachmentsArray = array();
            $params = JComponentHelper::getParams('com_jresearch'); 
            if(!empty($this->files)){
                $filesArr = explode(self::$_attachmentsDelimiter, trim($this->files));
                foreach ($filesArr as $file) {
                    if (empty($file)) {
                        continue;
                    }
                    $fileParts = explode(self::$_attachmentsPartsDelimiter, $file);
                    $entry = array();
                    if (JResearchUtilities::isValidURL($fileParts[0])) {
                        $entry['url'] = $fileParts[0];
                    } else {
                        $entry['url'] = JURI::root().'administrator/components/com_jresearch/'.str_replace(DS, DS, $params->get('files_root_path', 'files'))."/$controller/".$fileParts[0];
                    }
                    if (isset($fileParts[1])) {
                        $entry['tag'] = $fileParts[1];
                    } else {
                        $entry['tag'] = '';                        
                    }
                    $this->_attachmentsArray[] = $entry;
                }
            }
        }
        
        return $this->_attachmentsArray;
    }
    
    /**
     * Must be implemented in the subclasses. It returns an array of attachments
     * associated to the item.
     * @return type
     */
    public function getAttachments() {
        return array();
    }
    
    /**
     * Returns the attachment associated to the given tag.
     * @param type $tag
     * @return type
     */
    public function getAttachment($tag) {
        return null;
    }
    
    /**
     * Adds an attachment to the object. An attachement can be a relative path
     * to a file in the server or a URL. The tag is human readable label associated
     * to the attachment. 
     * @param type $attachment
     * @param type $tag
     */
    public function addAttachment($attachment, $tag) {
        if ($this->files == null) {
            $this->files = $attachment.'|'.$tag;
        } else {
            $this->files .= $attachment.'|'.$tag;
        }
    }

    /**
     * Returns the number of activity's attached files.
     *
     * @return int
     */
    public function countAttachments(){
        if(empty($this->files))
            return 0;
        else{
            return count(explode(';', trim($this->files)));
        }	
    }
    

    /**
    * Removes related information related to an activity (not the activity per se as it is done
    * in the child classes) from database. 
    * 
    * @param $oid Publication id
    * @return true if success.
    */	
    public function delete($oid = null){
        $db = JFactory::getDBO();
        $k = $this->_tbl_key;
        $oid = (is_null($oid)) ? $this->$k : $oid;			
        $result = parent::delete($oid);

        if(!$result)
            return $result;

        $internalTable = $db->quoteName('#__jresearch_'.$this->_type.'_internal_author');
        $externalTable = $db->quoteName('#__jresearch_'.$this->_type.'_external_author');
        $areasTable = $db->quoteName('#__jresearch_'.$this->_type.'_research_area');

        $db->setQuery('DELETE FROM '.$internalTable.' WHERE '.$db->quoteName('id_'.$this->_type).' = '.$db->Quote($oid));		
        if(!$db->query()){
            $this->setError(get_class( $this ).'::store failed - '.$db->getErrorMsg());
            return false;
        }

        $db->setQuery('DELETE FROM '.$externalTable.' WHERE '.$db->quoteName('id_'.$this->_type).' = '.$db->Quote($oid));		
        if(!$db->query()){
            $this->setError(get_class( $this ).'::store failed - '.$db->getErrorMsg());
            return false;
        }

        $db->setQuery('DELETE FROM '.$areasTable.' WHERE '.$db->quoteName('id_'.$this->_type).' = '.$db->Quote($oid));
        if(!$db->query()){
            $this->setError(get_class( $this ).'::store failed - '.$db->getErrorMsg());
            return false;
        }		

        return true;
    }

    /**
     * 
     * Returns an array with the research area objects associated to 
     * the activity.
     * @param string $whatInfo "all" to bring the entire list of objects,
     * "names" to bring only the names.
     * @return Array of JResearchResearcharea objects or stdobjects containing ids and names
     */
    function getResearchAreas($whatInfo = 'all'){
        $db = JFactory::getDBO();

        if($whatInfo == 'all') {
            if(!isset($this->_areas)){
                $this->_areas = array();
                $db->setQuery('SELECT * FROM #__jresearch_research_area WHERE id IN ('.$this->id_research_area.') AND id > 1');				
                $areas = $db->loadAssocList();		
                foreach($areas as $row){
                    $area = JTable::getInstance('Researcharea', 'JResearch');
                    $area->bind($row);
                    $this->_areas[] = $area;
                }
            }			
            return $this->_areas;			
        } elseif($whatInfo == 'basic') {
            $db->setQuery('SELECT id, name, published FROM #__jresearch_research_area WHERE id IN ('.$this->id_research_area.') AND id > 1');
            return $db->loadObjectList();
        } elseif($whatInfo == 'names') {
            $db->setQuery('SELECT name FROM #__jresearch_research_area WHERE id IN ('.$this->id_research_area.') AND id > 1');
            return $db->loadColumn();
        } else {
            return null;
        }		
    }


    /**
     * Method to compute the default name of the asset.
     * The default name is in the form `table_name.id`
     * where id is the value of the primary key of the table.
     *
     * @return	string
     * @since	1.6
     */
    protected function _getAssetName()
    {
        $k = $this->_tbl_key;
        return 'com_jresearch.'.$this->_type.'.'.(int) $this->$k;
    }

    /**
     * Method to return the title to use for the asset table.
     *
     * @return	string
     * @since	1.6
     */
    protected function _getAssetTitle()
    {
        return $this->__toString();
    }

    /**
     * String representation
     * @see trunk/src/admin/tables/JResearchTable::__toString()
     */
    public function __toString(){
        return $this->title;
    }
	
}

?>
