# Wordpress MVC

Wordpress MVC (WPMVC) framework.

Visit the [oficial web site](https://www.wordpress-mvc.com/) for information and documentation.

## Special configurations

Make sure you have gone through all documentation and tutorials prior to making special configurations.

### For public plugin projects to be hosted at Wordpress.org

WPMVC helps you develop and publish a public plugin.

Your plugin needs to be approved prior to publish, generate an approval zip with command `gulp build`. Once Wordpress.org has approven the plugin, follow the next steps to prepare your project for deployment:

#### Step 1: Create wordpress-org.json

Create a new `.json` file at the root of your WPMVC project, name it `wordpress-org.json` and fill it with the following information:
```json
{
    "root": "[plugin-name-path-given-by-wordpress.org]",
    "path": "[plugin-name-path-given-by-wordpress.org]",
    "cwd": "http://plugins.svn.wordpress.org/[plugin-name-path-given-by-wordpress.org]",
    "username": "[wordpress.org-username]",
    "password": "[wordpress.org-password]"
}
```
*NOTE:* The username needs to have contributor permissions over the `plugin`.

#### Step 2: Add your Wordpress.org assets

Create and save your Wordpress.org assets within your project, at folder `/assets/wordpress/`.

#### Step 3: Configure SVN

Download and install [TortoiseSVN](https://tortoisesvn.net/) on you machine.

Create the path `/svn/[plugin-name-path-given-by-wordpress.org]/` within your project.

Use TortoiseSVN to checkout the plugin's Wordpress.org repository at the recently created folder `/svn/[plugin-name-path-given-by-wordpress.org]/`.

#### Step 4: Build plugin with WPMVC

Run command `gulp wordpress`.

WPMVC will generate a clean build of the project (for production environment) inside the `/svn/[plugin-name-path-given-by-wordpress.org]/trunk` path.

WPMVC will update Wordpress.org assets inside the `/svn/[plugin-name-path-given-by-wordpress.org]/assets` path.

#### Step 5: Push and release

Verify the build generate and use TortoiseSVN to add/commit your project into Wordpress.org.

## License

MIT License - Copyright (c) 2018 [10 Quality](https://www.10quality.com/).