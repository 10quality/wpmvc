---
sidebar_position: 10
---

# JavaScript

JavaScript [assets](/resources/assets.md) are supported out-of-the-box.

## JavaScript

Raw custom JavaScript `.js` files are stored in the folder `[project]/assets/raw/js`. JavaScript files in this folder will be concatenated into one file called `app.js` and stored into `[..]/assets/js` when the compilation process is executed (read about [gulp compilation](/resources/assets.md)).

Subfolders under `[...]/assets/raw/js` will have all its JavaScript files concatenated into a single file with the same name and stored into `[..]/assets/js`. For example, all files in the subfolder `[...]/assets/raw/js/admin` will be concatenated into `[..]/assets/js/admin.js`.

### Create command

```bash
php ayuco create js:{filename}
```

Command sample:

```bash
php ayuco create js:my-app
```

The example above will create the file `assets/raw/js/my-app.js`.

## Vendor Scripts

3rd party developed script files (vendor scripts) should be added to the project as a dependency using NodeJS (this will follow the dependency injection design pattern).

The majority of vendor scripts are already supported on NodeJS. For example, to include jQuery or Bootstrap in the project run their install commands:

```bash
npm install jquery --save
npm install bootstrap --save
```

The example above will download the dependencies and store them inside the folder `[project]/node_modules`.

### Add a dependency script as an asset

Downloaded dependencies need to be copied inside the `[project]/assets/js` folder to be accessible by the framework.

Custom **gulp** tasks must be included inside the file `gulpfile.js` to transfer vendor files inside the assets folder.

```js title="gulpfile.js"
// --------------
// START - CUSTOM TASKS

gulp.task('vendorjs', async function() {
    return gulp.src([
        './node_modules/jquery/dist/jquery.min.js',
        './node_modules/bootstrap/dist/js/bootstrap.min.js',
        '[other-vendor-file].js',
    ])
    .pipe(gulp.dest('./assets/js'));
});
````

In the example above, "jQuery" and "Bootstrap" (and other vendor files) are copied by the custom gulp task `vendorjs`.

Custom **gulp** tasks must be added to the file `[project]/package.json` so these are registered and taken into account during compilation and deployment, see the example below:

```json title="package.json"
{
  "...",
  "prescripts": [
    "vendorjs"
  ],
  "..."
}
```

## Additional Script Processing

Additional JavaScript processing, such as transpilation with Babel or minification with UglifyJS/Terser, can be configured via custom gulp tasks if needed (though the framework's default concatenation already includes basic minification in build mode).

Custom tasks follow the same pattern as vendor copies:

```js title="gulpfile.js"
// Example: Babel transpilation (if needed for legacy support)
gulp.task('babel', async function () {
    return gulp.src('./assets/raw/js/*.js')
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(gulp.dest('./assets/raw/js/processed'));
});
````
Add to `package.json` as needed:

```js title="package.json"
{
  "...",
  "prescripts": [
    "babel",
    "vendorjs"
  ],
  "..."
}
````

## Best Practices

* Store raw, unminified JS in `/assets/raw/js/` — let Gulp handle concatenation/minification.
* Use subfolders (e.g., `admin/`, `frontend/`) for context-specific scripts → auto-generates admin.js, etc.
* Prefer Ayuco for quick file creation and registration.
* For production, run `gulp build` to get minified, concatenated `app.js` (and subfolder equivalents).
* Dependencies: List them in auto-enqueue config (see Assets) or in gulp vendor tasks.
* Modern JS: Use ES6+ syntax; the default gulp setup supports it, but add Babel if targeting older browsers.

Scripts in WPMVC emphasize efficient bundling and vendor management through Gulp, delivering optimized JavaScript to WordPress with minimal manual configuration.