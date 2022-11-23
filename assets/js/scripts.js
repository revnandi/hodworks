import lazySizes from 'lazysizes';
import 'lazysizes/plugins/blur-up/ls.blur-up';
import Plyr from 'plyr';
import Splide from '@splidejs/splide';
import * as paper from 'paper-jsdom';
import { UAParser } from 'ua-parser-js';
import { throttle } from 'lodash';
document.addEventListener('DOMContentLoaded', function(){
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
        companyTextContainer: document.getElementById('hw_company_text_container'),
        companyTextContainerAlt: document.getElementById('hw_company_text_container_alt'),
        calendarYearsList: document.getElementById('hw_calendar_years'),
        calendarTablesContainer: document.getElementById('hw_calendar_tables'),
        headerCanvasContainer: document.getElementById('hw_canvas_container'),
        headerCanvas: document.getElementById('hw_canvas'),
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
        splashScreenContainer: document.getElementById('hw_splash_screen'),
        splashScreenVideo: document.getElementById('hw_splash_screen_video'),
        splashScreenCanvas: document.getElementById('hw_splash_screen_canvas'),
        hodPageCvButton: document.getElementById('hw_hod_cv_button'),
        hodPageWorksButton: document.getElementById('hw_hod_works_button'),
        hodPageContent: document.getElementById('hw_hod_content'),
        hodPageCv: document.getElementById('hw_hod_cv'),
        hodPageWorks: document.getElementById('hw_hod_works'),
        newsVideoContainer: document.getElementById('hw_news_videos_container'),
      };
      this.state = {
        isHeaderCompact: true,
        sizes: {}
      }
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
      this.userAgent = {}
      this.widgets = {
        hodPageState: {
          activeScreen: 'base'
        }
      };

      this.bindEvents();
      this.setSizes();
      this.initWidgets();
      this.initStuff();
      // this.initCanvas();
    };


    setSizes() {
      if(this.elements.logo) {
        this.state.sizes.logo = this.elements.logo.offsetHeight;
      };
      if(this.elements.canvas) {
        this.state.sizes.canvas = this.elements.canvas.getBoundingClientRect();
      };
      
      if(this.elements.header) {
        this.setMainMargin();
        // this.elements.header.addEventListener('transitionend', (e) => {
        //   this.state.sizes.header = this.elements.header.offsetHeight;
        // });
      };
    };

    initStuff() {
      // this.elements.header.addEventListener('transitionend', (e) => {
      //   this.elements.main.style.paddingTop = this.state.sizes.header + 'px';
      // });

      this.userAgent = this.widgets.UAParser.getResult();
      if(sessionStorage.getItem('hodworks_splash_screen_closed') === 'true') {
        this.widgets.splashScreenVideoPlayer.pause();
        this.elements.splashScreenContainer.remove();
      };
    };

    bindEvents() {
      let lastPos;
      const scrollFunction = () => {
        // console.log(this.state.isHeaderCompact);
        if (Math.round(document.documentElement.scrollTop) > 100) {
          // this.elements.header.addEventListener('transitionstart', (e) => {
            //   console.log('transition start');
            //   this.elements.main.style.paddingTop = this.state.sizes.header + 'px';
            // });
            // console.log(Math.round(document.documentElement.scrollTop), lastPos);
            if(!this.state.isHeaderCompact) {
              this.elements.header.classList.add('c-header--compact');
            }
          this.state.isHeaderCompact = true;
          // console.log(Math.round(document.documentElement.scrollTop));
        } else {
          if(this.elements.menu && this.elements.header) {
            this.elements.header.classList.remove('c-header--compact');

            this.elements.main.style.paddingTop = this.state.sizes.header + 'px';
          };
          this.state.isHeaderCompact = false;
        }
        // console.log(this.state.isHeaderCompact);
        lastPos = Math.round(document.documentElement.scrollTop);
      };

      // window.onscroll = () => throttle(scrollFunction, 2000);

      window.addEventListener('scroll', throttle(() => scrollFunction(), 250));

      if(this.elements.menuButton && this.elements.menu) {
        this.elements.menuButton.addEventListener('click', (e) => {
          e.currentTarget.classList.toggle('is-active');
          this.elements.menu.classList.toggle('c-main-navigation--open');
          this.elements.header.classList.toggle('c-header--open');
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

            e.target.classList.toggle('c-company__year--active');
            this.elements.companyYearList.querySelectorAll('div').forEach(item => {
              item.classList.remove('c-company__year-description--open');
            });

            if(window.innerWidth <= 768) {
              this.elements.companyTextContainerAlt.classList.add('c-company__text-container-alt--visible');
              this.elements.companyTextContainer.classList.add('c-company__text-container--hidden');
              this.elements.companyTextContainerAlt.innerHTML = e.target.nextElementSibling.innerHTML;
            } else if(window.innerWidth > 768) {
              e.target.nextElementSibling.classList.toggle('c-company__year-description--open');
            };

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

      if(this.elements.canvas) {
        this.elements.canvas.addEventListener('mousemove', function(event) {
          handleMouseMove(this.canvasPoints.a, event);
          handleMouseMove(this.canvasPoints.b, event);
          handleMouseMove(this.canvasPoints.c, event);
        });
      };

      window.addEventListener('resize', () => this.initResize());

      if(this.elements.singlePieceSubContents.length > 0) {

        const resetSubContents = () => {
          this.elements.singlePieceSubContents.forEach(item => {
            item.classList.remove('c-piece__sub-content--active');
          });
        };

        if(this.elements.singlePieceGalleriesContainer && this.elements.singlePieceGalleryButton) {
          this.elements.singlePieceGalleryButton.addEventListener('click', (e) => {
            console.log(e);
            resetSubContents();
            this.elements.singlePieceGalleriesContainer.classList.add('c-piece__sub-content--active');
          });
        };
  
        if(this.elements.singlePieceVideosContainer && this.elements.singlePieceVideoButton) {
          this.elements.singlePieceVideoButton.addEventListener('click', (e) => {
            console.log(e);
            resetSubContents();
            this.elements.singlePieceVideosContainer.classList.add('c-piece__sub-content--active');
          });
        };

        if(this.elements.singlePieceInfoContainer && this.elements.singlePieceInfoButton) {
          this.elements.singlePieceInfoButton.addEventListener('click', (e) => {
            console.log(e);
            resetSubContents();
            this.elements.singlePieceInfoContainer.classList.add('c-piece__sub-content--active');
          });
        };
      };

      if(this.elements.hodPageCvButton && this.elements.hodPageCv && this.elements.hodPageContent && this.elements.hodPageWorks) {
        this.elements.hodPageCvButton.addEventListener('click', (e) => {
          if(this.widgets.hodPageState.activeScreen == 'cv') {
            e.currentTarget.classList.remove('c-hod__button--active');
            this.elements.hodPageContent.classList.add('c-hod__content--active');
            this.elements.hodPageCv.classList.remove('c-hod__content--active');
          } else {
            e.currentTarget.classList.add('c-hod__button--active');
            this.elements.hodPageWorksButton.classList.remove('c-hod__button--active');
            this.widgets.hodPageState.activeScreen = 'cv';
            this.elements.hodPageContent.classList.remove('c-hod__content--active');
            this.elements.hodPageWorks.classList.remove('c-hod__content--active');
            this.elements.hodPageCv.classList.add('c-hod__content--active');
          };
        });

        this.elements.hodPageWorksButton.addEventListener('click', (e) => {
          if(this.widgets.hodPageState.activeScreen == 'works') {
            e.currentTarget.classList.remove('c-hod__button--active');
            this.elements.hodPageContent.classList.add('c-hod__content--active');
            this.elements.hodPageWorks.classList.remove('c-hod__content--active');
          } else {
            e.currentTarget.classList.add('c-hod__button--active');
            this.elements.hodPageCvButton.classList.remove('c-hod__button--active');
            this.widgets.hodPageState.activeScreen = 'works';
            this.elements.hodPageContent.classList.remove('c-hod__content--active');
            this.elements.hodPageCv.classList.remove('c-hod__content--active');
            this.elements.hodPageWorks.classList.add('c-hod__content--active');
          };
        });
      };
    };

    initWidgets() {
      this.widgets.UAParser = new UAParser();

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
          this.widgets[`singlePieceVimeoPlayer${item.dataset.code}`] = new Plyr(item);
        });
      };

      if(this.elements.newsVideoContainer) {
        this.elements.newsVideoContainer.querySelectorAll('.c-vimeo-player').forEach(item => {
          this.widgets[`newsVimeoPlayer${item.dataset.code}`] = new Plyr(item, {
            volume: 0,
            autoplay: true,
            muted: true,
            controls: false,
            loop: {
              active: true
            }
          });
        });
      };

      if(this.elements.splashScreenVideo) {
        this.widgets.splashScreenVideoPlayer = new Plyr(this.elements.splashScreenVideo, {
          // debug: true,
          volume: 0,
          autoplay: true,
          muted: true,
          controls: false
        });
      };

      if(this.elements.splashScreenCanvas) {
        paper.setup(this.elements.splashScreenCanvas);

        const horizontalSawPath = new paper.Path({
          segments: [
            [0, paper.view.viewSize.height / 2],
            [paper.view.viewSize.width / 4, paper.view.viewSize.height / 2],
            [(paper.view.viewSize.width / 4) * 2, paper.view.viewSize.height / 2],
            [(paper.view.viewSize.width / 4) * 3, paper.view.viewSize.height / 2],
            [paper.view.viewSize.width, paper.view.viewSize.height / 2]
          ],
          strokeColor: '#ffffff',
          strokeWidth: 10
        });

        const verticalLeftPath = new paper.Path({
          segments: [
            [5, paper.view.viewSize.height],
            [5, paper.view.viewSize.height]
          ],
          strokeColor: '#ffffff',
          strokeWidth: 10
        });

        const verticalRightPath = new paper.Path({
          segments: [
            [paper.view.viewSize.width - 5, 0],
            [paper.view.viewSize.width - 5, 0]
          ],
          strokeColor: '#ffffff',
          strokeWidth: 10
        });

        // const targetCircle = new paper.Path.Circle({
        //   center: paper.view.center,
        //   radius: 30,
        //   fillColor: 'transparent'
        // });

        this.widgets.splashScreenVideoPlayer.on('playing', (event) => {
          const instance = event.detail.plyr;
          console.log(event.detail);
          horizontalSawPath.tween({
            'segments[0].point.y': paper.view.viewSize.height / 3,
            'segments[1].point.y': (paper.view.viewSize.height / 3) * 2,
            'segments[2].point.y': paper.view.viewSize.height / 3,
            'segments[3].point.y': (paper.view.viewSize.height / 3) * 2,
            'segments[4].point.y': paper.view.viewSize.height / 3,
            }, {
                easing: 'easeInOutCubic',
                duration: 2000
            }
          );
  
          verticalLeftPath.tween({
            'segments[0].point.y': 0,
            }, {
                easing: 'easeInOutCubic',
                duration: 2000
            }
          );
  
          verticalRightPath.tween({
            'segments[1].point.y': paper.view.viewSize.height,
            }, {
                easing: 'easeInOutCubic',
                duration: 2000
            }
          );
        });

        paper.view.onMouseMove = function(event) {
          // targetCircle.position = event.point;

          const nearestLocation = horizontalSawPath.getNearestLocation(event.point);

          if((nearestLocation.distance <= 30) && nearestLocation.segment.index !== 0 && nearestLocation.segment.index !== 4) {
            // targetCircle.tweenTo({ fillColor: '#D2F49A' }, {
            //   easing: 'easeInOutCubic',
            //   duration: 100
            // });

            if((horizontalSawPath.segments[nearestLocation.segment.index].point.y - event.point.y < 0) && event.delta.y < 0) {
              if(
                horizontalSawPath.segments[nearestLocation.segment.index].point.y + event.delta.y > 10 &&
                horizontalSawPath.segments[nearestLocation.segment.index].point.y + event.delta.y < paper.view.bounds.height - 10
                ) horizontalSawPath.segments[nearestLocation.segment.index].point.y = horizontalSawPath.segments[nearestLocation.segment.index].point.y + event.delta.y;
            } else if ((horizontalSawPath.segments[nearestLocation.segment.index].point.y - event.point.y >= 0) && event.delta.y > 0) {
              if(
                horizontalSawPath.segments[nearestLocation.segment.index].point.y + event.delta.y > 10 &&
                horizontalSawPath.segments[nearestLocation.segment.index].point.y + event.delta.y < paper.view.bounds.height - 10
                ) horizontalSawPath.segments[nearestLocation.segment.index].point.y = horizontalSawPath.segments[nearestLocation.segment.index].point.y + event.delta.y;
            }

            if((horizontalSawPath.segments[nearestLocation.segment.index].point.x - event.point.x < 0) && event.delta.x < 0) {
              if(
                horizontalSawPath.segments[nearestLocation.segment.index].point.x + event.delta.x > 10 &&
                horizontalSawPath.segments[nearestLocation.segment.index].point.x + event.delta.x < paper.view.bounds.width - 10
              ) horizontalSawPath.segments[nearestLocation.segment.index].point.x = horizontalSawPath.segments[nearestLocation.segment.index].point.x + event.delta.x;
            } else if ((horizontalSawPath.segments[nearestLocation.segment.index].point.x - event.point.x >= 0) && event.delta.x > 0) {
              if(
                horizontalSawPath.segments[nearestLocation.segment.index].point.x + event.delta.x > 10 &&
                horizontalSawPath.segments[nearestLocation.segment.index].point.x + event.delta.x < paper.view.bounds.width - 10
              ) horizontalSawPath.segments[nearestLocation.segment.index].point.x = horizontalSawPath.segments[nearestLocation.segment.index].point.x + event.delta.x;
            }

          };

          // if((nearestLocation.distance > 30)) {
          //   targetCircle.tweenTo({ fillColor: 'transparent' }, {
          //     easing: 'easeInOutCubic',
          //     duration: 100
          //   });
          // }
        };

        paper.view.onResize = function (event) {
          horizontalSawPath.segments[0].point.y = paper.view.viewSize.height / 3;
          horizontalSawPath.segments[1].point.y = horizontalSawPath.segments[1].point.y + event.delta.height;
          horizontalSawPath.segments[2].point.y = horizontalSawPath.segments[2].point.y + event.delta.height;
          horizontalSawPath.segments[3].point.y = horizontalSawPath.segments[3].point.y + event.delta.height;
          horizontalSawPath.segments[4].point.y = paper.view.viewSize.height / 3;
          
          horizontalSawPath.segments[0].point.x = 0;
          horizontalSawPath.segments[1].point.x = horizontalSawPath.segments[1].point.x + event.delta.width;
          horizontalSawPath.segments[2].point.x = horizontalSawPath.segments[2].point.x + event.delta.width;
          horizontalSawPath.segments[3].point.x = horizontalSawPath.segments[3].point.x + event.delta.width;
          horizontalSawPath.segments[4].point.x = paper.view.viewSize.width;

          verticalRightPath.segments[0].point.y = 0;
          verticalRightPath.segments[1].point.y = paper.view.viewSize.height;
          verticalLeftPath.segments[0].point.y = 0 ;
          verticalLeftPath.segments[1].point.y = paper.view.viewSize.height;
          
          verticalRightPath.segments[0].point.x = paper.view.viewSize.width -5 ;
          verticalRightPath.segments[1].point.x = paper.view.viewSize.width -5 ;
          verticalLeftPath.segments[0].point.x = 5 ;
          verticalLeftPath.segments[1].point.x = 5 ;
        };

        paper.view.onClick = (event) => {
          horizontalSawPath.tween({
            'segments[0].point.y': paper.view.center.y,
            'segments[1].point.y': paper.view.center.y,
            'segments[2].point.y': paper.view.center.y,
            'segments[3].point.y': paper.view.center.y,
            'segments[4].point.y': paper.view.center.y,
            }, {
                easing: 'easeOutCubic',
                duration: 1000
            }
          ).then(() => {
            this.elements.splashScreenContainer.classList.add('c-splash-screen--faded');
            this.widgets.splashScreenVideoPlayer.pause();
            setTimeout(() => {
              this.elements.splashScreenContainer.remove();
              // sessionStorage.setItem('hodworks_splash_screen_closed', true);
            }, 1000);
          });

          verticalLeftPath.tween({
            'segments[0].point.y': paper.view.viewSize.height,
            }, {
                easing: 'easeInOutCubic',
                duration: 1000
            }
          );
  
          verticalRightPath.tween({
            'segments[1].point.y': 0,
            }, {
                easing: 'easeInOutCubic',
                duration: 1000
            }
          );
        };
      };

      if(this.elements.headerCanvas) {
        paper.setup(this.elements.headerCanvas);

        const horizontalSawPath = new paper.Path({
          segments: [
            [3, paper.view.viewSize.height / 2],
            [paper.view.viewSize.width / 4, (paper.view.viewSize.height / 3) * 2],
            [(paper.view.viewSize.width / 4) * 2, paper.view.viewSize.height / 3],
            [(paper.view.viewSize.width / 4) * 3, (paper.view.viewSize.height / 3) * 2],
            [paper.view.viewSize.width - 3, paper.view.viewSize.height / 2]
          ],
          strokeColor: '#000000',
          strokeWidth: 5
        });

        const verticalLeftPath = new paper.Path({
          segments: [
            [5, paper.view.viewSize.height],
            [5, 0]
          ],
          strokeColor: '#000000',
          strokeWidth: 5,
        });

        const verticalRightPath = new paper.Path({
          segments: [
            [paper.view.viewSize.width - 5, paper.view.viewSize.height],
            [paper.view.viewSize.width - 5, 0]
          ],
          strokeColor: '#000000',
          strokeWidth: 5,
        });

        paper.view.onResize = function (event) {

          horizontalSawPath.segments[0].point.x = 3;
          horizontalSawPath.segments[0].point.y = paper.view.viewSize.height / 2;
          horizontalSawPath.segments[1].point.x = paper.view.viewSize.width / 4;
          horizontalSawPath.segments[1].point.y = (paper.view.viewSize.height / 3) * 2;
          horizontalSawPath.segments[2].point.x = (paper.view.viewSize.width / 4) * 2;
          horizontalSawPath.segments[2].point.y = paper.view.viewSize.height / 3;
          horizontalSawPath.segments[3].point.x = (paper.view.viewSize.width / 4) * 3;
          horizontalSawPath.segments[3].point.y = (paper.view.viewSize.height / 3) * 2;
          horizontalSawPath.segments[4].point.x = paper.view.viewSize.width - 3;
          horizontalSawPath.segments[4].point.y = paper.view.viewSize.height / 2;

          verticalLeftPath.segments[0].point.x = 5;
          verticalLeftPath.segments[1].point.x = 5;

          verticalRightPath.segments[0].point.x = paper.view.viewSize.width - 5;
          verticalRightPath.segments[1].point.x = paper.view.viewSize.width - 5;

          paper.view.red
        };

      };
    };

    setMainMargin() {
      if(this.elements.header && this.elements.main) {
        this.widgets.elementResizeObserver = new ResizeObserver(entries => {
        // this will get called whenever div dimension changes
        this.elements.main.style.marginTop = `${this.elements.header.offsetHeight}px`;
        });
        this.widgets.elementResizeObserver.observe(this.elements.header);
      }
    };

    initResize() {
      // this.initCanvas;
      this.setMainMargin;
    };
    
  };
  
  const hodworksSite = new HWSite();

  console.log(hodworksSite);
});
