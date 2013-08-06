<?php
namespace system\basic\view;

/**
 * Class TemplateEngineAdapter
 * @package system\basic\view
 */
abstract class TemplateEngineAdapter {
    /**
     * @var Engine Object
     */
    protected $_engine;

    /**
     * @var string path to the templates associated with the current template engine. Is set in {templateengine} config
     */
    protected $_templatesPath;

    /**
     * Configure the template with the specific configuration data
     * @param array $config
     * @return mixed
     */
    abstract public function configure( array $config );

    /**
     * assign dynamic data to template
     * @param array $data
     * @return mixed
     */
    abstract public function assign( array $data );

    /**
     * renders the template filling it with the assigned data
     * @param $templateName
     * @return mixed
     */
    abstract public function render($templateName);

    /**
     * checks the validity of the template name and path
     * @param $templateName
     * @return bool
     */
    public function checkTemplatePath($templateName)
    {
        $fullPath = $this->_templatesPath . $templateName;
        return is_file($fullPath) && is_readable($fullPath);
    }
}