//set the container that Masonry will be inside of in a var
var container = document.querySelector('#masonry-loop');
//create empty var msnry
var msnry;
// initialize Masonry after all images have loaded
if(container != undefined){

	imagesLoaded( container, function() {
		msnry = new Masonry( container, {
			itemSelector: '.masonry-entry'
		});
	});
}
