---
sidebar_position: 20
---

# Deployment

The Deployment documentation covers how to prepare a **WordPress MVC** (WPMVC) project for production, including building distributable packages and publishing WordPress plugins.

## Build (ZIP file)

Before deploying your project to production, you should compile and package your assets so that only optimized and necessary files are included.

To do this, run the following command from your project’s root directory:

```bash
gulp build
```

When you execute gulp build:

* Development files, test artifacts, and unneeded resources are removed.
* Assets in `/assets/js` and `/assets/css` are minified.
* Vendor packages that are only needed for development are excluded.
* The resulting built project is output into the `/builds` directory as a ready-to-install ZIP package.

## Deployment Result

After building:

* You will have compressed package(s) suitable for installation or distribution.
* These packages contain only essential files for production (no unminified assets, no test files).

## Versioning

WPMVC supports versioned builds, allowing you to append a version number to your distribution ZIP files.

To change a project's version:

```bash
php ayuco set version:{version}
```

* `{version}` -> Is the new package version.

This will make sure builds are labeled consistently with your versioning strategy.

## Custom Tasks

You can customize the deployment workflow by adding **custom Gulp tasks**.

Modify `gulpfile.js` and your package.json scripts section to include additional tasks that should run during the build process — for example:

* Pre-processing styles (SASS/LESS)
* Custom JavaScript bundling
* Additional file transformations

Example portion of package.json showing custom tasks:

```js title="gulpfile.js"
{
  "prestyles": [
    "sass",
    "less"
  ],
  "prescripts": [
    "vendorjs"
  ],
  "prebuild": [
    "scripts",
    "styles"
  ]
}
````

Custom tasks can be run automatically as part of the build chain.

## Publishing WordPress.org Plugins

WPMVC provides tooling to support deploying projects as WordPress.org plugins.

### Create a WordPress.org Config

Create a file at the project’s root named: `wordpress-org.json`.

Populate it with the following structure:

```js title="wordpress-org.json"
{
  "root": "[plugin-name-path-given-by-wordpress.org]",
  "path": "[plugin-name-path-given-by-wordpress.org]",
  "cwd": "http://plugins.svn.wordpress.org/[plugin-name-path-given-by-wordpress.org]",
  "username": "[your-wordpress.org-username]",
  "password": "[your-wordpress.org-password]"
}
```

* `root` and `path` identify the plugin's main directory inside the ZIP.
* `cwd` points to the SVN repository on WordPress.org where the plugin will be published.
* The `username` must have contributor permissions on the plugin’s WordPress.org entry.

### Add Plugin Assets

Add your WordPress.org plugin assets under:

```bash
/assets/wordpress/
```

These assets may include banners, icons, screenshots, and other files required by the WordPress.org plugin directory.

### Configure SVN

To publish via SVN:

1. Install a Subversion client (e.g., TortoiseSVN).
2. Create the path inside your project:
```code
/svn/[plugin-name-path-given-by-wordpress.org]/
```
3. Check out the plugin's WordPress.org repository to this location.

### Build and Publish

Modify your `gulpfile.js` to load the WordPress.org JSON configuration and include:

```js titler="gulpfile.js"
// Load wordpress-org configuration
var wordpressOrg = JSON.parse(fs.readFileSync('./wordpress-org.json'));
````

Then run:

```bash
gulp wordpress
```

This generates a clean deploy build under the SVN trunk and assets folders inside the SVN checkout.

Finalize deployment by committing and pushing through SVN tools:

```bash
svn add *
svn commit -m "Deploy plugin version x.y.z"
```

## Deploy (Continuous Deployment)

In addition to building production assets with gulp build, WPMVC supports a complementary task for continuous deployment (CD) workflows: `gulp deploy`. This task is intended to prepare and transfer build output to a deployment target, and is suited for environments where deploys are automated (e.g., CI/CD pipelines).

### What gulp deploy Does

The gulp deploy command runs the build pipeline and then moves the compiled output into a deployment-ready folder, typically designed for integration with automated deployment tools (such as rsync, FTP, SFTP, or GitHub Actions). This is useful when you want to push assets without including development files or uncompiled asset sources.

Example run:

```bash
gulp deploy
```

This will:

* Execute all build tasks, including asset compilation and minification.
* Prepare the output specifically for deployment (e.g., copy to `builds/deploy`).
* Make the ready-to-deploy folder available for CI services (GitHub Actions, DeployBot, Netlify, etc.) to push it to production.

### Typical CD Workflow

In a CI/CD environment (e.g., GitHub Actions, GitLab CI, DeployBot):

1. Clone the repository and install dependencies:
```bash
npm ci
composer install --no-dev
```
2. Build the assets:
```bash
gulp deploy
```
3. Push the prepared output to the production host.

You can automate this entire workflow in your CI environment, making `gulp deploy` the central command for *production asset publishing*.

## Notes

* The **Deployment** process in WPMVC uses Gulp as the primary task runner.
* Custom build steps allow you to tailor your production packaging workflow.
* WordPress.org publishing is supported via SVN with structured config and build conventions.