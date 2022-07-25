document.addEventListener("DOMContentLoaded", function(){
  // Handler when the DOM is fully loaded
  // console.log('js executed...');
  // console.log('test');

  class HWSite {
    constructor() {
      if (HWSite._instance) {
        return HWSite._instance
      }
      HWSite._instance = this
  
      // ... Your rest of the constructor code goes after this
      this.elements = {
        languageSelector: document.getElementById('hodworks_language_selector'),
        menuButton: document.getElementById('hodworks_menu_button')
      }

      this.bindEvents();
    };

    bindEvents() {
      if(!this.elements.menuButton) return;
      this.elements.menuButton.addEventListener('click', (e) => {
        e.currentTarget.classList.toggle('is-active');
      });
    };
  };
  
  const hodworksSite = new HWSite();

  console.log(hodworksSite);
});
