# Lira CMS
Lira framework based content management system.

# Feature list:
- Separation of code into layers: Application and Component(s).
- Internal request redirection, restarting routing to a new path if further processing is required.
- Request routing using path-based regular expressions (SEF).
- Creating and handling Events
- Support for GET/POST/PUT/DELETE HTTP methods.
- Ability to implement RESTful.
- Initializing dependencies where necessary.
- Programmatic inclusion of CSS styles and scripts in html templates.
- Independent definition of access rights at the component level and even at the individual controller level.

# Dependencies:
- PHP >8.3
- PDO (Postgresql)
- memcached (optional)
- monolog (optional)
- lira/framework
- symfony/http-foundation
- robmorgan/phinx

# Installation
### composer create-project lira/cms

# License
The Lira framework is licensed under the [MIT](LICENSE) license.