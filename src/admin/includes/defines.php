<?php
define('_COOPERATION_IMAGE_MAX_WIDTH_', 1024);
define('_COOPERATION_IMAGE_MAX_HEIGHT_', 768);

define('_FACILITY_IMAGE_MAX_WIDTH_', 1024);
define('_FACILITY_IMAGE_MAX_HEIGHT_', 768);

define('_PROJECT_IMAGE_MAX_WIDTH_', 1024);
define('_PROJECT_IMAGE_MAX_HEIGHT_', 768);

define('_MEMBER_IMAGE_MAX_WIDTH_', 1024);
define('_MEMBER_IMAGE_MAX_HEIGHT_', 768);

define('_JRESEARCH_VERSION_', '1.2 Beta 2');
define('_JRESEARCH_BIBUTILS_VERSION_', '4.8 for Unix, 4.2 for Windows, 4.9 for Unix x86/64');

if (!defined('PHP_EOL'))
{
    switch (strtoupper(substr(PHP_OS, 0, 3)))
    {
        // Windows
        case 'WIN':
            define('PHP_EOL', "\r\n");
            break;

        // Mac
        case 'DAR':
            define('PHP_EOL', "\r");
            break;

        // Unix
        default:
            define('PHP_EOL', "\n");
    }
}
?>