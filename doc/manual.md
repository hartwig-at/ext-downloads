# downloads
A simple approach to downloads on your TYPO3 solution.

## What is downloads about?
We feel like the current approaches to providing downloads through your TYPO3 solution are cumbersome, over-complicated, no longer maintained or lack in some other area.

downloads is as straight-forward as we were able to make it. Hopefully you will agree.

## How does it work?
downloads is simple.

There are 3 types of *records* we care about, but usually you'll only work with 1. 

1. Install Notes
2. Download Categories
3. Downloads

With these records, you'll build up your *database* of downloads. Then you just place the downloads content element on any page and tell it what downloads it should contain.

## What's so special about that?
Nothing. The special thing about downloads is that it is simple and only relies on a few core features.

## Which are?

### Install Notes
Install notes are small records that only provides a rich text field and links it with a file extension.

A common install note would be for the file type `PDF`. In the notes, you would put something like
> To view this file you need a [PDF viewer](http://pdfreaders.org/)

downloads will then attach that note to every download of that type on your site automatically.

### Categories
downloads supports a single level of categories. Sub-categories are not supported.

The functionality of categories is:

1. Download records that belong to the same category will be rendered together in groups on your site.
1. You can place access restrictions on categories. More on that later.
1. The name of the category will be included in the file name of the resulting download. More on that later.

### Downloads
To create a download record itself, you only have to provide:

- A title
- The category it belongs to
- The install note that should be attached
- An optional qualifier that is only used for you to identify selections of files (at the time).
- The file itself on the local file system
- An optional descriptive text

#### Importer
Of course, we have a backend module that allows you to batch load any number of files into download records with a few clicks. We use the ExtJS user interface library look you're already used to.

### Access Restrictions
To download a file, the user that requested it must pass all TYPO3 access restrictions placed on the download record and the parent category record. Otherwise the user will not be allowed to download the file.

### Naming Scheme
downloads will force all filenames to fit into a static scheme. This only affects the name of the file that is presented to the user:

> `The name of the download category` + `The title of the download` + `The extension of the original file`

All unsafe characters should then be replaced and, thus, the final file name is generated.

### Maintenance is done on the file system
You want to change a file? Replace it through FTP, downloads will instantly serve the latest file.
> Yes, this implies that downloads is not so big on caching (yet)

### Download links are static
If you pass a link to a download around, the link will always work and always point to the latest revision of the download, as long as the id of the download record in the URL is preserved.

### Plays well with realurl
With the correct realurl configuration, all download links look as if they were pointing to direct downloads, yet the full TYPO3 access mechanism is run through.

### Visuals
There are only 2 things in regards to visuals a downloads extension needs to take care of:

1. Thumbnails, if the download is an image file (or .pdf or something else TYPO3 supports)
2. An icon the illustrate the file type

downloads does those two and that's it.

### Fresh code
downloads is fresh off the stove. It is built against the latest 4.5 LTS and 4.7 releases using Extbase & Fluid.