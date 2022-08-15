import lazySizes from 'lazysizes';
import 'lazysizes/plugins/blur-up/ls.blur-up';
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
        languageSelector: document.getElementById('hodworks_language_selector'),
        menuButton: document.getElementById('hodworks_menu_button'),
        piecesCurrentContainer: document.getElementById('hw_pieces_current_container'),
        piecesCurrentImageContainer: document.getElementById('hw_pieces_current_image_container'),
        piecesCurrentTitle: document.getElementById('hw_pieces_current_title'),
        piecesPastContainer: document.getElementById('hw_pieces_past_container'),
        piecesPastImageContainer: document.getElementById('hw_pieces_past_image_container'),
        piecesPastTitle: document.getElementById('hw_pieces_past_title'),
        companyYearList: document.getElementById('hw_company_list'),
        calendarYearsList: document.getElementById('hw_calendar_years'),
        calendarTablesContainer: document.getElementById('hw_calendar_tables')
      }

      this.bindEvents();
    };

    bindEvents() {
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
    };
  };
  
  const hodworksSite = new HWSite();

  console.log(hodworksSite);
});
