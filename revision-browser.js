/**
 * Revision Browser JS
 *
 * JS responsible for frontend revision browsing.
 *
 * @since   0.1.0
 * @package RBR
 */
jQuery( document ).ready( function($) {
   var $content = $( '.' + REVBROWSER.content );
   var $title   = $( '.' + REVBROWSER.title );
   var $nav     = $( '#revision-browser-nav' );

   $content.parent().prepend( REVBROWSER.links );

   var revisions, revision, count;
   var current = 0;

   $.get( REVBROWSER.api ).success( function( r ) {
      revisions = r;
      count = r.length;
      
      // Set the total revisions.
      $('#revision-browser-heading > span').html( count );
   }).error( function( r ) {
      $nav.hide().css( 'visibility', 'hidden' ).attr( 'aria-hidden', true );
      
   });

   // NEXT.
   $( '#revision-browser-next' ).on( 'click', function(e) {
      e.preventDefault();
     
      if ( 0 != current ) {
         current = current - 1;
      }

      if ( 0 == current ) {
         $( '#revision-browser-next' ).html( REVBROWSER.latest );
      }

      if ( ( count -1 ) != current ) {
         $( '#revision-browser-prev' ).html( '← ' + REVBROWSER.previous );
      }

      if ( current > -1 ) {
         revision = revisions[ current ];
         placeRevision( revision );
      }
   });

   // PREVIOUS.
   $( '#revision-browser-prev' ).on( 'click', function(e) {
      e.preventDefault();

      if ( ( count -1 ) != current ) {
         current = current + 1;
      }

      if ( ( count -1 ) == current ) {
         $( '#revision-browser-prev' ).html( REVBROWSER.oldest );
      }

      if ( -1 != current ) {
         $( '#revision-browser-next' ).html( REVBROWSER.next + ' →' );
      }

      if ( current < count ) {
         revision = revisions[ current ];
         placeRevision( revision );
      }

   });

   // Place the Revision titlte and content.
   function placeRevision( revision ) {
    
      $title.html( revision.title.rendered );
      $content.html( revision.content.rendered );

      // Set the total revisions.
      $('#revision-browser-heading > span').html( ( count - current ) + "/" + count );
   }
});
