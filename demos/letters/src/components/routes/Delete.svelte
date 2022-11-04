<script>
  import { push, link } from "svelte-spa-router";
  // controllers
  import DbConnect from "../../controllers/api";
  // ux components
  import Notification from "../ux/Notification.svelte";
  import Info from "../ux/Info.svelte";

  // notif values
  let nActive = "";
  let nTitle = "";
  let nDesc = "";
  let nType = "";
  // export params
  export let params;

  /**
   * Remove data
   */
  async function removeData() {
    const resp = await DbConnect.delete("letters", {
      uid: params.uid,
      token: params.token,
    });
    if (resp.STATUS === "200") {
      nActive = true;
      nTitle = `Success ${resp.STATUS}`;
      nDesc = resp.MESSAGE;
      nType = "success";
      let w = setTimeout(() => {
        nActive = false;
        nTitle = "";
        nDesc = "";
        nType = "";
        push("/");
        clearTimeout(w);
      }, 2000);
    } else if (resp.STATUS === "400") {
      nActive = true;
      nTitle = `Error ${resp.STATUS}`;
      nDesc = resp.MESSAGE;
      nType = "error";
      let w = setTimeout(() => {
        nActive = false;
        nTitle = "";
        nDesc = "";
        nType = "";
        clearTimeout(w);
      }, 2000);
    }
  }
</script>

<Info msg="Do you wish to delete this letter">
  <button type="button" on:click={removeData}>Delete</button>
  <a href="/" use:link>Back</a>
</Info>

<Notification active={nActive} title={nTitle} desc={nDesc} type={nType} />

<style>
  button,
  a {
    font-weight: bold;
    padding: 0.5rem 1rem;
    background: var(--blue-2);
    border: 1px solid var(--blue-3);
    color: var(--blue-1);
    cursor:pointer;
  }
  a {
    display: inline-block;
    text-decoration: none;
    background: var(--red-3);
    border: 1px solid var(--red-3);
    color: var(--red-1);
  }
</style>
