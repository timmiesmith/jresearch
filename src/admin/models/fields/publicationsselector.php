<?php
/**
* @package	J!Research
* @subpackage	Form
* @copyright	Copyright (C) 2008 Luis Galarraga.
* @license	GNU/GPL v2
* Description
*/

defined('_JEXEC') or die( 'Restricted access' );

/**
 * Form Field class for the Joomla Platform.
 * Provides a modal media selector including upload mechanism
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldPublicationsselector extends JFormField
{
    /**
     * The form field type.
     *
     * @var    string
     * @since  11.1
     */
    protected $type = 'Media';

    /**
     * The initialised state of the document object.
     *
     * @var    boolean
     * @since  11.1
     */
    protected static $initialised = false;

    /**
     * Method to get the field input markup for a media selector.
     * Use attributes to identify specific created_by and asset_id fields
     *
     * @return  string  The field input markup.
     *
     * @since   11.1
     */
    protected function getInput()
    {
        $document = JFactory::getDocument();
        $assetField = $this->element['asset_field'] ? (string) $this->element['asset_field'] : 'asset_id';
        $asset = $this->form->getValue($assetField) ? $this->form->getValue($assetField) : (string) $this->element['asset_id'];
        if ($asset == '') {
            $asset = JRequest::getCmd('option');
        }

        $link = (string) $this->element['link'];
        if (!self::$initialised) {
            // Load the modal behavior script.
            JHtml::_('behavior.modal');

            // Build the script.
            $script = array();
            $script[] = '	function jInsertFieldValue(value, id) {';
            $script[] = '		var old_id = document.id(id).value;';
            $script[] = '		if (old_id != id) {';
            $script[] = '			var elem = document.id(id)';
            $script[] = '			elem.value = value;';
            $script[] = '			elem.fireEvent("change");';
            $script[] = '		}';
            $script[] = '	}';

            // Add the script to the document head.
            $document->addScriptDeclaration(implode("\n", $script));            
            
            $script2 = array();
            $script2[] = '	function jUpdateLink(aTag, id) {';
            $script2[] = '		var value = document.id(id).value;';
            $script2[] = '		aTag.href = aTag.href + "&value=" + value;';
            $script2[] = '	}';
            $document->addScriptDeclaration(implode("\n", $script2));            
            
            self::$initialised = true;
        }

        // Initialize variables.
        $html = array();
        $attr = '';

        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
        $attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';

        // Initialize JavaScript field attributes.
        $attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

        // The text field.
        $html[] = '<div class="fltlft">';
        $html[] = '	<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="'
                . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . ' readonly="readonly"' . $attr . ' />';
        $html[] = '</div>';

        $directory = (string) $this->element['directory'];
        if ($this->value && file_exists(JPATH_ROOT . DS . $this->value)) {
            $folder = explode(DS, $this->value);
            array_shift($folder);
            array_pop($folder);
            $folder = implode(DS, $folder);
        }
        elseif (file_exists(JPATH_ROOT . DS . JComponentHelper::getParams('com_media')->get('image_path', 'images') . DS . $directory)) {
            $folder = $directory;
        } else {
            $folder = '';
        }
        
        // The button.
        $html[] = '<span class="button2-left" style="margin-right: 10px;">';
        $html[] = '	<span class="blank">';
        $html[] = '		<a class="modal" id="'.$this->id.'_select" title="'. JText::_('JLIB_FORM_BUTTON_SELECT') . '"' . ' href="'
                . ($this->element['readonly'] ? ''
                : ($link ? $link
                        : 'index.php?option=com_jresearch&amp;controller=publications&amp;task=citeFromForm&amp;tmpl=component') 
                . '&amp;fieldid=' . $this->id) . '"'
                . ' onclick="javascript:jUpdateLink(this, document.id(\''.$this->id.'\'));"'
                . ' rel="{handler: \'iframe\', size: {x: 800, y: 500}}">';
        $html[] = JText::_('JLIB_FORM_BUTTON_SELECT') . '</a>';
        $html[] = '	</span>';
        $html[] = '</span>';

        $html[] = '<span class="button2-left">';
        $html[] = '	<span class="blank">';
        $html[] = '		<a title="' . JText::_('JLIB_FORM_BUTTON_CLEAR') . '"' . ' href="#" onclick="';
        $html[] = 'document.id(\'' . $this->id . '\').value=\'\';';
        $html[] = 'document.id(\'' . $this->id . '\').fireEvent(\'change\');';
        $html[] = 'return false;';
        $html[] = '">';
        $html[] = JText::_('JLIB_FORM_BUTTON_CLEAR') . '</a>';
        $html[] = '	</span>';
        $html[] = '</span>';

        return implode("\n", $html);
    }
}