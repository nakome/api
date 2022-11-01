/**
 * Api
 *
 * <code>
 *  const Api = new Api({
 *    url: "",
 *    token: ""
 *  });
 *  Api.create('testing')
 *  Api.insert('texting', { title: 'hello world', public: 1 })
 *  Api.drop('texting')
 *  Api.export('texting')
 *  Api.filter('texting', 'created')
 *  Api.create('testing')
 *  Api.insert('testing', { title: 'hello world', public: 1 })
 *  Api.insert('testing', { title: 'hello world 2', public: 1 })
 *  Api.insert('testing', { title: 'hello world 3', public: 0 })
 *  Api.insert('testing', { title: 'hello world 4', public: 0 })
 *  Api.insert('testing', { title: 'hello world 5', public: 1 })
 *  Api.update('testing', 1, { title: 'hello world 1' })
 *  Api.get('testing', 'uid=1')
 *  Api.get('testing', 'public=1')
 *  Api.export('testing')
 *  Api.filter('testing', 'created')
 *  Api.delete('testing', {uid:'1', token: '2412c2b6a05e6294b7952b0fefa645bc'})
 *  Api.drop('testing')
 *  Api.log('show')
 *  Api.log('clean')
 *  Api.token('generate')
 * </code>
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
   * Log info
   *
   * @param string params
   * @returns
   */
  log(params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/log/${params}`;
    const config = {
      method: "GET",
      headers: this.headers(),
    };
    return this.fetchDataText(url, config);
  }

  /**
   * Token options
   *
   * @param string params
   * @returns
   */
  token(params) {
    const urlBase = this.config.url;
    const url = `${urlBase}/token/${params}`;
    const config = {
      method: "GET",
      headers: this.headers(),
    };
    return this.fetchDataText(url, config);
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
}

/**
 * Init api
 */
const DbConnect = new Api({
  url: "http://localhost:8080/v2",
  token: "e856285fd7c4c0635af8d47c276e09",
});

export default DbConnect;