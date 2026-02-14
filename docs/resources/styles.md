---
sidebar_position: 5
---

# Styles

CSS and [SASS](https://sass-lang.com/) style [assets](/resources/assets.md) are supported out-of-the-box.

## CSS

Raw custom CSS `.css` files are stored in the folder `[project]/assets/raw/css`. CSS files in this folder will be concatenated into one file called `app.css` and stored into `[..]/assets/css` when the compilation process is executed (read about [gulp compilation](/resources/assets.md)).

Subfolders under `[...]/assets/raw/css` will have all its CSS files concatenated into a single file with the same name and stored into `[..]/assets/css`. For example, all files in the subfolder `[...]/assets/raw/css/admin` will be concatenated into `[..]/assets/css/admin.css`.

### Create command

```bash
php ayuco create css:{filename}
```

Command sample:

```bash
php ayuco create css:my-app
```

The example above will create the file `assets/raw/css/my-app.css`.

**Why not use SASS?**

The framework comes out-of-the-box with SASS; it is encouraging to use it instead of raw CSS style classes.

## SASS and SCSS

SASS `.sass` and SCSS `.scss` files are stored in the folder `[project]/assets/raw/sass`. These files are compiled into CSS files and stored in the folder `[project]/assets/css/` when the compilation process is executed (read about gulp compilation).

### Create command

```bash
php ayuco create sass:{filename} {master}
```

```bash
php ayuco create scss:{filename} {master}
```

* `{filename}` -> The name of a master file (see description below) or the name of a part/partial file.
* `{master}` -> The name of the master file to import into.

Command samples:

```bash
php ayuco create sass:master
```

The example above will create the master file `assets/raw/sass/master.sass`.

```bash
php ayuco create scss:header master
```

The example above will create the partial file `assets/raw/sass/parts/_header.scss` and will import it into `master.scss`. Ayuco will create the master file as well if it doesn't exist.

### Recommended SASS/SCSS structure

It is recommended to have a master and multiple partial SASS files for a decentralized styling. This will allow having files focused on styling a specific content and it will improve team development by decreasing repository conflicts.

```text
+ /assets
|-- /raw
|----- /sass
|-------- master.scss
|-------- /parts
|---------- _header.scss
|---------- _footer.scss
|---------- _widgets.scss
```

The example above shows a suggested SASS folder structure, with a master file (`master.scss`) and partial ones. The content of the master file will look like:

```scss
/*! 
 * Master style file.
 */
@import 'parts/header';
@import 'parts/footer';
@import 'parts/widgets';
```

## Vendor Styles

3rd party developed style files (vendor styles) should be added to the project as a dependency using NodeJS (this will follow the dependency injection design pattern).

The majority of vendor styles are already supported on NodeJS. For example, to include [Font Awesome](https://fontawesome.com/) in the project run its install command:

```bash
npm install font-awesome --save
```

The example above will download the dependency and store it inside the folder `[project]/node_modules`.

### Add a dependency style as an asset

Downloaded dependencies need to be copied inside the `[project]/assets/css` folder to be accessible by the framework.

Custom **gulp** tasks must be included inside the file `gulpfile.js` to transfer vendor files inside the assets folder.

```js title="gulpfile.js"
// --------------
// START - CUSTOM TASKS

gulp.task('vendorcss', async function() {
    return gulp.src([
        './node_modules/font-awesome/css/font-awesome.min.css',
        '[other-vendor-file].css',
        '[other-vendor-file].css',
    ])
    .pipe(gulp.dest('./assets/css'));
});
```

In the example above, "Font Awesome" and other vendor files are copied by the custom gulp task `vendorcss`.

Custom **gulp** tasks must be added to the file `[project]/package.json` so these are registered and taken into account during compilation and deployment, see the example below:

```json title="package.json"
{
  "...",
  "prestyles": [
    "sass",
    "vendorcss"
  ],
  "..."
}
```

## Additional Style Language

Additional style languages, such as LESS or Stylus, can be used with the framework as long as they have gulp support.

A Gulp dependency must be added through NodeJS. For example, to use LESS, the following command must be run:

```bash
npm install gulp-less --save-dev
```

Custom **gulp** compilation tasks must be included inside the file `gulpfile.js`, see the example below:

```js title="gulpfile.js"
// ...
var less = require('gulp-less');

// --------------
// START - CUSTOM TASKS
gulp.task('less', async function () {
    return gulp.src('./assets/raw/less/*.less')
        .pipe(less())
        .pipe(gulp.dest('./assets/raw/css'));
});
```

Custom **gulp** compilation tasks must be added to the file [project]/package.json, see the example below:

```json title="package.json"
{
  "...",
  "prestyles": [
    "sass",
    "less"
  ],
  "..."
}
```

Styles in WPMVC emphasize modern, modular development with SASS/SCSS as the preferred approach, backed by Gulp for compilation, concatenation, and vendor integration — resulting in clean, optimized CSS delivered efficiently to WordPress.