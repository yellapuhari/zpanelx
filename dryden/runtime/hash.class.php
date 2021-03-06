<?php

/**
 * Provides bcrypt (Blowfish single-way encryption) functionality for password hashing in ZPanel.
 * @package zpanelx
 * @subpackage dryden -> runtime
 * @version 1.0.2
 * @author Bobby Allen (ballen@zpanelcp.com)
 * @copyright ZPanel Project (http://www.zpanelcp.com/)
 * @link http://www.zpanelcp.com/
 * @license GPL (http://www.gnu.org/licenses/gpl.html)
 */
class runtime_hash {

    /**
     * The password of which you wish to hash.
     * @var string $password The password string of which to create a hash from. 
     */
    var $password = null;

    /**
     * The 'salt' this should ideally be 22 characters in lengh. Only '.', '/' and aphanumrical values are allowed!
     * @var string $salt The salt to use for the hash process. (22 characters in lengh)
     */
    var $salt = null;

    /**
     * Class constructor, can specify password and salt here or alternatively use the setter methods.
     * @param string $password The password string of which to create a hash from.
     * @param string $salt The salt to use for the hash process. (22 characters in lengh)
     */
    public function __construct($password = '', $salt = '') {
        if (!empty($password))
            $this->password = $password;
        if (!empty($cost))
            $this->salt = $salt;
    }

    /**
     * Instead of using the constructor to set the password, you can also use this 'setter' method.
     * @param string $password The password string of which to create a hash from. 
     * @return boolean
     */
    public function SetPassword($password = '') {
        if (!empty($password)) {
            $this->password = $password;
        } else {
            return false;
        }
    }

    /**
     * Instead of using the constructor to set the salt, you can also use this 'setter' method.
     * @param type $salt The salt to use for the hash process. (22 characters in lengh)
     * @return boolean
     */
    public function SetSalt($salt = '') {
        if (!empty($salt)) {
            $this->salt = $salt;
        } else {
            return false;
        }
    }

    /**
     * Main method for generating the bcrypt hash.
     * @return boolean Will return false if fails (the user didn't define a password or the version of PHP does not support Blowfish, PHP 5.3.0+ is required!) or the password hash if successful.
     */
    public function Crypt() {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2a$07$' . $this->salt . '$';
            return crypt($this->password, $salt);
        } else {
            // Returns false if PHP version is not higher than 5.3.0 (which implements the Blowfish encruption mechanism).
            return false;
        }
    }

    /**
     * Generates a valid 22 character random salt (using the correct valid characters).
     * @return string A valid random 22 character salt.
     */
    public function RandomSalt() {
        $chars = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $randomsalt = (string) null;
        for ($i = 0; $i < 22; $i++)
            $randomsalt.=$chars[rand(0, 63)];
        return $randomsalt;
    }

}

?>
