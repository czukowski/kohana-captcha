#Captcha for Kohana 3.x

This is the Captcha library ported from Kohana 2.3.x to 3.x. Very little has changed API-wise, although there have been a few changes.

##Getting Started

###Instantiate a captcha:

> $captcha = Captcha::instance();

Instantiate using your own config group (other than 'default'):

> $captcha = Captcha::instance('myconfig');

###Render a captcha:

> $captcha->render();

or just:

> $captcha;

By default image-based captchas are rendered with HTML, the HTML is a very simple <img> tag. If you want to handle
your own rendering of the captcha simply set the first parameter for render() to FALSE:

> $captcha->render(FALSE);

###Validate the captcha:

> Captcha::valid($_POST['captcha']);

Or just:

> Captcha::valid();

In this case, the Captcha class instance will attempt to get the user response from $_POST array on its own
(by default, $_POST['captcha']). Capthca driver classes may override this behavior, see Captcha_Recaptcha class.

The reason for this was that ReCaptcha renders and verifies different number of fields, than other drivers.

##Captcha Styles

* alpha
* basic
* black
* math
* riddle
* word
* recaptcha (NEW)

Note: for ReCaptcha, you need to add the 'public_key' and 'private_key' fields to your config group, along with
'style' => 'recaptcha'. Other fields are not necessary.