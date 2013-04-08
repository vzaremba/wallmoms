<?php
/**
 * EAuthUserIdentity class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EAuthUserIdentity is a base User Identity class to authenticate with EAuth.
 * @package application.extensions.eauth
 */
class EAuthUserIdentity extends CBaseUserIdentity {

	const ERROR_NOT_AUTHENTICATED = 3;

	/**
	 * @var EAuthServiceBase the authorization service instance.
	 */
	protected $service;

	/**
	 * @var string the unique identifier for the identity.
	 */
	protected $id;

	/**
	 * @var string the display name for the identity.
	 */
	protected $name;

	/**
	 * Constructor.
	 * @param EAuthServiceBase $service the authorization service instance.
	 */
	public function __construct($service) {
		$this->service = $service;
	}

	/**
	 * Authenticates a user based on {@link service}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		if ($this->service->isAuthenticated) {
			$this->id = $this->service->id;
			$this->name = $this->service->getAttribute('name');



            $socservice_user = Socservice::model()->findByAttributes(array(
                'service' => $this->name,
                'identity' => $this->id,
            ));

            // Если такого пользователя еще нет, то регистрируем его
            if (!$socservice_user) {

                $user = new User(array('username' => 'username', 'password' => '11111111', 'email' => 'aaaa@ukr.net'));
                $user->save();

                $socservice_user = new Socservice(array('service' => $this->name, 'identity' => $this->id, 'user_id' => $user->id));
                $socservice_user->save();
            }
            


			$this->setState('id', $this->id);
			$this->setState('name', $this->name);
			$this->setState('service', $this->service->serviceName);

			// You can save all given attributes in session.
			//$attributes = $this->service->getAttributes();
			//$session = Yii::app()->session;
			//$session['eauth_attributes'][$this->service->serviceName] = $attributes;

			$this->errorCode = self::ERROR_NONE;
		}
		else {
			$this->errorCode = self::ERROR_NOT_AUTHENTICATED;
		}
		return !$this->errorCode;
	}

	/**
	 * Returns the unique identifier for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the unique identifier for the identity.
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Returns the display name for the identity.
	 * This method is required by {@link IUserIdentity}.
	 * @return string the display name for the identity.
	 */
	public function getName() {
		return $this->name;
	}
}
