# Craft Reducer

_**Work in progress plugin, do not use (yet). Will post this on Straightupcraft once it is ready for production..**_

Craft plugin for reducing storage by resizing images immediately after uploading.

Ever had to build a gallery with 100+ images? If users upload images straight from their 10 megapixel camera, it will eat up a lot of storage space. With this plugin you can set a maximum pixel and quality value and Reducer will shrink your images immediately after uploading.

## Notes
_Please keep in mind that it is always wise to store a larger/higher quality version of images for future use! This plugin is not a replacement for Craft's Image Transforms, it will only give you more options._

Reducer uses "Fit" to shrink images that are larger than the given maximum size value. Smaller images won't be upscaled.

If you leave Quality blank, Reducer will use the quality set by your defaultImageQuality Craft config setting.

## Roadmap

- Check Craft build at install
- Log with statistics (how much storage space did we save?)
- User permission settings
- Add composer
- Run Reducer on an asset source (to resize existing images)
- Maintain changelog ;)

## Changelog

_Work in progress_
