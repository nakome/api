<script>
  import { link } from "svelte-spa-router";

  // controllers
  import DbConnect from "../../controllers/api";
  // ux components
  import Info from "../ux/Info.svelte";
  import Loading from "../ux/Loading.svelte";
  import Card from "../ux/Card.svelte";

  // config
  import { getContext } from "svelte";
  const config = getContext("config");

  let data = [];
  let loading = false;

  getTable();

  /**
   * Handle button create
   */
  function handleCreateTable() {
    loading = false;
    createTable();
  }

  /**
   * Get table
   */
  async function getTable() {
    const resp = await DbConnect.get("letters", "all=1");
    data = resp;
    loading = true;
  }

  /**
   * Create table
   */
  async function createTable() {
    const resp = await DbConnect.create("letters");
    data = resp;
    loading = true;
    getTable();
  }
</script>

{#if !loading}
  <Loading msg="Processing.."/>
{:else}
  {#await data}
    <Loading msg="Loading data..."/>
  {:then}
    {#if data.STATUS === "666"}
      <Info msg={data.MESSAGE}>
        <button on:click={handleCreateTable}>Create</button>
      </Info>
    {:else if data.STATUS === 200}
      <Card>
        <a class="btn" use:link href="/new">create a new Letter</a>
        <section class="table-responsive">
          <table>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Description</th>
              <th>Update</th>
              <th>Options</th>
            </tr>

            {#each data.DATA as letter}
              <tr>
                <td>{letter.uid}</td>
                <td>{letter.title}</td>
                <td>{letter.description}</td>
                <td>{letter.updated}</td>
                <td>
                  <a use:link href={`/edit/${letter.uid}`}>Edit</a>
                  <a use:link href={`/delete/${letter.uid}/${letter.token}`}
                    >Delete</a
                  >
                </td>
              </tr>
            {/each}
          </table>
        </section>
      </Card>
    {:else}
      <Info msg={data.MESSAGE}>
        <p>Would you like to <a use:link href="/new">create a new Letter</a></p>
      </Info>
    {/if}
  {/await}
{/if}

<style>
  a {
    color: var(--red-2);
    font-weight: bold;
    padding-bottom: 1px;
    border-bottom: 2px solid var(--red-3);
    text-decoration: none;
    transition: color 500ms ease;
  }
  a:hover,
  a:focus {
    color: var(--red-3);
    transition: color 500ms ease;
  }

  table,
  td,
  th {
    border: 1px solid var(--light-3);
    text-align: left;
  }

  th {
      background: var(--light-3);
      border: 1px solid var(--light-2);
  }
  td {
      background: var(--light-1);
  }

  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 5mm;
  }

  th,
  td {
    padding: 2mm;
  }

  table a,.btn {
    display: inline-block;
    padding: 3mm;
    line-height: 3mm;
    cursor: pointer;
    text-transform: capitalize;
    background: var(--blue-2);
    border: 1px solid var(--blue-3);
    color: var(--blue-1) !important;
    margin-bottom: 2mm;
    border-radius: 0.5mm;
    transition:all 500ms ease;
  }
  table a:hover,
  table a:focus,
  .btn:hover,
  .btn:focus{
    background: var(--blue-1);
    border: 1px solid var(--blue-2);
    color: var(--blue-3) !important;
    transition:all 500ms ease;
  }

  table a:last-child {
    background: var(--red-3);
    border: 1px solid var(--red-3);
    color: var(--red-1)!important;
  }

  table a:last-child:hover,
  table a:last-child:focus {
    background: var(--red-1);
    border: 1px solid var(--red-3);
    color: var(--red-3)!important;
  }

  .table-responsive {
    overflow-x: auto;
  }
</style>
