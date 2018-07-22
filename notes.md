- Provide a bunch of well-made, common tools
	- databases
	- authentication
	- mailer
	- logging
	- HTML/URL escaping/encoding (in place of a templating language)
- An easy way to load controllers/models/middle-wares in one or a few lines
- Files that match the template, model, controller of plugin file extension should be disallowed at the web server.

Enable mysql general log:

```sql
SET GLOBAL general_log = 'ON';
SET GLOBAL general_log_file = '/var/log/mysql/all.log';
```
