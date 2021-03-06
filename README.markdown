sfDoctrineSimpleForumPlugin
========================================================

Overview
--------

This is a port of sfSimpleForumPlugin for Doctrine & Symfony 1.4

It relies on an already working registration process (using sfDoctrineGuardPlugin)


Requirements
------------

The prerequisites for using the `sfSimpleForum` plugin are the same of sfSimpleForumplugin:

  * You have to install and configure sfDoctrineGuardPlugin - http://www.symfony-project.org/plugins/sfDoctrineGuardPlugin

By default, I use the trunk version of sfDoctrineGuardPlugin, to install it, just checkout the trunk : 

    $ svn co http://svn.symfony-project.com/plugins/sfDoctrineGuardPlugin/trunk/ plugins/sfDoctrineGuardPlugin

If you want to use an older version of sfDoctrineGuardPlugin, just remove the 3 email_address fixtures in sfDoctrineSimpleForumPlugin/data/fixtures/fixtures.yml , it should work.

  * If you want to use RSS feeds, you must install the sfFeed2Plugin - http://www.symfony-project.org/plugins/sfFeed2Plugin

Installation
------------

Install the plugin from the source you want (svn, git, etc ..)

With git from your project directory

    $ git clone git://github.com/j0k3r/sfDoctrineSimpleForumPlugin.git -s plugins/sfDoctrineSimpleForumPlugin

With svn from your project directory

    $ svn checkout http://svn.github.com/j0k3r/sfDoctrineSimpleForumPlugin.git plugins/sfDoctrineSimpleForumPlugin


Enable it in `ProjectConfiguration.class.php`

    [php]
    class ProjectConfiguration extends sfProjectConfiguration
    {
      public function setup()
      {
        $this->enablePlugins(array(
          'sfDoctrinePlugin', 
          'sfDoctrineGuardPlugin',
          'sfDoctrineSimpleForumPlugin',
          '...'
        ));
      }
    }

Rebuild the model, generate the SQL code for the new tables, insert it into your database and load the included fixtures :
    
    $ php symfony doctrine:build --all --and-load

Clear the cache to enable the autoloading to find the new classes:
    
    $ php symfony cc

Enable the new `sfSimpleForum` module and the new `sfSimpleForum` helper in your application, via the `settings.yml` file.
    
    [yml]
    // in myproject/apps/frontend/config/settings.yml
    all:
      .settings:
        enabled_modules:        [sfSimpleForum, default]
        standard_helpers:       [Partial, Cache, sfSimpleForum, I18N]

Publish assets for the forum

    $ php symfony plugin:publish-assets

Because of cycling dependencies in the fixtures, the latest post information can't be set automatically by doctrine. It will be updated when you will post your first message, or you can fix this by running the update-last-post task :

    $ php symfony forum:update-last-post

Start using the plugin by browsing to the frontend module's default page:
     
    http://myproject/frontend_dev.php/sfSimpleForum

If you want to enable the plugin administration interface, you have to enable two more modules. You can do so in your main application or in a backend application. the following example is for a 'backend' application:

    [yml]
    // in myproject/apps/backend/config/settings.yml
    all:
      .settings:
        enabled_modules:        [sfSimpleForumCategoryAdmin, sfSimpleForumForumAdmin, sfSimpleForumRankAdmin, default]

Configure the plugin categories and forums by browsing to the administration modules default pages (assuming your backend application is called _backend_):
     
    http://myproject/backend_dev.php/sfSimpleForumCategoryAdmin
    http://myproject/backend_dev.php/sfSimpleForumForumAdmin
    http://myproject/backend_dev.php/sfSimpleForumRankAdmin

Configuration
-------------

Some settings can be tweaked in your app settings.yml

    [yml]
    all:
      sfSimpleForumPlugin
        display_recommandations: true
        display_abuse: true
        count_views: true
        admin_email: test@test.com 
        from_email: test@test.com
        show_author_details: true
        max_per_page: 10
        display_avatar: true
        avatar_method: getLogo
        upload_dir: forum/
        display_rank: true
        use_feeds: true

*display_recommandations* will allow the users to recommand a topic.

*display_abuse* will allow the users to report abuse for a topic.

*count_views* will count the number of view per topic.

*admin_emain* is the email of the admin who will receive abuse mails

*from_email* is the "from" email address used to send abuse email

*show_author_details* displays detailed information about the author on each post 

*max_per_page* number of posts displayed per page

*display_avatar* If you want to display an image for each user (if show_author_details is set to true)

*avatar_method* Provide a method which will return the path of the image to display. This method should be defined il your app/lib/myUser.class.php file

*upload_dir* The directory where uploaded files (for the rank system) will be uploaded. It will append this dir to sfConfig::get('sf_upload_dir') 

*display_rank* If you want to display the rank of each user (if show_author_details is set to true)

*use_feeds* If you want to display an RSS link on each topic. Needs sfFeed2Plugin to work

Translations
------------

The french translation is up-to-date (in modules/sfSimpleForum/i18n). Use it as a starting point for other translations.
