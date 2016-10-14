jQuery( document ).ready( function($){
   var $content = $( '.' + REVBROWSER.content );
   var $title = $( '.' + REVBROWSER.title );
   var $nav = $( '#revision-browser-nav' );
   $content.parent().prepend( REVBROWSER.links );

   var revisions, revision, count;
   var current = 0;

   $.get( REVBROWSER.api ).success( function( r ){
      revisions = r;
      count = r.length;

   }).error( function( r ){
      console.log( r.responseText );
      $nav.hide().css( 'visibility', 'hidden' ).attr( 'aria-hidden', true );
   });

   $( '#revision-browser-next' ).on( 'click', function(e){
      e.preventDefault();
      current = current - 1;
      if( current > -1 ){
         revision = revisions[ current ];
         placeRevision( revision );
      }
   });

   $( '#revision-browser-prev' ).on( 'click', function(e){
      e.preventDefault();
      current = current + 1;
      if( current < count ){
         revision = revisions[ current ];
         placeRevision( revision );
      }

   });

   function placeRevision( revision ){
    console.log( revision )
      $title.html( revision.title.rendered );
      $content.html( revision.content.rendered );
      // $('html, body').animate({
      //    scrollTop: $nav.offset() - 50 .top
      // }, 500);
   }
});
