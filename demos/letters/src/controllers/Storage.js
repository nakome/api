/**
 * Storage theme settings
 *
 * set Storage.val = {color: 'blue'}
 * get Storage.val
 */
 const Storage = {
    get val() {
      this.data = window.localStorage.getItem("theme_settings");
      return JSON.parse(this.data);
    },
    set val(value) {
      this.data = JSON.stringify(value);
      window.localStorage.setItem("theme_settings", this.data);
    },
  };
  
  export default Storage;
  