<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    const ERROR_NOT_ACTIVATED = 3;
    private $_id;

	public function authenticate()
	{
        /*
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
        */
        $user = User::model()->findByAttributes(array('email'=>$this->username));
        /* if user not found */
        if ($user===null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        /* check password */
        else if ($user->password !== SHA1($this->password) ) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            /* check if account is not disabled */
            if($user->is_verified == 0) {
                    $this->errorCode = self::ERROR_NOT_ACTIVATED;
            } else { /* everything is okay */
                $this->_id=$user->id;
                $this->errorCode=self::ERROR_NONE;
            }

        }

        return !$this->errorCode;
	}

    public function getId()
    {
        return $this->_id;
    }
}