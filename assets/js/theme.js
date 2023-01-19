class Theme {
  /**
   * The constructor creates the singleton and binds the docready event.
   *
   * @return {Theme} Either the instance of the class or nothing.
   */
  constructor() {
    if (instance) {
      return instance;
    }

    // Initialize the controller maps.
    this._templateControllers = {};
    this._globalControllers = {};

    // Load controllers.
    this.setGlobalControllers();
    this.setTemplateControllers();

    this.init();

    // Bind run controllers on document ready.
    document.addEventListener('DOMContentLoaded', (e) => this.runDocReady(e));

    const instance = this;
  }

  /**
   * Runs the 'init' function for all included scripts.
   *
   * @return {void}
   */
  init() {
    // Run all global scripts.
    for (const className in this._globalControllers) {
      if (!this._globalControllers.hasOwnProperty(className)) {
        continue;
      }
      if (typeof this._globalControllers[className].init === 'function') {
        this._globalControllers[className].init();
      }
    }

    // Run template-specific scripts
    for (const className in this._templateControllers) {
      if (!this._templateControllers.hasOwnProperty(className)) {
        continue;
      }
      if (Theme.documentHasClass(className) &&
        typeof this._templateControllers[className].init === 'function'
      ) {
        this._templateControllers[className].init();
      }
    }
  }

  /**
   * A getter for all controllers.
   *
   * @return {Object} A hash map of all controllers.
   */
  get controllers() {
    return this._templateControllers.concat(this._globalControllers);
  }

}