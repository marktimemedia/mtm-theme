(function( $ ){

    var pageImage = '#work .mtm-grid--single'; // grid image
    var pageTerm = '#work .mtm-component--term-list a'; // taxonomy term list
    var smallTerm = '#work .post--metadata_categories a'; // metadata inside post

    // Ajax taxonomy content from selectedTerm (ID) into targetContainer
    function taxonomyAjax( selectedTerm, $targetContainer, singleGrid ) {

        // After user click on term, fade out list of posts
        $targetContainer.fadeOut();
        //console.log('taxonomy fade out');
 
        // data and parameters to pass to the function
        data = {
            action: 'filter_posts', // action to which we hooked our function
            mtm_nonce: mtm_vars.mtm_nonce, // wp_nonce
            taxonomy: selectedTerm, // selected term
            };
 
        $.get( mtm_vars.mtm_ajax_url, data, function(response) {

            //console.log('taxonomy get');

            // $targetContainer.html('<img class="loader" width="40" height="40" src="/wp-content/themes/mtm-pink-spring-theme/assets/img/spin.gif">');
 
            if( response ) {
                // Display posts on page
                $targetContainer.html( response );
                // Restore div visibility
                $targetContainer.fadeIn().css({'display':'inline-block'});

                $targetContainer.find(singleGrid).wrapAll('<div class="gallery-dynamic-row"></div>');
                $targetContainer.find('a').on('click', function(e) {
                    e.preventDefault();
                })
                calcImgsInRow();

                //console.log('taxonomy response');
            } 

                $(pageImage + ' a').on( 'click', function(e) {

                    // Prevent defualt action on clicking post link
                    e.preventDefault();           

                }); // end on click - posts

                // Ajax single post content into target div when clicking post link
                $(pageImage).on( 'click', function(){

                    onClickPost($(this));

                } );

        });

    }

    // Ajax single post content from selectedPost (post ID) into targetDiv
    function postAjax( selectedPost, $targetDiv, $thisImg ) {
        
        if($thisImg.hasClass('load-this')){
            $targetDiv.html('<img class="loader" width="40" height="40" src="/wp-content/themes/mtm-pink-spring-theme/assets/img/spin.gif">');
        
            // data and parameters to pass to the function
            data = {
                action: 'single_post', // action to which we hooked our function
                mtm_nonce: mtm_vars.mtm_nonce, // wp_nonce
                postid: selectedPost, // selected post
                };
     
           $.get( mtm_vars.mtm_ajax_url, data, function(response) {
     
                if( response ) {
                    // Display posts on page
                    $targetDiv.html( response );
                }

                // Ajax taxonomy archive content in when clicking the small taxonomy links
                    $(smallTerm).on( 'click', function(e) {
                 
                        onClickTaxonomy(e, $(this));
                 
                    }); // end on click - terms

           });
       }
    }

    function onClickTaxonomy(e, $thisTax) {
         // return all to default state
        $(pageTerm).removeClass('showcasing');        
        
        // Prevent defualt action on clicking term link
        e.preventDefault();

        // add class to visually differentiate selected term
        $thisTax.addClass('showcasing');
 
        // define term ID, target container, and single container
        var selectedTerm = $thisTax.attr('data-id');
        var $targetContainer = $('#work .mtm-grid--wrapper');
        var singleGrid = '.mtm-grid--single';

        taxonomyAjax( selectedTerm, $targetContainer, singleGrid );
    }

    function onClickPost($thisPost) {
        // run wrapper and magic functions
        wrapperRow();
        do_the_magic($thisPost);

        // define post ID, target div
        var selectedPost = $thisPost.attr('data-uid');
        var $targetDiv = $('#work .expanded-gallery-single');

        // run post ajax function
        postAjax( selectedPost, $targetDiv, $thisPost );
    }


/* Magic Gallery Divs */

    var imgPerRow;
    var rowNumber;

    var rowImgString = '.mtm-grid--single';
    var tempRowClass = 'gallery-dynamic-row';
    var existsClass = 'expanded-gallery-single';

    var tempRowString = '.' + tempRowClass;
    var expandedExistsString = '.' + existsClass;

    var $rowImgs = $(rowImgString);
    var $tempRow = $(tempRowString);
    var $expandedExists = $(expandedExistsString);

    
    // assign images to rows
    function calcImgsInRow() {
         imgPerRow = 0; // number of images per row 
         rowNumber = 1; // which row we are on
         var $rowImgs = $(rowImgString);

         $rowImgs.each(function(){

            var $calcThis = $(this);

            if($calcThis.prev().length > 0){

                if($calcThis.offset().top !== $calcThis.prev().offset().top) { // if this image is not next to previous image
                    return false;
                }
                imgPerRow++;  

            } else {
                imgPerRow++;
            }
         });

        $rowImgs.each(function(i){

            var $calcThis = $(this);

            $calcThis.removeClass (function (index, css) {
                return (css.match (/(^|\s)img-row-\S+/g) || []).join(' ');
            });
            $calcThis.addClass("img-row-" + ((i%imgPerRow)+1)); // add descriptive class
          });

        // console.log('expected images per row ' + imgPerRow);

    }


    // add the wrapper div on click for dynamic rows
    function wrapperRow() {

        var $rowImgs = $(rowImgString);

        if ($rowImgs.parent().is(tempRowString)) { // get rid of wrapper if it exists
            $rowImgs.unwrap();
        }

        for(var i = 0; i < $rowImgs.length; i+=imgPerRow) { // create the wrapper div based on images per row
            $rowImgs.slice(i, i+imgPerRow).wrapAll('<div class="' + tempRowClass +'"></div>'); 
        }

        $(tempRowString).each(function(i){ // add data-row attribute
            $(this).attr('data-row', (i+1));
        });

    }


// unwrap on resize
    function unWrapRow() { 
        var $rowImgs = $(rowImgString);

        $rowImgs.unwrap();
        $rowImgs.wrapAll('<div class="' + tempRowClass +'"></div>'); 

    }

    // remove expanded content on resize so it doesn't jump to the bottom, possibly change this later to dynamically move itself instead
    function contentOnResize() {
        var $expandedExists = $(expandedExistsString);

        if($expandedExists.length > 0) {

            $expandedExists.remove();
        }
    }

// run immediately
    calcImgsInRow();

    var oldWidth = 0;

// run on window load
    $(window).load(function(){ // get window width on load and save
        oldWidth = $(window).width();
        
        // console.log('starting width= ' + oldWidth);
    });



    var resizeTimer;

// run on window resize 
    $(window).on('resize', function(e){

        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function(){    // wait until we're done resizing to do these things

            newWidth = $(window).width();       // get current window width

            if(oldWidth != newWidth){           // only do these things if width has changed (not height)

                calcImgsInRow();    // recalc images per row
                contentOnResize();  // hide content
                unWrapRow();        // kill wrapper and wrap all images together
                $(rowImgString).removeClass('showcasing');
                
                // console.log('resized width=' + oldWidth + ' new width= '+ newWidth );
            }

            oldWidth = newWidth;

        }, 300);

    });


// magic function for opening content on image click
    var sampleRowNumberOld = 0; // original value for "old" row
    
    function do_the_magic($thisObj) {

        var expandedExistsString = '.expanded-gallery-single';                  // needs to be reset here
        var contentString = '.gallery-full-content';                            // the class of the DOM object that contains the content
        var loadedClass = 'load-this';                                          // class that determines if we should run Ajax
        var activeClass = 'showcasing';                                         // class of currently active project
        
        //var $fullContent = $(contentString).html();                           // content in DOM associated with current image
        var $rowImgs = $(rowImgString);
        var $wrapperDiv = $thisObj.parent(tempRowString);                       // current image wrapper row
        var uid = $thisObj.data('uid');                                         // current image data-uid attr
        var expandedUid = $(expandedExistsString).data('uid');                  // current expanded div data-uid attr
        var sampleRowNumber = $wrapperDiv.data('row');                          // current image wrapper row data-row attr

    // clicked the same image twice (close)
        if(uid === expandedUid) { // image data-uid is the same as expanded data-uid

            $thisObj.removeClass(loadedClass);
            $thisObj.removeClass(activeClass);
            $( expandedExistsString ).removeClass('animate-show').data( 'uid', 0 ); // hide and reset data-uid to 0
            
            // console.log('step 1');

    // clicked a different image in same row (switch content)
        } else if(0 < expandedUid && uid !== expandedUid && sampleRowNumber === sampleRowNumberOld) { // expanded data-uid has been set, and is not the same as current, and is in the same row

            // $fullContent = $thisObj.children(contentString).html(); // grab content associated with this image
            $rowImgs.removeClass(activeClass);
            $( expandedExistsString ).addClass('animate-show').data( 'uid', uid ); // change data-uid to match current img
            $rowImgs.addClass(loadedClass);
            $thisObj.addClass(activeClass);

            // console.log('step 2');

    // clicked a different image in a new row (open)
        } else if( 0 < expandedUid && uid !== expandedUid && sampleRowNumber !== sampleRowNumberOld ) { // expanded data-uid has been set, and is not the same as current, and is in different row

            $rowImgs.removeClass(activeClass);
            $( expandedExistsString ).slideUp().data( 'uid', 0 ); // hide and reset data-uid to 0
            $(expandedExistsString).remove(); // remove div + content to reset
            $wrapperDiv.after('<div class="' + existsClass +'" data-uid="' + uid + '"></div>'); // create div after row for extra content
            $(expandedExistsString).slideDown('slow').addClass('animate-show'); // animate
            sampleRowNumberOld = sampleRowNumber; // set old row number to current row number
            $rowImgs.addClass(loadedClass);
            $thisObj.addClass(activeClass);
            
            // console.log('step 3');

    // clicked the image (open)
        } else { // expandedUid = 0 or undefined, or all other circumstances 

            $(expandedExistsString).remove(); // remove div + content to reset
            $wrapperDiv.after('<div class="'+ existsClass +'" data-uid="' + uid + '"></div>'); // create div and add content
            $(expandedExistsString).slideDown('slow').addClass('animate-show'); // animate
            sampleRowNumberOld = sampleRowNumber; // set old row number to current row number
            $rowImgs.addClass(loadedClass);
            $thisObj.addClass(activeClass);
            
            // console.log('step 4');
        }
    }

/* Document Ready */

    $(document).ready(function() {

        // Ajax taxonomy archive content in when clicking the main taxonomy menu
        $(pageTerm).on( 'click', function(e) {
            
           onClickTaxonomy(e, $(this));

        }); // end on click - terms

        
        $(pageImage + ' a').on( 'click', function(e) {

            // Prevent defualt action on clicking post link
            e.preventDefault();           

        }); // end on click - posts

        // Ajax single post content into target div when clicking post link
        $(pageImage).on( 'click', function(){

            $(this).addClass('load-this');

            onClickPost($(this));

        } );
    
    }); // end document ready

})( jQuery );