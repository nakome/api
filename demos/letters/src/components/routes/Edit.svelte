<script>
  import { push,link } from "svelte-spa-router";
  // controllers
  import DbConnect from "../../controllers/api";
  // config
  import Config from "../../storage/Config";
  // ux components
  import Notification from "../ux/Notification.svelte";

  // notification values
  let nActive = "";
  let nTitle = "";
  let nDesc = "";
  let nType = "";

  // export params
  export let params;

  // get api data
  let {address,subject,date,text,closing,name} = getData();

  /**
   * Update data
   */
  async function updateData() {
    const resp = await DbConnect.update("letters", params.uid, {
      content: data,
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

  /**
   * Get data
   */
  async function getData() {
    const resp = await DbConnect.get("letters", `uid=${params.uid}`);
    data = JSON.parse(resp.DATA.content);
    return data;
  }
</script>

<header>
  <section class="card">
    <button class="btn" on:click={updateData}>Save</button>
    <a class="btn" href="/" use:link>Back</a>
  </section>
</header>

<main class="letter">
  <header class="header">
    <section class="address">
      <section class="from">
        <span class="name">{Config.name}</span>
        <span class="street">{Config.street}</span>
        <span class="city">{Config.city}</span>
        {#if Config.country}
          <span class="country">{Config.country}</span>
        {/if}
      </section>
      <section class="to" contenteditable bind:innerHTML={address}>
        {address}
      </section>
    </section>
  </header>

  <main class="main">
    <section class="subject" contenteditable bind:innerHTML={subject}>
      {subject}
    </section>
    <section class="date" contenteditable bind:innerHTML={date}>
      {date}
    </section>
    <section class="text" id="editor" contenteditable bind:innerHTML={text}>
      {text}
    </section>
    <section class="signature">
      <span class="closing" contenteditable bind:innerHTML={closing}>
        {closing}
      </span>
      <span class="name" contenteditable bind:innerHTML={name}>
        {name}
      </span>
      {#if Config.signature}
        <img src={Config.signature} alt="signature" />
      {/if}
    </section>
  </main>

  <footer class="footer">
    <section class="address">
      <span class="name">{Config.name}</span>
      <span class="street">{Config.street}</span>
      <span class="city">{Config.city}</span>
      {#if Config.country}
        <span class="country">{Config.country}</span>
      {/if}
    </section>

    <section class="contact">
      {#if Config.phone}
        <section class="phone">
          <span class="label">{Config.labels.phone}</span>
          {Config.phone}
        </section>
      {/if}

      {#if Config.email}
        <section class="email">
          <span class="label">{Config.labels.email}</span>
          {Config.email}
        </section>
      {/if}

      {#if Config.website}
        <section class="website">
          <span class="label">{Config.labels.website}</span>
          {Config.website}
        </section>
      {/if}
    </section>

    {#if Config.bank}
      <section class="bank">
        {#if Config.bank}
          <section class="name">
            <span class="label">{Config.labels.bank}</span>
            {Config.bank}
          </section>
        {/if}

        {#if Config.iban}
          <section class="name">
            <span class="label">{Config.labels.iban}</span>
            {Config.iban}
          </section>
        {/if}

        {#if Config.bic}
          <section class="name">
            <span class="label">{Config.labels.bic}</span>
            {Config.bic}
          </section>
        {/if}
      </section>
    {/if}

    {#if Config.vatId || Config.taxId}
      <section class="info">
        {#if Config.vatId}
          <section class="name">
            <span class="label">{Config.labels.vatId}</span>
            {Config.vatId}
          </section>
        {/if}

        {#if Config.taxId}
          <section class="name">
            <span class="label">{Config.labels.taxId}</span>
            {Config.taxId}
          </section>
        {/if}
      </section>
    {/if}
  </footer>
</main>

<Notification active={nActive} title={nTitle} desc={nDesc} type={nType} />

<style>
  .letter {
    position: relative;
    display: block;
    background: var(--light-1);
    width: 210mm;
    height: 297mm;
    padding: 20mm;
    margin: 0 auto;
  }
  .letter:before,
  .letter:after {
    position: absolute;
    content: "";
    left: 0;
    width: 5mm;
    height: 0;
    border-bottom: 1px solid var(--light-3);
  }
  .letter:before {
    top: 105mm;
  }
  .letter:after {
    top: 200mm;
  }
  .address {
    font-style: normal;
  }
  .from {
    display: block;
    margin-bottom: 14pt;
  }
  .from > * {
    font-size: 7pt;
  }
  .from > *:after {
    content: "|";
    padding: 0 1pt 0 4pt;
  }
  .from > *:last-child:after {
    display: none;
  }
  .to {
    display: block;
  }
  .header {
    position: absolute;
    top: 25mm;
  }
  .main {
    position: absolute;
    top: 75mm;
    left: 20mm;
    right: 20mm;
  }
  .subject {
    display: block;
    margin-bottom: 28pt;
    margin-right: 40mm;
    font-weight: bold;
  }
  .date {
    position: absolute;
    top: 0;
    right: 0;
  }
  .text {
    display: block;
    margin-bottom: 14pt;
  }
  .signature {
    display: block;
    padding-top: 14pt;
  }
  .signature .closing {
    display: block;
    font-style: italic;
  }
  .signature .name {
    display: block;
    margin-bottom: 14pt;
    font-weight: bold;
  }
  .signature img {
    display: block;
    height: 42pt;
  }
  .footer {
    position: absolute;
    bottom: 20mm;
    left: 20mm;
    right: 20mm;
    display: flex;
  }
  .footer * {
    font-size: 7pt;
  }
  .footer > * {
    flex-grow: 1;
  }
  .footer > * > * {
    display: block;
  }
  .footer .label {
    color: var(--black-3);
    display: inline-block;
    width: 10mm;
  }
  .footer .address .name {
    font-weight: 600;
  }

  .card {
    max-width: 35mm;
    margin: 2mm;
    padding: 2mm;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
  }

  a,.btn {
    display: inline-block;
    padding: 3mm;
    line-height: 3mm;
    cursor: pointer;
    text-transform: capitalize;
    text-decoration:none;
    background: var(--blue-2);
    border: 1px solid var(--blue-3);
    color: var(--blue-1) !important;
    margin-bottom: 2mm;
    border-radius: 0.5mm;
    transition:all 500ms ease;
  }
  a:hover,
  a:focus,
  .btn:hover,
  .btn:focus{
    background: var(--blue-1);
    border: 1px solid var(--blue-2);
    color: var(--blue-3) !important;
    transition:all 500ms ease;
  }

  a:last-child {
    background: var(--red-3);
    border: 1px solid var(--red-3);
    color: var(--red-1)!important;
  }

  a:last-child:hover,
  a:last-child:focus {
    background: var(--red-1);
    border: 1px solid var(--red-3);
    color: var(--red-3)!important;
  }

</style>
