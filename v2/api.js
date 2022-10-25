/**
 * Api
 *
 * 
 * <code>
 *     const Api =  new Api({
 *       url: "url of api", 
 *       token: "php api config token",
 *     });
 *    Api.create('testing').then(r => A.debug('Create Table',r));
 *    Api.insert('testing',{title: 'hello world',public: 1}).then(r => A.debug('Insert data',r));
 *    Api.update('testing',1,{title: 'Hello World}).then(r => A.debug('Update data',r));
 *    Api.get('testing','uid=1').then((r) => A.debug('Get data',r));
 *    Api.get('testing','public=1').then((r) => A.debug('Get data',r));
 *    Api.get('testing','category=demo').then((r) => A.debug('Get data',r));
 *    Api.get('testing','updated=2022').then((r) => A.debug('Get data',r));
 *    Api.delete('testing',1).then(r => A.debug('Delete data',r));
 *    Api.export('testing').then(r =>console.log(r))
 *    Api.filter('testing','created').then(r=> A.debug('Get all created date',r));
 * </code>
 * 
 * 
 * Table structure
 * =================
 * @param int uid
 * @param string name
 * @param string desc
 * @param bool public
 * @param string category
 * @param json content
 * @param string token
 * @param timestamp date
 * @param timestamp updated
 * =================
 */
class Api {
  /**
   * Constructor
   *
   * @param object config
   */
  constructor(config) {
    // Config Options
    this.config = {
      url: config.url ? config.url : "",
      token: config.token ? config.token : "",
    };
  }

  /**
   * Export
   *
   * @param string dbname
   * @returns object
   */
  export(dbname) {
    const urlBase = this.config.url;
    const url = `${urlBase}/export/${dbname}`;
    const config = {
        method: "POST",
        headers: this.headers(),
      };
    return this.fetchDataText(url, config);
  }

  /**
   * Create table
   * @param string dbname
   * @returns object
   */
  create(dbname) {
    const urlBase = this.config.url;
    const url = `${urlBase}/create/${dbname}`;
    const config = {
        method: "POST",
        headers: this.headers(),
      };
    return this.fetchData(url, config);
  }

  /**
   * Get
   *
   * @param string dbname
   * @param object params
   * @returns object
   */
  get(dbname, params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/get/${dbname}/?${params}`;
    const config = {
        method: "GET",
        headers: this.headers(),
      };
    return this.fetchData(url, config);
  }

  /**
   * filter
   *
   * @param string dbname
   * @param object params
   * @returns object
   */
  filter(dbname, params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/filter/${dbname}/?filter=${params}`;
    const config = {
      method: "GET",
      headers: this.headers(),
    };
    return this.fetchData(url, config);
  }

  /**
   * Insert
   *
   * @param string dbname
   * @param object params
   * @returns
   */
  insert(dbname, params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/insert/${dbname}`;
    const config = {
      method: "POST",
      body: JSON.stringify(params),
      headers: this.headers(),
    };
    return this.fetchData(url, config);
  }

  /**
   * Update
   *
   * @param string dbname
   * @param int uid
   * @param object params
   * @returns object
   */
  update(dbname, uid, params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/update/${dbname}/?uid=${uid}`;
    const config = {
      method: "POST",
      body: JSON.stringify(params),
      headers: this.headers(),
    };
    return this.fetchData(url, config);
  }

  /**
   * Delete table
   *
   * @param string dbname
   * @param array params
   * @returns object
   */
  delete(dbname, params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/delete/${dbname}`;
    const config = {
      method: "POST",
      body: JSON.stringify(params),
      headers: this.headers(),
    };
    return this.fetchData(url, config);
  }

  /**
   * Drop table
   *
   * @param string dbname
   * @param array params
   * @returns object
   */
  drop(dbname, params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/drop/${dbname}`;
    const config = {
      method: "POST",
      body: JSON.stringify(params),
      headers: this.headers(),
    };
    return this.fetchData(url, config);
  }


  /**
   * Json headers
   *
   * @returns json
   */
  headers() {
    return {
      "Content-type": "application/json; charset=UTF-8",
      Authorization: `Bearer ${this.config.token}`,
    };
  }

  /**
   * Debug
   *
   * @param string name
   * @param object data
   */
  debug(name, data) {
    let txt = name ? name : "info";
    console.clear();
    console.time(name);
    console.log(`[====== ${name} ======]`);
    console.log(JSON.stringify(data, null, 2));
    console.log("[=====================]");
    console.timeEnd(name);
  }

  /**
   * Fetch data
   *
   * @param string url
   * @param object config
   * @returns object
   */
  async fetchData(url, config) {
    const response = await fetch(url, config);
    const output = response.json();
    return output ? output : {};
  }

  /**
   * Fetch data text
   *
   * @param string url
   * @param object config
   * @returns object
   */
  async fetchDataText(url, config) {
    const response = await fetch(url, config);
    const output = response.text();
    return output ? output : {};
  }


  /**
   * Sleep
   *
   * @param int milliseconds
   * @return promise
   */
  sleep(milliseconds){
    return new Promise(resolve => setTimeout(resolve, milliseconds))
  }
}


