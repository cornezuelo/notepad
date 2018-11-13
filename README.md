# notepad
A php notes manager with file uploading, SQL and datatables.js for ordering

# Installing
Copy `config.php.default` to `config.php` and set up your configuration in the `$config` array.
- pwd = Master password for the app
- DBhost = Host of the MySQL database
- DBuser = User for the MySQL database
- DBpwd = Pasword for the MySQL database
- DBdb = Database for the MySQL table
- hash = Encryption hash. Recommended to change at the beggining. Don't change it afterwards, it would need a migration of your data.
- recaptchaPublicKey = Recaptcha public key if you want to enable recaptcha v2. Set to false if not.
- recaptchaPrivateKey = Recaptcha private key if you want to enable recaptcha v2. Set to false if not.

Also, you'll need to create the structure of the table `notas` for storing the notes:

```
CREATE TABLE IF NOT EXISTS `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(40) NOT NULL,
  `texto` text NOT NULL,
  `pos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;
```
