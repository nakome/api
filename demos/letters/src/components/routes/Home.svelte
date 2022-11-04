<script>
  import { onMount } from "svelte";
  import { link } from "svelte-spa-router";

  // controllers
  import DbConnect from "../../controllers/api";
  // ux components
  import Info from "../ux/Info.svelte";
  import Loading from "../ux/Loading.svelte";
  import Card from "../ux/Card.svelte";
  import Table from "../ux/Table.svelte";


  // config
  import { getContext } from "svelte";
  const config = getContext("config");

  let data = [];
  let limit = 6;
  let total;
  let offset = 0;
  let loading = false;

  onMount(() => getTable(limit, 0));

  function handlePagination(pages,num) {
    getTable(pages, num);
  }

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
  async function getTable(limit, offset) {
    const resp = await DbConnect.get(
      "letters",
      `all=1&limit=${limit}&offset=${offset}`
    );
    data = resp;
    total = data.TOTAL;
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
  <Loading msg="Loading..." />
{:else}
  {#await data}
    <Loading msg="Loading data..." />
  {:then}
    {#if data.STATUS === "666"}
      <Info msg={data.MESSAGE}>
        <button on:click={handleCreateTable}>Create</button>
      </Info>
    {:else if data.STATUS === 200}
      <Card>
        <a class="btn" use:link href="/new">create a new Letter</a>
        <Table {data} {total} {offset} {limit} {handlePagination}/>
      </Card>
    {:else}
      <Info msg={data.MESSAGE}>
        <p>Would you like to <a use:link href="/new">create a new Letter</a></p>
      </Info>
    {/if}
  {/await}
{/if}

<style>
  .btn {
    display: inline-block;
    padding: 3mm;
    line-height: 3mm;
    cursor: pointer;
    text-transform: capitalize;
    text-decoration: none;
    background: var(--black-2);
    border: 1px solid var(--black-3);
    color: var(--light-1);
    margin-bottom: 2mm;
    border-radius: 0.5mm;
    transition: all 500ms ease;
  }
  .btn:hover,
  .btn:focus {
    background: var(--light-1);
    border: 1px solid var(--black-2);
    color: var(--black-3);
    transition: all 500ms ease;
  }
</style>
