<?php
namespace Headzoo\Utilities;
use Exception;
use InvalidArgumentException;

/**
 * Performs simple validation on values.
 */
class Validator
    implements ValidatorInterface
{
    /**
     * The type of exception thrown when a validation fails
     * @var string
     */
    protected $thrownException = self::DEFAULT_THROWN_EXCEPTION;

    /**
     * {@inheritDoc}
     */
    public function setThrownException($thrownException)
    {
        $thrownException = trim($thrownException, '\\');
        if (Exception::class !== $thrownException && !is_subclass_of($thrownException, Exception::class)) {
            throw new InvalidArgumentException(
                "Value '{$thrownException}' must name an exception class."
            );
        }
        $this->thrownException = $thrownException;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validateRequired(array $values, array $required, $allowEmpty = false)
    {
        if (!$allowEmpty) {
            $values = array_filter($values);
        }
        $missing = array_diff($required, array_keys($values));
        if (!empty($missing)) {
            $this->throwException(
                "Required values missing: %s.",
                Arrays::conjunct($missing, 'Headzoo\Utilities\Strings::quote')
            );
        }
        
        return true;
    }

    /**
     * Throws the configured validation exception
     * 
     * Examples:
     * ```php
     * $validator = new Validator();
     * $validator->throwException("There was a serious site error!");
     * $validator->throwException("There was a serious site error!", 666);
     * $validator->throwException("There was a %s %s error!", 666, "serious", "site");
     * 
     * // The middle argument may be omitted when the next argument is not an integer.
     * $validator->throwException("There was a %s %s error!", "serious", "site");
     * ```
     * 
     * @param string $message The error message
     * @param int    $code    The error code, defaults to 0
     * @param ...    $args    One or more values to quote into the message using sprintf()
     */
    protected function throwException($message, $code = 0)
    {
        $args    = func_get_args();
        $message = array_shift($args);
        $code    = array_shift($args);
        if (!is_int($code)) {
            array_unshift($args, $code);
            $code = 0;
        }
        if (!empty($args)) {
            $message = vsprintf($message, $args);
        }
        
        $exception = $this->thrownException;
        throw new $exception(
            $message,
            $code
        );
    }
} 