
- provide a bunch of well-made, common tools
	- databases
	- authentication
	- mailer
	- logging
	- HTML/URL escaping/encoding (in place of a templating language)
- an easy way to load controllers/models/middle-wares in one or a few lines


- Load a "plugin" if it has the name `/base/directory/*.plugin.php`
- Load a "model" if is has the name `/current/directory/*.model.php`
- Load a "controller" if it has the name `/current/directory/*.controller.php`
- Files that match `*.plugin.php`, `*.model.php` and `*.controller.php` should be disallowed

Enable mysql general log:
> SET GLOBAL general_log = 'ON';
> SET GLOBAL general_log_file = '/var/log/mysql/all.log';
