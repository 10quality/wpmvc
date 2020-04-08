/**
 * Gulp
 *
 * @author WordPress MVC <https://www.wordpress-mvc.com/>
 * @license MIT
 * @package wpmvc
 * @version 1.0.4
 */

'use strict';

// Prepare
var fs = require('fs');
var gulp = require('gulp');
var wpmvc = require('gulp-wpmvc');

// Load package JSON as config file.
var config = JSON.parse(fs.readFileSync('./package.json'));

// --------------
// START - CUSTOM TASKS



// END - CUSTOM TASKS
// --------------

// Init WPMVC default tasks.
wpmvc(gulp, config);