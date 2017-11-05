<?php
class ContactController extends Controller
{
	public function init()
	{
		// Set page title
		$this->view->title = 'Contact';
	}

	public function index()
	{
		// Renders the contact view (Views/Contact/Index.phtml)
        $this->view->render();
	}

    public function send()
    {
		// If not a POST request, redirect to start page
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: ' . Url::createPath('home', 'index'));
		}

		$check = true;
        $errors = array();

        // Get POST data
        $email = self::getValue('frmEmail');
        $message = self::getValue('frmMessage');
		$verification = self::getValue('frmVerification');

        // Validation: Email
        if (empty($email)) {
            $check = false;
            array_push($errors, 'E-mail is required!');
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $check = false;
            array_push($errors, 'Invalid e-mail!');
        }

        // Validation: Message
        if (empty($message)) {
            $check = false;
            array_push($errors, 'Message is required!');
        }

		// Validation: Human verification
		if (empty($verification) || $verification != '4') {
			$check = false;
			array_push($errors, 'Verification is required!');
		}

        // Validation NOT passed, show error message
        if (!$check) {
            $this->setView('index');
            $this->view->title = 'Invalid form data!';
            $this->view->errorMessage = self::createErrorMessage($errors);
            $this->view->formData = $_POST;

			return $this->view->render();
        }

		self::sendMail();

        // Validation passed, show success
        $this->setView('Success');
        $this->view->title = 'Thank U!';
        $this->view->formData = array(
                                    'email' => $email,
                                    'message' => $message
                                );

		// Render the success view
        $this->view->render();
    }

	/**
	 * Sends an email.
	 */
	private static function sendMail()
	{
		// Code to send mail...
	}

	/**
	 * Gets an value from the POST variable using the supplied name.
	 */
	private static function getValue($name)
	{
		return $_POST[$name] ?? null;
	}

	/**
	 * Creates an error message using the supplied errors.
	 */
	private static function createErrorMessage($errors)
	{
		$mess = null;
		if (isset($errors) && count($errors) > 0) {
			$mess .= '<div class="alert alert-danger">';
			foreach ($errors as $err) {
				$mess .= $err . '<br />';
			}
			$mess .= '</div>';
		}
		return $mess;
	}
}