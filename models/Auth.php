<?php
class Auth
{
	protected static $instance;

	public  function __construct()
	{
	}

	public static function instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return new self::$instance;
	}

	public function login($user)
	{
		$_SESSION['id'] = $user->id;
	}

	public function logout()
	{
		unset($_SESSION['id']);
	}

	public function id()
	{
		if (isset($_SESSION['id'])) {
			return $_SESSION['id'];
		}
		return false;
	}
	public function isAuth()
	{
		if (isset($_SESSION['id'])) {
			return true;
		}
		return false;
	}

	public function isOwner($model)
    {   
        if (!isset($_SESSION['id'])) {
            return false;
        }

        if ($_SESSION['id'] == $model->user_id) {
            return true;
        }
        return false;
    }

}