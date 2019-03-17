
# How to release a new plugin version

All development is done on GitHub, then a release is made in the WordPress SVN repository.

## First make sure the latest code is on GitHub
- Commit all changes to the Git repo
- Run `npm run build` and commit the result to Git
- Bump the version in `wallsio.php` (both in the header and the constant) and commit that to Git
- `git push` to GitHub

## Then release via SVN

- Check out the SVN repository in a new directory `svn checkout https://plugins.svn.wordpress.org/wallsio`
- Remove the content of the SVN trunk `rm trunk -rf`
- Clone the Git repository into the trunk: `git clone git@github.com:DieSocialisten/Walls.io-Wordpress-Plugin.git trunk`. Cloning from GitHub is quite crucial so that no files from `.gitignore` are released via SVN, otherwise the release will be much bigger (e.g. because of node modules). Don't just copy the code from the other directory!  
- Run `svn status` to check what is about to be commited
- Add new files via `svn add newfile.txt`. (New files are marked with `?` in the output of `svn status`).
- Commit to SVN (commits are pushed automatically with SVN): `svn commit -m "This is what happened, version x.x.x"`. There should be a single commit message per version, always include a short message what changed and the version number.

## Assets (screenshots, banner, etc.)

Banners, icons, and screenshots are found in the `assets` directory of the SVN repository.
Simply add/update the files right there and then follow the steps above to release them. 

The WordPress plugin directory has some caches (a few minutes up to 24h), so be patient if the changes don't appear immediately.
