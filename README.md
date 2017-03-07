BC Error Pages
===================

This bundle implements a solution to override the default Symfony error pages template code and styles with designer friendly alternatives. Great for developers seeking to override default error pages in Symfony.


Version
=======

* The current version of BC Error Pages is 0.1.0

* Last Major update: February 24, 2017


Copyright
=========

* BC Error Pages is copyright 1999 - 2017 Brookins Consulting

* See: [COPYRIGHT.md](COPYRIGHT.md) for more information on the terms of the copyright and license


License
=======

BC Error Pages is licensed under the GNU General Public License.

The complete license agreement is included in the [LICENSE](LICENSE) file.

BC Error Pages is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License or at your
option a later version.

BC Error Pages is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

The GNU GPL gives you the right to use, modify and redistribute
BC Error Pages under certain conditions. The GNU GPL license
is distributed with the software, see the file doc/LICENSE.

It is also available at [http://www.gnu.org/licenses/gpl.txt](http://www.gnu.org/licenses/gpl.txt)

You should have received a copy of the GNU General Public License
along with BC Error Pages in doc/LICENSE.  If not, see [http://www.gnu.org/licenses/](http://www.gnu.org/licenses/).

Using BC Error Pages under the terms of the GNU GPL is free (as in freedom).

For more information or questions please contact: license@brookinsconsulting.com


Requirements
============

The following requirements exists for using BC Error Pages:


### Symfony version

* Make sure you use Symfony version 2.8+ (required) or higher.

* Designed and tested with Symfony 3.2.x


### PHP version

* Make sure you have PHP 5.6 or higher.


Features
========

### Error Page Templates

* layout:base.html.twig
* Exception:error(*).html.twig

### Command

* bc:ep:install - installs global template overrides via symlink (These are installed via composer by default)

### Composer Script Handler

* runs the bc:ep:install command upon composer package installation, installs assets and clears caches

### Dependencies

* This solution does not depend on eZ Platform in any way
* This solution depends on symfony/symfony
* This solution depends on symfony/filesystem

Use case requirements
=====================

This solution was created to provide for a simple basis to customize ugly yet informative Symfony error pages with a bc branded styled replacement.


Installation
============

### Bundle post install/update command script installation

Within your project's / website's root composer.json file add the following composer scripts block to provide for automatic error page template and assets installation.

    "scripts": {
        "symfony-scripts": [
            "Incenteev\\ParameterHandler\\ScriptHandler::buildParameters",
            "BrookinsConsulting\\BcErrorPagesBundle\\Composer\\ScriptHandler::installErrorPagesInApp",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::clearCache",
            "Sensio\\Bundle\\DistributionBundle\\Composer\\ScriptHandler::installAssets"
        ],
        "post-install-cmd": [
            "@symfony-scripts"
        ],
        "post-update-cmd": [
            "@symfony-scripts"
        ]
    },

### Bundle Activation

Within file `app/AppKernel.php` method `registerBundles` add the following into the `$bundles = array(` variable definition.

    // Brookins Consulting : BcErrorPagesBundle Requirements
    new BrookinsConsulting\BcErrorPagesBundle\BcErrorPagesBundle()

Install the above before installing the bundle via composer to ensure that the automatic error page template and assets installation scripts function as designed.

### Bundle Installation via Composer

Run the following command from your project root to install the bundle:

    bash$ composer require brookinsconsulting/bcerrorpagesbundle dev-master;

### Dev Env Route Installation (Optional)

Edit your ```app/config/routing.yml``` file and add the following code to import this bundle's routes. Note that this step is optional and only required if you desire to test the error pages manually.

    app_bcerrorpages:
        resource: "@BcErrorPagesBundle/Resources/config/routing_dev.yml"

### Template Installation

Required only if not installed via composer

    php bin/console bc:ep:install --relative

### Asset Installation

Required only if not installed via composer

    php bin/console assets:install web --symlink --relative

### Clear the caches

Clear Symfony caches (Required).

    php bin/console cache:clear;


Template Customization
===================================

## Custom Template Overrides

If you need to customize the provided templates remember to do so within the bundle resources itself.

If needed you may find making a fork or variation based on this bundle suits your needs for further template customization.

Usage
=====

The solution is configured to work virtually by default once properly installed.

Testing
=====

The solution is configured to work once properly installed and configured.

Simply navigate to a route / url which is not defined to trigger a 404 error and view the new error page template.

Troubleshooting
===============

### Read the FAQ

Some problems are more common than others. The most common ones are listed in the the [doc/FAQ.md](doc/FAQ.md)


### Support

If you have find any problems not handled by this document or the FAQ you can contact Brookins Consulting through the support system: [http://brookinsconsulting.com/contact](http://brookinsconsulting.com/contact)
