import gulp from 'gulp';
import {clean} from './gulp/tasks/clean.js';
import {files} from './gulp/tasks/files.js';
import {css,cssPages} from './gulp/tasks/css.js';
import {javascript} from './gulp/tasks/javascript.js';
import {images} from './gulp/tasks/images.js';
import {watcher} from './gulp/tasks/watcher.js';

const scss = gulp.parallel(css,cssPages);
const dev = gulp.series(clean,gulp.parallel(files,scss,javascript,images),watcher);
const build = gulp.series(clean,gulp.parallel(files,scss,javascript,images));

export {dev,build, javascript,scss}

gulp.task('default',build);