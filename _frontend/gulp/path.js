const srcFolder = './src';
const destFolder = '../public/assets';

export default {
    src:{
        images: srcFolder + '/images/**/*.*',
        fonts: srcFolder + '/fonts/**/*.*',
        scss: srcFolder + '/scss/*.scss',
        js: srcFolder + '/js/**/*.js',
    },
    dest:{
        images: destFolder + '/images/',
        fonts: destFolder + '/fonts/',
        scss: destFolder + '/css/',
        js: destFolder + '/js/',
    },
    watch:{
        images: srcFolder + '/images/**/*.*',
        fonts: srcFolder + '/fonts/**/*.*',
        scss: srcFolder + '/scss/**/*.scss',
        js: srcFolder + '/js/**/*.js',
    },
    clean:destFolder,
    srcFolder:srcFolder,
    destFolder:destFolder,
}