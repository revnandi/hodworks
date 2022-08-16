import lazySizes from 'lazysizes';
import 'lazysizes/plugins/blur-up/ls.blur-up';
import Plyr from 'plyr';
import Splide from '@splidejs/splide';
document.addEventListener("DOMContentLoaded", function(){
  // Handler when the DOM is fully loaded

  class HWSite {
    constructor() {
      if (HWSite._instance) {
        return HWSite._instance
      }
      HWSite._instance = this
  
      // ... Your rest of the constructor code goes after this
      this.elements = {
        header: document.getElementById('hw_header'),
        logo: document.getElementById('hw_logo'),
        languageSelector: document.getElementById('hodworks_language_selector'),
        menu: document.getElementById('hodworks_menu'),
        menuButton: document.getElementById('hodworks_menu_button'),
        main: document.getElementById('hw_main'),
        piecesCurrentContainer: document.getElementById('hw_pieces_current_container'),
        piecesCurrentImageContainer: document.getElementById('hw_pieces_current_image_container'),
        piecesCurrentTitle: document.getElementById('hw_pieces_current_title'),
        piecesPastContainer: document.getElementById('hw_pieces_past_container'),
        piecesPastImageContainer: document.getElementById('hw_pieces_past_image_container'),
        piecesPastTitle: document.getElementById('hw_pieces_past_title'),
        companyYearList: document.getElementById('hw_company_list'),
        calendarYearsList: document.getElementById('hw_calendar_years'),
        calendarTablesContainer: document.getElementById('hw_calendar_tables'),
        canvasContainer: document.getElementById('hw_canvas_container'),
        canvas: document.getElementById('hw_canvas'),
        singlePieceGalleriesContainer: document.getElementById('hw_single_piece_galleries_container'),
        singlePieceGallery: document.getElementById('hw_single_piece_gallery'),
        singlePieceGalleryList: document.getElementById('hw_single_piece_gallery_list'),
        singlePieceThumbnailGallery: document.getElementById('hw_single_piece_thumbnail_gallery'),
        singlePieceThumbnailGalleryList: document.getElementById('hw_single_piece_thumbnail_gallery_list'),
        singlePieceVideosContainer: document.getElementById('hw_single_piece_videos_container'),
        singlePieceInfoContainer: document.getElementById('hw_background_info_container'),
        singlePieceSubContents: document.querySelectorAll('.c-piece__sub-content'),
        singlePieceVideoButton: document.getElementById('hw_single_piece_video_button'),
        singlePieceGalleryButton: document.getElementById('hw_single_piece_gallery_button'),
        singlePieceInfoButton: document.getElementById('hw_single_piece_background_info_button'),
      };
      this.sizes = {};
      this.canvasPoints = {
        a: {
          x: 100,
          y: 200
        },
        b: {
          x: 200,
          y: 100
        },
        c: {
          x: 300,
          y: 200
        }
      };
      this.widgets = {};

      this.bindEvents();
      this.setSizes();
      this.initStuff();
      this.initWidgets();
      // this.initCanvas();
    };


    setSizes() {
      if(this.elements.logo) {
        this.sizes.logo = this.elements.logo.offsetHeight;
      };
      if(this.elements.canvas) {
        this.sizes.canvas = this.elements.canvas.getBoundingClientRect();
      };
      
      if(this.elements.header) {
        this.sizes.header = this.elements.header.offsetHeight + 76;
        console.log(this.sizes.header);
      };
    };

    initStuff() {
      this.elements.main.style.paddingTop = this.sizes.header + 76 + 'px';
    };

    bindEvents() {
      const scrollFunction = () => {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
          if(this.elements.menu && this.elements.header) {
            this.elements.header.classList.add('c-header--compact');

            this.elements.main.style.paddingTop = this.sizes.header + 'px';
          };
        } else {
          if(this.elements.menu && this.elements.header) {
            this.elements.header.classList.remove('c-header--compact');

            this.elements.main.style.paddingTop = this.sizes.header + 'px';
          };
        }
      };

      window.onscroll = () => {
        scrollFunction()
      };

      if(this.elements.menuButton) {
        this.elements.menuButton.addEventListener('click', (e) => {
          e.currentTarget.classList.toggle('is-active');
        });
      };

      if(this.elements.piecesCurrentContainer && this.elements.piecesCurrentTitle) {
        this.elements.piecesCurrentTitle.addEventListener('click', (e) => {
          this.elements.piecesPastTitle.classList.toggle('c-pieces__title-container--hidden');
        });

        this.elements.piecesCurrentContainer.querySelectorAll('.c-pieces__link').forEach( item => {
          item.addEventListener('mouseenter', (e) => { 
            if(!e.target.dataset.image) return;
            this.elements.piecesPastImageContainer.classList.add('c-pieces__image-container--visible');
            this.elements.piecesPastImageContainer.querySelector('img').src = e.target.dataset.image;
          });
          item.addEventListener('mouseleave', (e) => {
            this.elements.piecesPastImageContainer.classList.remove('c-pieces__image-container--visible');
            this.elements.piecesPastImageContainer.querySelector('img').src = null;
          });
        });
      };

      if(this.elements.piecesPastContainer && this.elements.piecesPastTitle) {
        this.elements.piecesPastTitle.addEventListener('click', (e) => {
          this.elements.piecesCurrentTitle.classList.toggle('c-pieces__title-container--hidden');
        });

        this.elements.piecesPastContainer.querySelectorAll('.c-pieces__link').forEach( item => {
          item.addEventListener('mouseenter', (e) => {
            if(!e.target.dataset.image) return;
            this.elements.piecesCurrentImageContainer.classList.add('c-pieces__image-container--visible');
            this.elements.piecesCurrentImageContainer.querySelector('img').src = e.target.dataset.image;
          });
          item.addEventListener('mouseleave', (e) => {
            this.elements.piecesCurrentImageContainer.classList.remove('c-pieces__image-container--visible');
            this.elements.piecesCurrentImageContainer.querySelector('img').src = null;
          });
        });
      };

      if(this.elements.companyYearList) {
        this.elements.companyYearList.querySelectorAll('h3').forEach(item => {
          item.addEventListener('click', (e) => {

            this.elements.companyYearList.querySelectorAll('h3').forEach(item => {
              item.classList.remove('c-company__year--active');
            });
            this.elements.companyYearList.querySelectorAll('div').forEach(item => {
              item.classList.remove('c-company__year-description--open');
            });

            e.target.nextElementSibling.classList.toggle('c-company__year-description--open');
            e.target.classList.toggle('c-company__year--active');
          });
        });
      };

      if(this.elements.calendarYearsList) {

        const yearButtons = this.elements.calendarYearsList.querySelectorAll('li');

        yearButtons.forEach( item => {
          item.addEventListener('click', (e) => {

            yearButtons.forEach( yearButton => {
              yearButton.classList.remove('c-calendar__year--active');
            })

            this.elements.calendarTablesContainer.querySelectorAll('.c-calendar__table').forEach(table => {
              table.classList.remove('c-calendar__table--visible');
            });

            item.classList.add('c-calendar__year--active');

            document.getElementById(`hw_calendar_table_${item.dataset.year}`).classList.add('c-calendar__table--visible');
          });
        });
      };

      if(this.elements.calendarYearsList) {
        this.elements.canvas.addEventListener('mousemove', function(event) {
          handleMouseMove(this.canvasPoints.a, event);
          handleMouseMove(this.canvasPoints.b, event);
          handleMouseMove(this.canvasPoints.c, event);
        });
      };

      window.addEventListener('resize', this.initCanvas);

      if(this.elements.singlePieceSubContents.length > 0) {
        if(this.elements) {
          this.elements.
        }
      };
    };

    initWidgets() {
      if(this.elements.singlePieceGallery && this.elements.singlePieceGalleryList && this.elements.singlePieceThumbnailGallery && this.elements.singlePieceThumbnailGalleryList) {
        this.widgets.singlePieceGallery = new Splide( this.elements.singlePieceGallery, {
          type      : 'fade',
          rewind    : true,
          pagination: false
        } );
        this.widgets.singlePieceThumbnailGallery = new Splide( this.elements.singlePieceThumbnailGallery, {
          fixedWidth: 100,
          gap       : 0,
          rewind    : true,
          pagination: false,
          arrows    : false,
        } );

        this.widgets.singlePieceGallery.sync( this.widgets.singlePieceThumbnailGallery );
        this.widgets.singlePieceGallery.mount();
        this.widgets.singlePieceThumbnailGallery.mount();
      };

      if(this.elements.singlePieceVideosContainer) {
        this.elements.singlePieceVideosContainer.querySelectorAll('.c-vimeo-player').forEach(item => {
          console.log();
          this.widgets[`singlePieceVimeoPlayer${item.dataset.code}`] =  new Plyr(item);
        });
      };
    };

    // initCanvas() {
    //   this.sizes.canvas = this.elements.canvas.getBoundingClientRect();
    
    //   this.canvasPoints.a.x = this.sizes.canvas.width / 4;
    //   this.canvasPoints.a.y = this.sizes.canvas.height / 1.29363;
    //   this.canvasPoints.b.x = this.sizes.canvas.width / 2;
    //   this.canvasPoints.b.y = this.sizes.canvas.height / 3;
    //   this.canvasPoints.c.x = this.sizes.canvas.width - this.sizes.canvas.width / 4;
    //   this.canvasPoints.c.y = this.sizes.canvas.height / 1.29363;
    
    //   window.requestAnimationFrame(this.draw(this));
    // };
    
    // setupCanvas(canvas) {
    //   // Get the device pixel ratio, falling back to 1.
    //   var dpr = window.devicePixelRatio || 1;
    //   // Get the size of the canvas in CSS pixels.
    //   var rect = canvas.getBoundingClientRect();
    //   // Give the canvas pixel dimensions of their CSS
    //   // size * the device pixel ratio.
    //   canvas.width = rect.width * dpr;
    //   canvas.height = rect.height * dpr;
    //   var ctx = canvas.getContext('2d');
    //   // Scale all drawing operations by the dpr, so you
    //   // don't have to worry about the difference.
    //   ctx.scale(dpr, dpr);
    
    //   return ctx;
    // };

    // draw(siteCtx) {
    //   console.log(siteCtx);
    //   let context = siteCtx.setupCanvas(this.elements.canvas);
    
    //   context.fillStyle = 'blue';
    
    //   context.lineWidth = 10;
    
    //   context.lineJoin = 'miter';
    //   context.stroke();
    
    //   context.strokeStyle = "#000";
    //   context.beginPath();
    //   context.moveTo(0, this.sizes.canvas.height / 3);
    //   context.lineTo(this.canvasPoints.a.x, this.canvasPoints.a.y);
    //   context.lineTo(this.canvasPoints.b.x, this.canvasPoints.b.y);
    //   context.lineTo(this.canvasPoints.c.x, this.canvasPoints.c.y); 
    //   context.lineTo(this.sizes.canvas.width, this.sizes.canvas.height / 3);
    //   context.stroke();
      
    //   context.lineWidth = 18;
    //   context.beginPath();
    //   context.moveTo(0, 0);
    //   context.lineTo(0, this.sizes.canvas.height);
    //   context.stroke();
      
    //   context.beginPath();
    //   context.moveTo(this.sizes.canvas.width, 0);
    //   context.lineTo(this.sizes.canvas.width, this.sizes.canvas.height);
    //   context.stroke();
    
    //   // points.b.y++;
    
    //   window.requestAnimationFrame(this.draw);
    // };

    // handleMouseMove(point, event) {
    //   if(
    //     (point.x - event.offsetX < DISTANCE_LIMIT && point.x-event.offsetX > - DISTANCE_LIMIT) &&
    //     (point.y - event.offsetY < DISTANCE_LIMIT && point.y-event.offsetY > - DISTANCE_LIMIT)
    //   ) {
    //     if((point.y - event.offsetY) < 0) {
    //       if(point.y <= 8) return;
    //       point.y = point.y - 3;
    //     };
    //     if((point.y - event.offsetY) >= 0) {
    //       if(point.y >= (this.sizes.canvas.height - 8)) return;
    //       point.y = point.y + 3;
    //     };
    //   }
    // };
  };
  
  const hodworksSite = new HWSite();

  console.log(hodworksSite);
});
