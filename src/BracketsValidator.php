<?php

/**
 * User: katekharitonova@corp.badoo.com
 * Date: 30/12/17
 * Time: 13:42
 */
class BracketsValidator
{
    const
        ALLOWED_DELIMITERS = [" ", "\n", "\t", "\r"],
        ERR_INVALID_CHAR = 'Incorrect char in file';

    private static
        $current_result = 0;

    /**
     * @param string $line a line containing brackets
     * @return bool true if each opening bracket is closed, false otherwise
     */
    public function validateString(string $line)
    {
        $result = $this->parseLine($line);

        return $result;
    }

    private static function getCurrentResult()
    {
        return self::$current_result;
    }

    private static function changeCurrentResultBy($value)
    {
        self::$current_result += $value;
    }

    private function validateCurrentResult()
    {
        $result = self::getCurrentResult();
        if ($result < 0) {
            return false;
        }
    }

    private function parseLine($line)
    {
        for ($i = 0; $i < strlen($line); $i++)
        {
            $char = substr($line, $i, 1);
            if ($char === '(') {
                self::changeCurrentResultBy(1);
            } elseif ($char === ')') {
                self::changeCurrentResultBy(-1);
                if ($this->validateCurrentResult() === false) {
                    return false;
                }
            } elseif (in_array($char, self::ALLOWED_DELIMITERS)) {
                //just do nothing
            } else {
                throw new InvalidArgumentException(self::ERR_INVALID_CHAR);
            }
        }
        if (self::getCurrentResult() != 0) {
            return false;
        } else {
            return true;
        }
    }
}
