<?php namespace Lamoni\MarkupBuilder;
/**
 * Class MarkupBuilder
 * @package Lamoni\MarkupBuilder
 */
class MarkupBuilder
{
    protected $htmlDocument;

    protected $htmlElement;

    protected $elementName;

    protected $attributeName;

    protected $action;

    protected $arguments;

    ///////////////////////////////////////////////////////////////////////
    /*
     * Magic Methods
     *
     * These are my overrides on the magic methods used to make this
     * class work.
     *
     */////////////////////////////////////////////////////////////////////
    public function __call($name, $arguments)
    {

        $this->parseInputs($name, $arguments);

        $methodName = 'create' . $this->action;

        $this->$methodName();

        return $this;

    }

    public function __toString()
    {
        $outputMethod = "output{$this->action}";

        $returnData = (string)$this->$outputMethod();

        $this->reset();

        return $returnData;

    }

    public function parseInputs($name, $arguments)
    {

        if (\MatikHelpers::doesStringEndWithString($name, 'Open')) {

            $this->setAction('Open');

        } elseif (\MatikHelpers::doesStringEndWithString($name, 'Close')) {

            $this->setAction('Close');

        } else {

            $this->setAction('Attribute');

        }

        if ($this->action === 'Attribute') {

            $this->setAttributeName($name);

        } else {

            $this->setElementName($name);

        }

        $this->setArguments($arguments);

    }

    public function reset()
    {

        $classVars = get_class_vars(get_class());

        foreach ($classVars as $classVarName => $classVarValue) {

            unset($this->$classVarName);

        }

    }

    ///////////////////////////////////////////////////////////////////////
    /*
     * Setters/Getters
     *
     * Y'all know what these are.
     *
     */////////////////////////////////////////////////////////////////////

    public function setAction($action)
    {

        $this->action = $action;

    }

    public function getAction()
    {

        return $this->action;

    }

    public function setAttributeName($attributeName)
    {

        $this->attributeName = $attributeName;

    }

    public function getAttributeName()
    {

        return $this->attributeName;

    }

    public function setArguments(array $arguments)
    {

        $this->arguments = $arguments;

    }

    public function getArguments()
    {

        return $this->arguments;

    }

    public function setElementName($name)
    {

        $this->elementName = str_replace($this->action, '', $name);

    }

    public function getElementName()
    {

        return $this->elementName;

    }

    ///////////////////////////////////////////////////////////////////////
    /*
     * 'output' Methods
     *
     * These are called by the magic method __toString method.
     * These are responsible for deciding what to output based on
     * the 'action' (Open, Close, Attribute).
     *
     */////////////////////////////////////////////////////////////////////

    public function outputAttribute()
    {

        return str_replace($this->createClose(), '', $this->htmlDocument->saveHTML());

    }

    public function outputOpen()
    {

        return str_replace($this->createClose(), '', $this->htmlDocument->saveHTML());

    }

    public function outputClose()
    {

        if (empty($this->htmlDocument)) {
            return $this->createClose();
        }

        return $this->htmlDocument->saveHTML();

    }

    ///////////////////////////////////////////////////////////////////////
    /*
     * 'create' Methods
     *
     * These are called by the magic method __call.  They are responsible
     * for generating the markup depending on if 'Open' or 'Close' are
     * in the name of the function call attempted on our MarkupBuilder
     * object.
     *
     */////////////////////////////////////////////////////////////////////

    public function createAttribute()
    {

        $this->createCustomAttribute($this->attributeName, $this->arguments);

    }

    public function createCustomAttribute($name, $arguments)
    {

        $name = str_replace('_', '-', $name);

        $createAttribute = $this->htmlDocument->createAttribute($name);

        if (count($arguments)) {

            $createAttribute->value = $arguments[0];

        }

        $this->htmlElement->appendChild($createAttribute);

    }

    public function createOpen()
    {

        $this->htmlDocument = new \DOMDocument();

        $this->htmlElement = $this->htmlDocument->createElement($this->elementName);

        $this->htmlDocument->appendChild($this->htmlElement);

        if (count($this->getArguments())) {

            $this->createCustomAttribute('id', $this->arguments);

        }

    }

    public function createClose()
    {

        return "</{$this->elementName}>";

    }

}