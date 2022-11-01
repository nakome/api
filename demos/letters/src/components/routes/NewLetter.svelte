<script>
  import DbConnect from "../../controllers/api";
  import { push, link } from "svelte-spa-router";

  // ux components
  import Notification from "../ux/Notification.svelte";
  import Card from "../ux/Card.svelte";

  // notif values
  let nActive = "";
  let nTitle = "";
  let nDesc = "";
  let nType = "";

  let title = "";
  let description = "";

  /**
   * Save letter
   */
  function saveLetter() {
    let data = {
      title: title,
      description: description,
      content: {
        address:
          "Acme Corp.Sesame<div>street 2312345 </div><div>Gotham City</div><div>USA</div>",
        subject: "Subject jkhljh",
        date: "30 October 2022",
        closing: "Redgards",
        name: "Jhon Doe DAFD",
        text: "<div><br></div><div>Dear\u2026<br></div><div><br></div><div><div>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.</div></div>",
      },
    };
    if (data.title !== "" && data.description !== "") {
      DbConnect.insert("letters", data).then((r) => {
        if (r.STATUS === "200") {
          nActive = true;
          nTitle = `Success ${r.STATUS}`;
          nDesc = r.MESSAGE;
          nType = "success";
          let w = setTimeout(() => {
            nActive = false;
            nTitle = "";
            nDesc = "";
            nType = "";
            push("/");
            clearTimeout(w);
          }, 2000);
        } else if (r.STATUS === "400") {
          nActive = true;
          nTitle = `Error ${r.STATUS}`;
          nDesc = r.MESSAGE;
          nType = "error";
          let w = setTimeout(() => {
            nActive = false;
            nTitle = "";
            nDesc = "";
            nType = "";
            clearTimeout(w);
          }, 2000);
        }
      });
    }
    return false;
  }
</script>

<Card>
  <form class="form" on:submit|preventDefault={saveLetter}>
    <div>
      <label for="title">Title</label>
      <input type="text" name="title" bind:value={title} required />
    </div>
    <div>
      <label for="description">Description</label>
      <textarea name="description" bind:value={description} required />
    </div>
    <div>
      <button class="btn" type="submit">Save</button>
      <a class="btn" href="/" use:link>Back</a>
    </div>
  </form>
</Card>

<Notification active={nActive} title={nTitle} desc={nDesc} type={nType} />

<style>
  label,
  input {
    display: block;
  }

  input,
  button,
  textarea {
    padding: 5px 15px;
    margin-bottom: 10px;
  }

  textarea {
    max-width: 100%;
  }

  input,
  textarea {
    background: var(--light-1);
    border: 1px solid var(--blue-2);
    color: var(--black-1);
  }
  input:focus,
  textarea:focus {
    border: 1px solid var(--blue-3);
    outline: 1px solid var(--light-3);
    background:var(--blue-1);
  }

  input,
  textarea {
    width: 50mm;
  }
  textarea {
    height: 50mm;
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
