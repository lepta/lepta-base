<?php
namespace application\models;
use system\language\LanguageString;

/**
 * Class Validator
 * @package application\models\validators
 */
class Validator
{
    /**
     * available rules:
     *  'length' => array('from' => fromValue, 'to' => toValue, 'equals' => equals)
     *  'value' => array('>' => moreValue, '>=' => moreequalsValue, '=' => equalsValue, '<' => lessValue, '<=' lessequalsValue, 'range' => array(val1, val2, .., valN))
     *  'email',
     *  'numeric'
     *  'not_empty',
     *  'not_null'
     * @var array
     */
    protected $_validationRules = array();

    /**
     * @var array
     */
    protected $_errors = array();

    /**
     * @param $paramName
     * @param $ruleName
     * @return string
     */
    protected function _checkMessage($paramName, $ruleName)
    {
        if (isset($this->_validationRules[$paramName][$ruleName]['_message'])) {
            if (is_array($this->_validationRules[$paramName][$ruleName]['_message'])) {
                list($stringId, $section) = array_values($this->_validationRules[$paramName][$ruleName]['_message']);
                return new LanguageString($stringId, $section);
            } else {
                return $this->_validationRules[$paramName][$ruleName]['_message'];
            }
        } else {
            return '';
        }
    }

    /**
     * @param $paramName
     * @param $paramValue
     * @param null $context
     * @return $this
     */
    public function validate($paramName, $paramValue, $context = null)
    {
        if (is_object($context) && !isset($context->$paramName)) {
            $this->_errors[] = new ValidationError( get_called_class() . ' context does not contain parameter ' . $paramName);
        } else {
            if (array_key_exists($paramName, $this->_validationRules)) {
                foreach($this->_validationRules[$paramName] as $ruleIndex => $rule) {
                    if (is_array($rule)) {
                        foreach($rule as $rKey => $rVal) {
                            if ($ruleIndex == 'length') {
                                switch($rKey) {
                                    case 'from':
                                        if (mb_strlen($paramValue) < $rVal) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'length'))) {
                                                $valMessage = $paramName . ' must not be shorted then ' . $rVal;
                                            }
                                        }
                                        break;

                                    case 'to' :
                                        if (mb_strlen($paramValue) > $rVal) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'length'))) {
                                                $valMessage = $paramName . ' must not be longer then ' . $rVal;
                                            }
                                        }
                                        break;

                                    case 'equals':
                                        if (mb_strlen($paramValue) != $rVal) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'length'))) {
                                                $valMessage = $paramName . ' must be ' . $rVal . ' characters long';
                                            }
                                        }
                                        break;

                                    default:
                                        break;

                                }
                            } elseif ($ruleIndex == 'value') {
                                switch($rKey) {
                                    case '>' :
                                        if (!($paramValue > $rVal)) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'value'))) {
                                                $valMessage = $paramName . ' must be greater then ' . $rVal;
                                            }
                                        }
                                        break;
                                    case '>=':
                                        if (!($paramValue >= $rVal)) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'value'))) {
                                                $valMessage = $paramName . ' must be greater then or equals ' . $rVal;
                                            }
                                        }
                                        break;
                                    case '=':
                                        if (!($paramValue == $rVal)) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'value'))) {
                                                $valMessage = $paramName . ' must be equal to ' . $rVal;
                                            }
                                        }
                                        break;
                                    case '<':
                                        if (!($paramValue < $rVal)) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'value'))) {
                                                $valMessage = $paramName . ' must be less then ' . $rVal;
                                            }
                                        }
                                        break;
                                    case '<=':
                                        if (!($paramValue <= $rVal)) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'value'))) {
                                                $valMessage = $paramName . ' must be less then or equals ' . $rVal;
                                            }
                                        }
                                        break;

                                    case 'range' :
                                        if (!in_array($paramValue, $rVal)) {
                                            if (!($valMessage = $this->_checkMessage($paramName, 'value'))) {
                                                $valMessage = $paramName . ' must be in the list: ' . implode(',', $rVal);
                                            }
                                        }
                                        break;
                                    default:
                                        break;
                                }
                            } elseif ($ruleIndex == 'regular' && $rKey == 'regex') {
                                if (preg_match('/[^' . $rVal . ']/', $paramValue)) {
                                    if (!($valMessage = $this->_checkMessage($paramName, 'regular'))) {
                                        $valMessage = $paramName . " doesn't match the pattern " . $rVal;
                                    }
                                }
                            }
                            if (isset($valMessage)) {
                                $this->_errors[$paramName] = new ValidationError($valMessage);
                                unset($valMessage);
                            }
                        }
                    } else {
                        switch($rule) {
                            case 'email':
                                if (!filter_var($paramValue, FILTER_VALIDATE_EMAIL)) {
                                    $this->_errors[$paramName] = new ValidationError('Email address is invalid');
                                }
                                break;

                            case 'numeric':
                                if (!is_numeric($paramValue)) {
                                    $this->_errors[$paramName] = new ValidationError($paramName . ' is supposed to be numeric');
                                }
                                break;

                            case 'not_empty':
                                if (empty($paramValue)) {
                                    $this->_errors[$paramName] = new ValidationError($paramName . ' is not supposed to be empty');
                                }
                                break;

                            case 'not_null':
                                if (is_null($paramValue)) {
                                    $this->_errors[$paramName] = new ValidationError($paramName . ' is not supposed to be null');
                                }
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }
        return $this;
    }

    /**
     * returns the validation result
     * @return bool
     */
    public function isValid()
    {
        return count($this->_errors) == 0 ? true : false;
    }

    /**
     * clears collected validation errors
     * @return void
     */
    public function clear()
    {
        $this->_errors = array();
    }

    /**
     * @return array
     */
    public function getErrors(){
        return $this->_errors;
    }

    /**
     * @return ValidationError
     */
    public function getLastError()
    {
        return end($this->_errors);
    }

    /**
     * @return mixed
     */
    public function getFirstError()
    {
        $errors = array_values($this->_errors);
        return $errors[0];
    }
}