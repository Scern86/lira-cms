# Lira CMS
Lira framework based content management system

# Feature list:
- Separation of code into layers: Application and Component(s).
- Internal request redirection, restarting routing to a new path if further processing is required.
- Request routing using path-based regular expressions (SEF).
- Support for GET/POST/PUT/DELETE HTTP methods.
- Ability to implement RESTful.

# Dependencies:
- PHP >8.3
- PDO (Postgresql)
- memcached
- monolog
- lira/framework
- symfony/http-foundation

# Installation
### composer create-project lira/cms

# License
The Lira framework is licensed under the [MIT](LICENSE) license.